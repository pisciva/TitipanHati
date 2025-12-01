<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:menunggu_penjemputan,dalam_perjalanan,selesai,dibatalkan',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'notes.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }
}

