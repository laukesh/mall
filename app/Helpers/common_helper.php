<?php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
if (!function_exists('formatDate')) {
    function formatDate($date) {
        return date('d-m-Y', strtotime($date));
    }
}

if (!function_exists('formatMobile')) {
    function formatMobile($mobile) {
        $mobile = preg_replace('/\D/', '', $mobile); // remove non-digits
            $mobile = substr($mobile, -10); // get last 10 digits
        return $mobile;
    }
}

 



if (!function_exists('uploadFile')) {

    function uploadFile(UploadedFile $file, string $folder = 'booking_files', string $fileTag = ''): string
    {
        $destinationPath = public_path('uploads/' . trim($folder, '/'));

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $extension = $file->getClientOriginalExtension();

        $safeName = Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) ?: 'uploads';

        $fileName = $fileTag.time() .rand(10,99).'.'. $extension;

        $file->move($destinationPath, $fileName);

        return 'uploads/' . trim($folder, '/') . '/' . $fileName;
    }
}