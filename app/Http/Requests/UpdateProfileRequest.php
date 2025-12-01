<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'default_address' => 'nullable|string|max:500',
            'default_city' => 'nullable|string|max:100',
            'default_district' => 'nullable|string|max:100',
            'default_postal_code' => 'nullable|string|max:10',
            'default_notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.max' => 'Nomor telepon maksimal 20 karakter.',
            'default_address.max' => 'Alamat maksimal 500 karakter.',
            'default_city.max' => 'Kota maksimal 100 karakter.',
            'default_district.max' => 'Kecamatan maksimal 100 karakter.',
            'default_postal_code.max' => 'Kode pos maksimal 10 karakter.',
            'default_notes.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }
}
