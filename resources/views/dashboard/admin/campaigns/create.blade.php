@extends('layouts.admin')

@section('title', 'Buat Campaign Baru')

@section('content')

    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-[#1D1D1D]">Buat Campaign Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Lengkapi detail di bawah untuk meluncurkan campaign pengumpulan donasi baru.</p>
    </div>

    <!-- Success/Error Messages -->
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

    <!-- Main Form Card -->
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        
        <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Campaign Basics -->
            <div class="space-y-6 border-b border-gray-200 pb-6">
                <h3 class="text-xl font-semibold text-gray-800">Detail Dasar Campaign</h3>

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Campaign</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                    @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Organization ID --}}
                <div>
                    <label for="organization_id" class="block text-sm font-medium text-gray-700 mb-1">Organisasi Pelaksana</label>
                    <select name="organization_id" id="organization_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        <option value="" disabled selected>Pilih Organisasi</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Categories (Multi-select) --}}
                <div>
                    <label for="categories" class="block text-sm font-medium text-gray-700 mb-1">Kategori (Boleh Pilih Lebih dari Satu)</label>
                    <select name="categories[]" id="categories" multiple required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition h-40">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Gunakan CTRL/CMD untuk memilih beberapa kategori.</p>
                    @error('categories')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    @error('categories.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Banner --}}
                <div>
                    <label for="banner" class="block text-sm font-medium text-gray-700 mb-1">Banner Campaign (Max 2MB, JPG/PNG)</label>
                    <input type="file" name="banner" id="banner" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#FF4400] file:text-[#F8FAFC] hover:file:bg-gray-700">
                    @error('banner')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Section 2: Details & Targets -->
            <div class="space-y-6 border-b border-gray-200 pb-6">
                <h3 class="text-xl font-semibold text-gray-800">Target & Batas Waktu</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Target Quantity --}}
                    <div>
                        <label for="target_quantity" class="block text-sm font-medium text-gray-700 mb-1">Target Jumlah Donasi (Unit Barang)</label>
                        <input type="number" name="target_quantity" id="target_quantity" value="{{ old('target_quantity') }}" required min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        @error('target_quantity')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Deadline --}}
                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Batas Waktu Pengumpulan</label>
                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        @error('deadline')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Campaign</label>
                    <textarea name="description" id="description" rows="6" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Section 3: Location -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-800">Informasi Lokasi</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Province --}}
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <input type="text" name="province" id="province" value="{{ old('province') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        @error('province')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- City --}}
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        @error('city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-6">
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 bg-[#FF4400] text-[#F8FAFC] font-semibold rounded-xl hover:bg-gray-700 transition duration-150 shadow-md flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Campaign
                </button>
            </div>
        </form>
    </div>

@endsection