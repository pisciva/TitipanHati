<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    public function rules(): array
    {
        return [
            'campaign_id' => 'required|exists:campaigns,id',
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'required|string|max:20',
            'donor_email' => 'required|email|max:255',
            'pickup_address' => 'required|string|max:500',
            'pickup_province' => 'required|string|max:100',
            'pickup_city' => 'required|string|max:100',
            'pickup_postal_code' => 'required|string|max:10',
            'pickup_notes' => 'nullable|string|max:1000',
            'pickup_date' => 'required|date|after:+2 days',
            'pickup_time_slot' => 'required|in:09:00-13:00,13:00-17:00',
            'items' => 'required|array|min:1',
            'items.*.gender' => 'required|in:Laki-laki (Anak),Perempuan (Anak),Laki-laki (Dewasa),Perempuan (Dewasa)',
            'items.*.item_category' => 'required|in:Atasan,Bawahan,Other',
            'items.*.quantity' => 'required|integer|min:1|max:1000',
            'items.*.condition' => 'required|in:Baru,Layak pakai,Tidak layak',
            'items.*.photo_url' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'campaign_id.required' => 'Campaign harus dipilih.',
            'campaign_id.exists' => 'Campaign tidak ditemukan.',
            'donor_name.required' => 'Nama lengkap wajib diisi.',
            'donor_phone.required' => 'Nomor telepon wajib diisi.',
            'donor_email.required' => 'Email wajib diisi.',
            'donor_email.email' => 'Format email tidak valid.',
            'pickup_address.required' => 'Alamat penjemputan wajib diisi.',
            'pickup_province.required' => 'Kota wajib diisi.',
            'pickup_city.required' => 'Kecamatan wajib diisi.',
            'pickup_postal_code.required' => 'Kode pos wajib diisi.',
            'pickup_date.required' => 'Tanggal penjemputan wajib dipilih.',
            'pickup_date.after' => 'Tanggal penjemputan minimal 3 hari dari sekarang.',
            'pickup_time_slot.required' => 'Slot waktu penjemputan wajib dipilih.',
            'pickup_time_slot.in' => 'Slot waktu tidak valid.',
            'items.required' => 'Minimal harus ada 1 barang yang didonasikan.',
            'items.min' => 'Minimal harus ada 1 barang yang didonasikan.',
            'items.*.gender.required' => 'Gender pakaian wajib dipilih.',
            'items.*.gender.in' => 'Gender pakaian tidak valid.',
            'items.*.item_category.required' => 'Kategori pakaian wajib dipilih.',
            'items.*.item_category.in' => 'Kategori pakaian tidak valid.',
            'items.*.quantity.required' => 'Jumlah barang wajib diisi.',
            'items.*.quantity.min' => 'Jumlah barang minimal 1.',
            'items.*.quantity.max' => 'Jumlah barang maksimal 1000.',
            'items.*.condition.required' => 'Kondisi barang wajib dipilih.',
            'items.*.condition.in' => 'Kondisi barang tidak valid.',
        ];
    }
}
