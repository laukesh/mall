<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CompanyImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Company([
            'name' => $row['name'],
            'company_name' => $row['company_name'],
            'call_code' => $row['call_code'] ?? null,
            'office_email' => $row['office_email'] ?? null,
            'office_mobile' => $row['office_mobile'] ?? null,
            'office_phone' => $row['office_phone'] ?? null,
            'contact_person' => $row['contact_person'] ?? null,
            'contact_person_mobile' => $row['contact_person_mobile'] ?? null,
            'contact_person_email' => $row['contact_person_email'] ?? null,
            'address' => $row['address'] ?? null,
            'state' => $row['state'] ?? null,
            'city' => $row['city'] ?? null,
            'pincode' => $row['pincode'] ?? null,
            'gst_no' => $row['gst_no'] ?? null,
            'gst_status' => $row['gst_status'] ?? null,
            'status' => $row['status'] ?? 1,
            'remarks' => $row['remarks'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'office_email' => 'nullable|email',
            'office_mobile' => 'nullable|string|max:20',
            'contact_person_mobile' => 'nullable|string|max:20',
            'contact_person_email' => 'nullable|email',
            'gst_no' => 'nullable|string|max:50',
            'status' => 'nullable|in:0,1',
        ];
    }
}