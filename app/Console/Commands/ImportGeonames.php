<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Pincode;
use Illuminate\Support\Str;

class ImportGeonames extends Command
{
    protected $signature = 'locations:import {--skip-postal}';
    protected $description = 'Import countries, states, cities and postal codes from GeoNames dumps (may be large).';

    protected $tmpDir;

    public function __construct()
    {
        parent::__construct();
        $this->tmpDir = storage_path('app/geonames');
    }

    public function handle()
    {
        @mkdir($this->tmpDir, 0755, true);

        $this->info('Downloading countryInfo.txt...');
        $countryInfo = $this->download('http://download.geonames.org/export/dump/countryInfo.txt', 'countryInfo.txt');

        $this->info('Downloading admin1CodesASCII.txt...');
        $admin1 = $this->download('http://download.geonames.org/export/dump/admin1CodesASCII.txt', 'admin1CodesASCII.txt');

        $this->info('Downloading allCountries.zip (cities) — this may be very large...');
        $allCountriesZip = $this->download('http://download.geonames.org/export/dump/allCountries.zip', 'allCountries.zip');

        $this->unzip($allCountriesZip, $this->tmpDir);

        $allCountriesFile = $this->tmpDir . '/allCountries.txt';

        $this->info('Importing countries...');
        $this->importCountries($this->tmpDir . '/countryInfo.txt');

        $this->info('Importing states...');
        $this->importStates($this->tmpDir . '/admin1CodesASCII.txt');

        $this->info('Importing cities (this may take a long time)...');
        $this->importCities($allCountriesFile);

        if (! $this->option('skip-postal')) {
            $this->info('Downloading postal code dump (allCountries.zip for postal) — may be large...');
            $postalZip = $this->download('http://download.geonames.org/export/zip/allCountries.zip', 'postal_allCountries.zip');
            $this->unzip($postalZip, $this->tmpDir);
            $this->info('Importing postal codes...');
            $this->importPostal($this->tmpDir . '/allCountries.txt');
        }

        $this->info('Import completed.');
        return 0;
    }

    protected function download($url, $filename)
    {
        $path = $this->tmpDir . '/' . $filename;

        if (file_exists($path)) {
            $this->info("Using cached file: {$path}");
            return $path;
        }

        $this->info("Downloading: {$url}");

        $fp = fopen($path, 'w');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        return $path;
    }

    protected function unzip($zipPath, $dest)
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($dest);
            $zip->close();
            return true;
        }
        return false;
    }

    protected function importCountries($file)
    {
        if (! file_exists($file)) return;

        $handle = fopen($file, 'r');
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '' || Str::startsWith($line, '#')) continue;
            $cols = preg_split('/\t+/', $line);
            // Format: ISO,ISO3,ISO-Numeric,FIPS,Country,Capital,Area(in sq km),Population,Continent,tld,CurrencyCode,LanguageCodes,geonameid
            // But columns may vary; refer to GeoNames countryInfo.txt format
            $iso = $cols[0] ?? null;
            $iso3 = $cols[1] ?? null;
            $numeric = $cols[2] ?? null;
            $fips = $cols[3] ?? null;
            $name = $cols[4] ?? null;
            $capital = $cols[5] ?? null;
            $phone = $cols[10] ?? null;
            $currency = $cols[10] ?? null; // best-effort; countryInfo has currency at 10

            Country::updateOrCreate(
                ['iso2' => $iso],
                ['name' => $name, 'iso3' => $iso3, 'numeric_code' => $numeric, 'phone_code' => $phone, 'capital' => $capital, 'currency' => $currency]
            );
        }
        fclose($handle);
    }

    protected function importStates($file)
    {
        if (! file_exists($file)) return;
        $handle = fopen($file, 'r');
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '') continue;
            // Format: <countryCode>.<admin1Code>\t<alternateName>\t<asciiName>
            [$code, $name] = preg_split('/\t/', $line) + [null, null];
            if (! $code) continue;
            $parts = explode('.', $code);
            if (count($parts) !== 2) continue;
            [$cc, $admin1] = $parts;
            $country = Country::where('iso2', $cc)->first();
            if (! $country) continue;
            State::updateOrCreate(
                ['country_id' => $country->id, 'code' => $admin1],
                ['name' => $name ?: $admin1]
            );
        }
        fclose($handle);
    }

    protected function importCities($file)
    {
        if (! file_exists($file)) return;
        $handle = fopen($file, 'r');
        $bar = $this->output->createProgressBar();
        $count = 0;
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '') continue;
            $cols = explode("\t", $line);
            // geonameid name asciiname alternatenames latitude longitude feature class ... country code ... admin1 code ... population
            $name = $cols[1] ?? null;
            $lat = $cols[4] ?? null;
            $lng = $cols[5] ?? null;
            $countryCode = $cols[8] ?? null;
            $admin1 = $cols[10] ?? null;
            $population = isset($cols[14]) ? (int)$cols[14] : null;

            $country = Country::where('iso2', $countryCode)->first();
            if (! $country) continue;

            $state = null;
            if ($admin1) {
                $state = State::where('country_id', $country->id)->where('code', $admin1)->first();
            }

            City::updateOrCreate(
                ['country_id' => $country->id, 'state_id' => $state ? $state->id : null, 'name' => $name],
                ['latitude' => $lat, 'longitude' => $lng, 'population' => $population]
            );

            $count++;
            if ($count % 1000 === 0) {
                $bar->setMessage("Imported: {$count}");
            }
        }
        $bar->finish();
        fclose($handle);
    }

    protected function importPostal($file)
    {
        if (! file_exists($file)) return;
        $handle = fopen($file, 'r');
        $count = 0;
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '') continue;
            // Format: countryCode\tpostalCode\tplaceName\tadminName1\tadminCode1\tadminName2\tadminCode2\tadminName3\tadminCode3\tlatitude\tlongitude\taccuracy
            $cols = explode("\t", $line);
            $countryCode = $cols[0] ?? null;
            $postal = $cols[1] ?? null;
            $placeName = $cols[2] ?? null;
            $admin1Code = $cols[4] ?? null;
            $lat = $cols[9] ?? null;
            $lng = $cols[10] ?? null;

            $country = Country::where('iso2', $countryCode)->first();
            if (! $country) continue;

            $state = null;
            if ($admin1Code) {
                $state = State::where('country_id', $country->id)->where('code', $admin1Code)->first();
            }

            // try to match city by name and state
            $city = null;
            if ($placeName) {
                $cityQuery = City::where('country_id', $country->id)->whereRaw('LOWER(name) = ?', [strtolower($placeName)]);
                if ($state) $cityQuery->where('state_id', $state->id);
                $city = $cityQuery->first();
            }

            Pincode::updateOrCreate(
                ['country_id' => $country->id, 'code' => $postal],
                ['state_id' => $state ? $state->id : null, 'city_id' => $city ? $city->id : null, 'place_name' => $placeName, 'latitude' => $lat, 'longitude' => $lng]
            );

            $count++;
            if ($count % 1000 === 0) {
                $this->info("Imported postal: {$count}");
            }
        }
        fclose($handle);
    }
}
