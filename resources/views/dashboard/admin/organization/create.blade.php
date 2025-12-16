@extends('layouts.dash-admin')

@section('title', 'Tambah Organisasi Baru')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Organisasi Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Lengkapi detail di bawah untuk menambahkan organisasi ke database.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4" role="alert">
            <p class="font-bold">Terjadi Kesalahan Validasi</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200">
        <form action="{{ route('admin.organizations.store') }}" method="POST" enctype="multipart/form-data" class="gap-6 flex flex-col">
            @csrf

            <div class="space-y-6 border-b border-gray-200 pb-8">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-orange-600"></i>
                    </div>
                    Informasi Dasar
                </h3>

                <div>
                    <label for="name" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Nama Organisasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border @error('name') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                           placeholder="Contoh: Yayasan Sejahtera Indonesia">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Deskripsi Singkat
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-3 border @error('description') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                              placeholder="Visi dan misi singkat organisasi...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="logo_url" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Logo Organisasi
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img id="logo-preview" src="https://placehold.co/120x120?text=Preview" alt="Preview Logo"
                                 class="w-24 h-24 object-cover rounded-lg border border-gray-300">
                        </div>
                        <div class="flex-1">
                            <input type="file" name="logo_url" id="logo_url" accept="image/*"
                                   class="w-full px-4 py-3 border @error('logo_url') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#FF4400] file:text-white hover:file:bg-[#DE3B00]">
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Max 2MB, Format: JPG, PNG</p>
                    @error('logo_url')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-6 border-b border-gray-200 pb-8">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                    Kontak & Lokasi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_email" class="block text-sm font-semibold text-[#FF4400] mb-2">
                            Email Kontak <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" required
                               class="w-full px-4 py-3 border @error('contact_email') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                               placeholder="contoh@organisasi.org">
                        @error('contact_email')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-semibold text-[#FF4400] mb-2">
                            Nomor Kontak <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}" required
                               class="w-full px-4 py-3 border @error('contact_phone') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                               placeholder="Contoh: 081234567890">
                        @error('contact_phone')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" id="address" rows="4" required
                              class="w-full px-4 py-3 border @error('address') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                              placeholder="Alamat kantor pusat organisasi...">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-shield-alt text-purple-600"></i>
                    </div>
                    Status Admin
                </h3>

                <div>
                    <label class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Status Verifikasi <span class="text-red-500">*</span>
                    </label>
                    <div class="flex space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="is_verified" value="1" class="w-4 h-4 text-[#FF4400] border-gray-300 focus:ring-[#FF4400]" 
                                {{ old('is_verified', 0) == 1 ? 'checked' : '' }}>
                            <span class="ml-3 text-sm font-medium text-gray-700">Terverifikasi</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="is_verified" value="0" class="w-4 h-4 text-[#FF4400] border-gray-300 focus:ring-[#FF4400]"
                                {{ old('is_verified', 0) == 0 ? 'checked' : '' }}>
                            <span class="ml-3 text-sm font-medium text-gray-700">Belum Terverifikasi</span>
                        </label>
                    </div>
                    @error('is_verified')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex space-x-3">
                <button type="submit"
                        class="px-8 py-3.5 bg-[#FF4400] text-white font-bold rounded-lg hover:bg-[#DE3B00] transition duration-200 shadow-lg hover:shadow-xl flex items-center justify-center group">
                    <i class="fas fa-save mr-3 group-hover:scale-110 transition-transform"></i>
                    Simpan Organisasi
                </button>
                <a href="{{ route('admin.organizations.index') }}" 
                   class="px-8 py-3.5 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-3"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.getElementById('logo_url');
            const logoPreview = document.getElementById('logo-preview');

            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        logoPreview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    logoPreview.src = 'https://placehold.co/120x120?text=Preview';
                }
            });
        });
    </script>

@endsection