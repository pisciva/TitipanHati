@extends('layouts.admin')

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
        
        <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
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
                    <select name="organization_id" id="organization_id"
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

                {{-- Categories (Radio Button) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($categories as $category)
                            <label class="flex items-center p-3 border @error('categories') border-red-500 @enderror border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="categories[]" value="{{ $category->id }}"
                                       class="h-4 w-4 text-[#FF4400] focus:ring-[#FF4400] border-gray-300"
                                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <span class="ml-3 block text-sm font-medium text-gray-700">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    @error('categories.*')
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
                        <input type="number" name="target_quantity" id="target_quantity" value="{{ old('target_quantity') }}" min="1"
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
                        <input type="text" name="deadline" id="deadline" value="{{ old('deadline') }}"
                               class="w-full px-4 py-3 border @error('deadline') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white cursor-pointer"
                               placeholder="Pilih tanggal" readonly>
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
                    <textarea name="description" id="description" rows="5"
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
                    
                    {{-- Province (Dropdown) --}}
                    <div>
                        <label for="province" class="block text-sm font-semibold text-gray-700 mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <select name="province" id="province"
                                class="w-full px-4 py-3 border @error('province') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition">
                            <option value="" disabled selected>Pilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->code }}" {{ old('province') === $province->code ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- City/Regency (Dropdown) --}}
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kota/Kabupaten <span class="text-red-500">*</span>
                        </label>
                        <select name="city" id="city" disabled
                                class="w-full px-4 py-3 border @error('city') border-red-500 @enderror border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed">
                            <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                            {{-- Opsi akan diisi oleh JavaScript --}}
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

@endsection

@push('scripts')
    <!-- Choices.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css">
    <!-- Choices.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. Inisialisasi Choices.js untuk Organisasi, Provinsi, dan Kota ---
            const organizationSelect = document.getElementById('organization_id');
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');

            // Inisialisasi Choices untuk Organisasi
            const organizationChoices = new Choices(organizationSelect, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari organisasi...',
                itemSelectText: 'Pilih',
                noResultsText: 'Tidak ditemukan',
                position: 'bottom'
            });

            // Inisialisasi Choices untuk Provinsi
            const provinceChoices = new Choices(provinceSelect, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari provinsi...',
                itemSelectText: 'Pilih',
                noResultsText: 'Tidak ditemukan',
                position: 'bottom'
            });

            // Inisialisasi Choices untuk Kota (tetap seperti sebelumnya)
            const cityChoices = new Choices(citySelect, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari kota...',
                itemSelectText: 'Pilih',
                noResultsText: 'Tidak ditemukan',
                position: 'bottom',
                placeholderValue: 'Pilih Kota dulu'
            });

            // --- 2. Inisialisasi Flatpickr untuk Deadline ---
            flatpickr("#deadline", {
                dateFormat: "Y-m-d",
                minDate: "today",
                disableMobile: true, // Gunakan flatpickr di semua perangkat
                locale: {
                    firstDayOfWeek: 1, // Mulai dari Senin
                    weekdays: {
                        shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                        longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                    },
                    months: {
                        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    },
                },
            });

            // --- 3. Logika Load Kota berdasarkan Provinsi ---
            const loadCities = (provinceCode, selectedCityName = null) => {
                citySelect.innerHTML = '<option value="" disabled selected>Memuat Kota...</option>';
                cityChoices.setChoices([{ value: '', label: 'Memuat Kota...', disabled: true, selected: true }], 'value', 'label', true);
                citySelect.disabled = true;
                cityChoices.disable();

                if (provinceCode) {
                    const url = `{{ route('admin.campaigns.getCities', ':provinceCode') }}`.replace(':provinceCode', provinceCode);

                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const choices = data.map(city => ({ value: city.name, label: city.name }));
                            cityChoices.setChoices(choices, 'value', 'label', true);
                            citySelect.disabled = false;
                            cityChoices.enable();

                            // Jika ada kota lama dari validasi sebelumnya, pilih itu
                            if (selectedCityName) {
                                cityChoices.setChoiceByValue(selectedCityName);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching cities:', error);
                            cityChoices.setChoices([{ value: '', label: 'Gagal memuat kota', disabled: true, selected: true }], 'value', 'label', true);
                        });
                } else {
                    cityChoices.setChoices([{ value: '', label: 'Pilih Kota dulu', disabled: true, selected: true }], 'value', 'label', true);
                    citySelect.disabled = true;
                    cityChoices.disable();
                }
            };

            // Event Listener: Ketika Provinsi diubah
            provinceSelect.addEventListener('change', function(e) {
                const selectedProvinceCode = e.detail.value || this.value; // Untuk Choices.js
                loadCities(selectedProvinceCode);
            });

            // Inisialisasi: Jika ada nilai provinsi yang sudah terpilih (misalnya setelah validasi gagal)
            const initialProvinceCode = provinceSelect.value;
            if (initialProvinceCode) {
                // Gunakan setTimeout agar Choices.js selesai diinisialisasi
                setTimeout(() => {
                    loadCities(initialProvinceCode, "{{ old('city') }}");
                }, 100);
            }

            // --- 4. Preview Banner ---
            const bannerInput = document.getElementById('banner');
            const bannerPreview = document.getElementById('banner-preview');

            bannerInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        bannerPreview.src = event.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    bannerPreview.src = 'https://placehold.co/120x80?text=Preview';
                }
            });
        });
    </script>
@endpush