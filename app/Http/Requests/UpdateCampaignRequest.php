<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'target_quantity' => 'required|integer|min:1|max:100000',
            'deadline' => 'required|date',
            'status' => 'required|in:aktif,selesai',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'organization_id.required' => 'Yayasan/Organisasi wajib dipilih.',
            'title.required' => 'Judul campaign wajib diisi.',
            'description.required' => 'Deskripsi campaign wajib diisi.',
            'description.min' => 'Deskripsi campaign minimal 50 karakter.',
            'target_quantity.required' => 'Target jumlah wajib diisi.',
            'deadline.required' => 'Deadline wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'categories.required' => 'Kategori wajib dipilih.',
        ];
    }
}