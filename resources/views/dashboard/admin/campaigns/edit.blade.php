@extends('layouts.dash-admin')

@section('title', 'Edit Campaign: ' . $campaign->title)

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Campaign</h1>
        <p class="text-sm text-gray-500 mt-1">Ubah detail campaign untuk menyesuaikan kebutuhan pengumpulan donasi.</p>
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
        <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data" id="campaignForm" class="space-y-8">
            @csrf
            @method('PATCH')

            <div class="space-y-6 border-b border-gray-200 pb-8">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-orange-600"></i>
                    </div>
                    Detail Campaign
                </h3>

                <div>
                    <label for="title" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Judul Campaign <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $campaign->title) }}" required
                           class="w-full px-4 py-3 border @error('title') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                           placeholder="Contoh: Kumpulkan Jaket untuk Anak Yatim Piatu">
                    @error('title')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="organization_id" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Organisasi Pelaksana <span class="text-red-500">*</span>
                    </label>
                    <select name="organization_id" id="organization_id" required
                            class="w-full px-4 py-3 border @error('organization_id') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                        <option value="" disabled selected>Pilih Organisasi</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ old('organization_id', $campaign->organization_id) == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_id')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    @php
                        $selectedCategories = old('categories', $campaign->categories->pluck('id')->toArray());
                        $genderAgeCategoryIds = [1, 2, 3, 4];
                        $apparelCategoryIds = [5, 6, 7];
                        $genderAgeCategories = $categories->whereIn('id', $genderAgeCategoryIds);
                        $apparelCategories = $categories->whereIn('id', $apparelCategoryIds);
                    @endphp

                    <label class="block text-sm font-semibold text-[#FF4400] mb-2">Jenis Kelamin dan Usia <span class="text-red-500">*</span></label>

                    <div class="mb-4 p-4 border border-gray-200 rounded-xl">
                        <div class="space-y-2">
                            @foreach ($genderAgeCategories as $category)
                                <div class="flex items-center">
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

                    <label class="block text-sm font-semibold text-[#FF4400] mb-2">Jenis Pakaian <span class="text-red-500">*</span></label>

                    <div class="mb-4 p-4 border border-gray-200 rounded-xl">
                        <div class="space-y-2">
                            @foreach ($apparelCategories as $category)
                                <div class="flex items-center">
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
                    <label for="banner" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Banner Campaign <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if ($campaign->banner_url)
                                <img id="banner-preview" src="{{ asset('storage/' . $campaign->banner_url) }}" alt="Preview Banner"
                                     class="w-32 h-20 object-cover rounded-lg border border-gray-300">
                            @else
                                <img id="banner-preview" src="https://placehold.co/120x80?text=Preview" alt="Preview Banner"
                                     class="w-32 h-20 object-cover rounded-lg border border-gray-300">
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="banner" id="banner" accept="image/*"
                                   class="w-full px-4 py-3 border @error('banner') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#FF4400] file:text-white hover:file:bg-[#DE3B00]">
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Max 2MB, Format: JPG, PNG (Kosongkan jika tidak ingin mengubah)</p>
                    @error('banner')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-6 border-b border-gray-200 pb-8">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-bullseye text-blue-600"></i>
                    </div>
                    Target & Batas Waktu
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="target_quantity" class="block text-sm font-semibold text-[#FF4400] mb-2">
                            Target Jumlah Donasi (Unit Barang) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="target_quantity" id="target_quantity" value="{{ old('target_quantity', $campaign->target_quantity) }}" required min="1"
                               class="w-full px-4 py-3 border @error('target_quantity') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                               placeholder="Contoh: 500">
                        @error('target_quantity')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deadline" class="block text-sm font-semibold text-[#FF4400] mb-2">
                            Batas Waktu Campaign <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $campaign->deadline->format('Y-m-d')) }}" required
                               class="w-full px-4 py-3 border @error('deadline') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                        @error('deadline')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Status Campaign <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 border @error('status') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                        <option value="aktif" {{ old('status', $campaign->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ old('status', $campaign->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-[#FF4400] mb-2">
                        Deskripsi Campaign <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                              class="w-full px-4 py-3 border @error('description') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                              placeholder="Jelaskan tujuan dan kebutuhan campaign ini...">{{ old('description', $campaign->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-purple-600"></i>
                    </div>
                    Informasi Lokasi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="province" class="block text-sm font-semibold text-[#FF4400] mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <select name="province" id="province" required
                                class="w-full px-4 py-3 border @error('province') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                            <option value="" disabled>Pilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}" 
                                    {{ (old('province') ? old('province') == $province->id : strtolower($campaign->province) == strtolower($province->name)) ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-semibold text-[#FF4400] mb-2">
                            Kota/Kabupaten <span class="text-red-500">*</span>
                        </label>
                        <select name="city" id="city" required
                                class="w-full px-4 py-3 border @error('city') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                            <option value="" disabled>Pilih Kota/Kabupaten</option>
                            @if(old('city', $campaign->city))
                                <option value="{{ old('city', $campaign->city) }}" selected>
                                    {{ old('city', $campaign->city) }}
                                </option>
                            @endif
                        </select>
                        @error('city')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-8">
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3.5 bg-[#FF4400] text-white font-bold rounded-lg hover:bg-[#DE3B00] transition duration-200 shadow-lg hover:shadow-xl flex items-center justify-center group">
                    <i class="fas fa-save mr-3 group-hover:scale-110 transition-transform"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const oldCityName = "{{ old('city', $campaign->city) }}";
            const bannerInput = document.getElementById('banner');
            const bannerPreview = document.getElementById('banner-preview');

            bannerInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        bannerPreview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    bannerPreview.src = '{{ $campaign->banner_url ? asset("storage/" . $campaign->banner_url) : "https://placehold.co/120x80?text=Preview" }}';
                }
            });

            const loadCities = (provinceId, cityToSelectName = null) => {
                const currentCity = citySelect.querySelector('option[selected]');
                const currentCityValue = currentCity ? currentCity.value : null;
                
                citySelect.innerHTML = '<option value="" disabled>Memuat Kota...</option>';
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
                                if (city.name === cityToSelectName || city.name === currentCityValue) {
                                    option.selected = true;
                                }
                                citySelect.appendChild(option);
                            });
                            citySelect.disabled = false;
                        })
                        .catch(error => {
                            citySelect.innerHTML = '<option value="" disabled>Gagal memuat kota</option>';
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