@extends('layouts.dash-admin')

@section('title', 'Tambah Organisasi Baru')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1D1D1D]">Tambah Organisasi Baru</h1>
        <p class="text-sm text-gray-500">Isi formulir di bawah ini untuk menambahkan organisasi ke database.</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        
        <form action="{{ route('admin.organizations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6"> 
                
                <div class="space-y-4 border-b pb-4">
                    <h3 class="text-xl font-semibold text-[#FF4400]"><i class="fas fa-info-circle mr-2"></i> Informasi Dasar</h3>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-300 p-3 rounded-lg focus:ring-[#FF4400] focus:border-[#FF4400] @error('name') border-red-500 @enderror"
                               placeholder="Contoh: Yayasan Sejahtera Indonesia">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full border border-gray-300 p-3 rounded-lg focus:ring-[#FF4400] focus:border-[#FF4400] @error('description') border-red-500 @enderror"
                                  placeholder="Visi dan misi singkat organisasi...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="logo_url" class="block text-sm font-medium text-gray-700 mb-1">Logo Organisasi (Max 2MB)</label>
                        <input type="file" name="logo_url" id="logo_url"
                               class="w-full border border-gray-300 p-3 rounded-lg focus:ring-[#FF4400] focus:border-[#FF4400] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#FF4400] file:text-white hover:file:bg-[#EB3F00] @error('logo_url') border-red-500 @enderror">
                        @error('logo_url')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-4 border-b pb-4">
                    <h3 class="text-xl font-semibold text-[#FF4400]"><i class="fas fa-map-marker-alt mr-2"></i> Kontak & Lokasi</h3>

                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Kontak <span class="text-red-500">*</span></label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" required
                               class="w-full border border-gray-300 p-3 rounded-lg focus:ring-[#FF4400] focus:border-[#FF4400] @error('contact_email') border-red-500 @enderror"
                               placeholder="contoh@organisasi.org">
                        @error('contact_email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Kontak</label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"
                               class="w-full border border-gray-300 p-3 rounded-lg focus:ring-[#FF4400] focus:border-[#FF4400] @error('contact_phone') border-red-500 @enderror"
                               placeholder="Contoh: 081234567890">
                        @error('contact_phone')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="address" id="address" rows="4" required
                                  class="w-full border border-gray-300 p-3 rounded-lg focus:ring-[#FF4400] focus:border-[#FF4400] @error('address') border-red-500 @enderror"
                                  placeholder="Alamat kantor pusat organisasi...">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                 <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-[#FF4400]"><i class="fas fa-shield-alt mr-2"></i> Status Admin</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex space-x-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="is_verified" value="1" class="form-radio text-[#FF4400] h-4 w-4" 
                                    {{ old('is_verified', 0) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700 font-medium">Terverifikasi</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="is_verified" value="0" class="form-radio text-[#FF4400] h-4 w-4"
                                    {{ old('is_verified', 0) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700 font-medium">Belum Terverifikasi</span>
                            </label>
                        </div>
                        @error('is_verified')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-start space-x-3">
                
                <button type="submit" class="px-5 py-2 bg-[#FF4400] text-white rounded-lg hover:bg-[#EB3F00] transition shadow-md">
                    <i class="fas fa-save mr-2"></i> Simpan Organisasi
                </button>

                <a href="{{ route('admin.organizations.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

@endsection