<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'selected_dates' => ['required', 'array', 'min:1'],
            'selected_dates.*' => ['date'],
            'selected_times' => ['required', 'array', 'min:1'],
            'location_answer' => ['nullable', 'string'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'email' => ['nullable', 'email', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'selected_dates' => 'Tarihler',
            'selected_times' => 'Saatler',
            'location_answer' => 'Konum Tercihi',
        ];
    }
}
