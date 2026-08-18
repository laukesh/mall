<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeeImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Employee([
            'name' => $row['name'],
            'mobile' => $row['mobile'] ?? null,
            'email' => $row['email'] ?? null,
            'role_id' => $row['role_id'] ?? null,
            'status' => $row['status'] ?? 1,
            'contact_person_mobile' => $row['contact_person_mobile'] ?? null,
            'contact_person_email' => $row['contact_person_email'] ?? null,
            'gst' => $row['gst'] ?? null,
            'remarks' => $row['remarks'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'nullable|in:0,1',
            'contact_person_mobile' => 'nullable|string|max:20',
            'contact_person_email' => 'nullable|email',
            'gst' => 'nullable|string|max:50',
        ];
    }
}