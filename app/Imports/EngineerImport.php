<?php

namespace App\Imports;

use App\Models\Engineer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EngineerImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Engineer([
            'name' => $row['name'],
            'sf_id' => $row['sf_id'] ?? null,
            'mobile' => $row['mobile'] ?? null,
            'address' => $row['address'] ?? null,
            'city' => $row['city'] ?? null,
            'pincode' => $row['pincode'] ?? null,
            'status' => $row['status'] ?? 1,
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
            'sf_id' => 'nullable|exists:sf_details,id',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'status' => 'nullable|in:0,1',
            'contact_person_mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'contact_person_email' => 'nullable|email',
            'gst' => 'nullable|string|max:50',
        ];
    }
}