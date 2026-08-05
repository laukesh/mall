<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MallRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mall_code' => 'required|string|max:50|unique:malls,mall_code,' . ($this->mall->id ?? 'NULL'),
            'mall_name' => 'required|string|max:191',
            'mall_type' => 'nullable|string|max:100',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'opening_date' => 'nullable|date',
            'total_area' => 'nullable|numeric',
            'leasable_area' => 'nullable|numeric',
            'parking_capacity' => 'nullable|integer',
            'contact_person' => 'nullable|string|max:191',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:191',
            'website' => 'nullable|url|max:191',
            'status' => 'nullable|string|max:50',
        ];
    }
}
