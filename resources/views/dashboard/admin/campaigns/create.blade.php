@extends('layouts.dash-admin')

@section('title', 'Buat Campaign Baru')

@section('content')

    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Buat Campaign Baru</h1>
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
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
        
        <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" id="campaignForm" class="space-y-8">
            @csrf

            <!-- Section 1: Campaign Basics -->
            <div class="space-y-6 border-b border-gray-200 pb-8">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-orange-600"></i>
                    </div>
                    Detail Campaign
                </h3>

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Campaign <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-3 border @error('title') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                           placeholder="Contoh: Kumpulkan Jaket untuk Anak Yatim Piatu">
                    @error('title')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Organization ID --}}
                <div>
                    <label for="organization_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Organisasi Pelaksana <span class="text-red-500">*</span>
                    </label>
                    <select name="organization_id" id="organization_id" required
                            class="w-full px-4 py-3 border @error('organization_id') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                        <option value="" disabled selected>Pilih Organisasi</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_id')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categories (Multi-select) --}}
                <div>
                    <label for="categories" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori (Boleh Pilih Lebih dari Satu) <span class="text-red-500">*</span>
                    </label>
                    <select name="categories[]" id="categories" multiple required
                            class="w-full px-4 py-3 border @error('categories') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition h-40">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-gray-500">Gunakan CTRL/CMD untuk memilih beberapa kategori.</p>
                    @error('categories')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Banner --}}
                <div>
                    <label for="banner" class="block text-sm font-semibold text-gray-700 mb-2">
                        Banner Campaign <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img id="banner-preview" src="https://placehold.co/120x80?text=Preview" alt="Preview Banner"
                                 class="w-32 h-20 object-cover rounded-lg border border-gray-300">
                        </div>
                        <div class="flex-1">
                            <input type="file" name="banner" id="banner" accept="image/*"
                                   class="w-full px-4 py-3 border @error('banner') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#FF4400] file:text-white hover:file:bg-[#DE3B00]">
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Max 2MB, Format: JPG, PNG</p>
                    @error('banner')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 2: Details & Targets -->
            <div class="space-y-6 border-b border-gray-200 pb-8">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-bullseye text-blue-600"></i>
                    </div>
                    Target & Batas Waktu
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Target Quantity --}}
                    <div>
                        <label for="target_quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                            Target Jumlah Donasi (Unit Barang) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="target_quantity" id="target_quantity" value="{{ old('target_quantity') }}" required min="1"
                               class="w-full px-4 py-3 border @error('target_quantity') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                               placeholder="Contoh: 500">
                        @error('target_quantity')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deadline --}}
                    <div>
                        <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">
                            Batas Waktu Pengumpulan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                               class="w-full px-4 py-3 border @error('deadline') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                        @error('deadline')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Campaign <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                              class="w-full px-4 py-3 border @error('description') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                              placeholder="Jelaskan tujuan dan kebutuhan campaign ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 3: Location -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-purple-600"></i>
                    </div>
                    Informasi Lokasi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> 
                    
                    {{-- Province --}}
                    <div>
                        <label for="province" class="block text-sm font-semibold text-gray-700 mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <select name="province" id="province" required
                                class="w-full px-4 py-3 border @error('province') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                            <option value="" disabled selected>Pilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}" {{ old('province') == $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- City/Regency --}}
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kota/Kabupaten <span class="text-red-500">*</span>
                        </label>
                        <select name="city" id="city" required disabled
                                class="w-full px-4 py-3 border @error('city') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed">
                            <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                        </select>
                        @error('city')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div> 
            </div>

            <!-- Action Button -->
            <div class="pt-8">
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3.5 bg-[#FF4400] text-white font-bold rounded-lg hover:bg-[#DE3B00] transition duration-200 shadow-lg hover:shadow-xl flex items-center justify-center group">
                    <i class="fas fa-plus mr-3 group-hover:scale-110 transition-transform"></i>
                    Buat Campaign
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const oldCityName = "{{ old('city') }}";
            const bannerInput = document.getElementById('banner');
            const bannerPreview = document.getElementById('banner-preview');

            // Preview banner
            bannerInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        bannerPreview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    bannerPreview.src = 'https://placehold.co/120x80?text=Preview';
                }
            });

            const loadCities = (provinceId, cityToSelectName = null) => {
                citySelect.innerHTML = '<option value="" disabled selected>Memuat Kota...</option>';
                citySelect.disabled = true;

                if (provinceId) {
                    const url = `{{ route('admin.campaigns.getCities', '') }}/${provinceId}`;
                    fetch(url)
                        .then(response => {
                            if (!response.ok) throw new Error('Network error');
                            return response.json();
                        })
                        .then(data => {
                            citySelect.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
                            data.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.name;
                                option.textContent = city.name;
                                if (city.name === cityToSelectName) {
                                    option.selected = true;
                                }
                                citySelect.appendChild(option);
                            });
                            citySelect.disabled = false;
                        })
                        .catch(error => {
                            citySelect.innerHTML = '<option value="" disabled selected>Gagal memuat kota</option>';
                            console.error('Error fetching cities:', error);
                        });
                }
            };

            provinceSelect.addEventListener('change', function() {
                loadCities(this.value);
            });

            const initialProvinceId = provinceSelect.value;
            if (initialProvinceId) {
                loadCities(initialProvinceId, oldCityName);
            }
        });
    </script>

@endsection