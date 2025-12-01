<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
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
            'deadline' => 'required|date|after:today',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'organization_id.required' => 'Yayasan/Organisasi wajib dipilih.',
            'organization_id.exists' => 'Yayasan/Organisasi tidak ditemukan.',
            'title.required' => 'Judul campaign wajib diisi.',
            'title.max' => 'Judul campaign maksimal 255 karakter.',
            'description.required' => 'Deskripsi campaign wajib diisi.',
            'description.min' => 'Deskripsi campaign minimal 50 karakter.',
            'banner.image' => 'File harus berupa gambar.',
            'banner.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'banner.max' => 'Ukuran gambar maksimal 2MB.',
            'province.required' => 'Provinsi wajib diisi.',
            'city.required' => 'Kota wajib diisi.',
            'target_quantity.required' => 'Target jumlah wajib diisi.',
            'target_quantity.min' => 'Target jumlah minimal 1.',
            'target_quantity.max' => 'Target jumlah maksimal 100000.',
            'deadline.required' => 'Deadline wajib diisi.',
            'deadline.after' => 'Deadline harus setelah hari ini.',
            'categories.required' => 'Kategori wajib dipilih.',
            'categories.min' => 'Minimal pilih 1 kategori.',
            'categories.*.exists' => 'Kategori tidak valid.',
        ];
    }
}