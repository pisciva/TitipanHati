@extends('layouts.dash-admin')

@section('title', 'Edit Campaign: ' . $campaign->title)

@section('content')


    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-semibold text-[#1D1D1D]">Edit Campaign</h1>
            <p class="text-sm text-gray-500 mt-1">Mengubah detail untuk campaign: <span class="font-medium text-gray-700">{{ $campaign->title }}</span></p>
        </div>
        <a href="{{ route('admin.campaigns.show', $campaign->id) }}" class="text-sm font-medium text-[#FF4400] hover:text-[#EB3F00] transition flex items-center">
            <i class="fas fa-eye mr-2"></i> Lihat Detail
        </a>
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


    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        
        <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')


            <div class="space-y-6 border-b border-gray-200 pb-6">
                <h3 class="text-xl font-semibold text-gray-800">Detail Dasar Campaign</h3>


                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Campaign</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $campaign->title) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                    @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>


                <div>
                    <label for="organization_id" class="block text-sm font-medium text-gray-700 mb-1">Organisasi Pelaksana</label>
                    <select name="organization_id" id="organization_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        <option value="" disabled>Pilih Organisasi</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ old('organization_id', $campaign->organization_id) == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>


                <div>
                    @php
                        // Perbaikan: Ambil dari old() jika ada error, jika tidak, ambil dari data campaign.
                        $selectedCategories = old('categories', $campaign->categories->pluck('id')->toArray());


                        // --- ASUMSI PENGELOMPOKAN KATEGORI BERDASARKAN ID (HARAP SESUAIKAN ID INI) ---
                        $genderAgeCategoryIds = [1, 2, 3, 4];
                        $apparelCategoryIds = [5, 6, 7]; 


                        // Filter kategori berdasarkan ID
                        $genderAgeCategories = $categories->whereIn('id', $genderAgeCategoryIds);
                        $apparelCategories = $categories->whereIn('id', $apparelCategoryIds);
                    @endphp

                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin dan Usia <span class="text-red-500">*</span></label>

                    {{-- SECTION 1: Kategori Jenis Kelamin/Usia --}}
                    <div class="mb-4 p-4 border border-gray-200 rounded-xl">
                        <div class="space-y-2">
                            @foreach ($genderAgeCategories as $category)
                                <div class="flex items-center">
                                    {{-- HAPUS ATRIBUT required --}}
                                    <input id="category-{{ $category->id }}" name="categories[]" type="checkbox" value="{{ $category->id }}" 
                                        class="h-4 w-4 border-gray-300 rounded transition 
                                            focus:ring-[#FF4400] focus:border-[#FF4400] 
                                            checked:bg-[#FF4400] checked:border-[#FF4400] checked:text-white"
                                        {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                                    <label for="category-{{ $category->id }}" class="ml-3 text-sm font-medium text-gray-700">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pakaian <span class="text-red-500">*</span></label>

                    {{-- SECTION 2: Kategori Pakaian --}}
                    <div class="mb-4 p-4 border border-gray-200 rounded-xl">
                        <div class="space-y-2">
                            @foreach ($apparelCategories as $category)
                                <div class="flex items-center">
                                    {{-- HAPUS ATRIBUT required --}}
                                    <input id="category-{{ $category->id }}" name="categories[]" type="checkbox" value="{{ $category->id }}" 
                                        class="h-4 w-4 border-gray-300 rounded transition 
                                            focus:ring-[#FF4400] focus:border-[#FF4400] 
                                            checked:bg-[#FF4400] checked:border-[#FF4400] checked:text-white"
                                        {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                                    <label for="category-{{ $category->id }}" class="ml-3 text-sm font-medium text-gray-700">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @error('categories')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    @error('categories.*')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Banner Campaign Saat Ini</label>
                    @if ($campaign->banner_url)
                        <div class="mb-4">

                            <img src="{{ asset('storage/' . $campaign->banner_url) }}" alt="Banner Campaign" class="w-full h-40 object-cover rounded-xl shadow-md border border-gray-200">
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mb-4">Tidak ada banner yang terunggah.</p>
                    @endif

                    <label for="banner" class="block text-sm font-medium text-gray-700 mb-1">Ganti Banner (Opsional, Max 2MB, JPG/PNG)</label>
                    <input type="file" name="banner" id="banner" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#FF4400] file:text-[#F8FAFC] hover:file:bg-[#EB3F00]">
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah banner.</p>
                    @error('banner')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>


            <div class="space-y-6 border-b border-gray-200 pb-6">
                <h3 class="text-xl font-semibold text-gray-800">Target & Batas Waktu</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label for="target_quantity" class="block text-sm font-medium text-gray-700 mb-1">Target Jumlah Donasi (Unit Barang)</label>
                        <input type="number" name="target_quantity" id="target_quantity" value="{{ old('target_quantity', $campaign->target_quantity) }}" required min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        @error('target_quantity')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>


                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Batas Waktu Campaign</label>

                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $campaign->deadline->format('Y-m-d')) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        @error('deadline')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>


                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Campaign</label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        <option value="aktif" {{ old('status', $campaign->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ old('status', $campaign->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>


                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Campaign</label>
                    <textarea name="description" id="description" rows="6" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">{{ old('description', $campaign->description) }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>


            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-800">Informasi Lokasi</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> 
                    

                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <select name="province" id="province" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                            <option value="" disabled selected>Pilih Provinsi</option>

                            @foreach ($provinces as $province)
                                <option value="{{ $province->code }}" {{ old('province', $campaign->province_code) === $province->code ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                        <select name="city" id="city" required disabled
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition bg-gray-50 disabled:cursor-not-allowed">
                            {{-- Pilihan kota akan diisi oleh JavaScript --}}
                            @if (old('city') || $campaign->city_name)
                                <option value="{{ old('city', $campaign->city_name) }}" selected>
                                    {{ old('city', $campaign->city_name) }}
                                </option>
                            @else
                                <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                            @endif
                        </select>
                        @error('city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                </div> 
            </div>


            <div class="pt-6">
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 bg-[#FF4400] text-[#F8FAFC] font-semibold rounded-xl hover:bg-[#EB3F00] transition duration-150 shadow-md flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            // Gunakan nilai dari old() atau data campaign jika tidak ada old()
            const initialCityName = "{{ old('city') ?: $campaign->city_name }}"; 
            
            const loadCities = (provinceId, cityToSelectName = null) => {
                citySelect.innerHTML = '<option value="" disabled selected>Memuat Kota...</option>';
                citySelect.disabled = true;

                if (provinceId) {

                    const url = `{{ route('admin.campaigns.getCities', '') }}/${provinceId}`; 

                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
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
                loadCities(initialProvinceId, initialCityName);
            }
        });
    </script>

@endsection