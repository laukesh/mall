<?php

namespace App\Imports;

use App\Models\SfModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SfDetailImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new SfDetail([
            'name' => $row['name'],
            'company_name' => $row['company_name'] ?? null,
            'address' => $row['address'] ?? null,
            'city' => $row['city'] ?? null,
            'state' => $row['state'] ?? null,
            'pincode' => $row['pincode'] ?? null,
            'lat' => $row['lat'] ?? null,
            'lng' => $row['lng'] ?? null,
            'status' => $row['status'] ?? 1,
            'mobile' => $row['mobile'] ?? null,
            'contact_person_mobile' => $row['contact_person_mobile'] ?? null,
            'email' => $row['email'] ?? null,
            'contact_person_email' => $row['contact_person_email'] ?? null,
            'gst' => $row['gst'] ?? null,
            'remarks' => $row['remarks'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'status' => 'nullable|in:0,1',
            'mobile' => 'nullable|string|max:20',
            'contact_person_mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'contact_person_email' => 'nullable|email',
            'gst' => 'nullable|string|max:50',
        ];
    }
}