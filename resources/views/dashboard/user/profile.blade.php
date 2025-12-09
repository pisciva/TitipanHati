@extends('layouts.dash-user')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pengaturan Profil</h1>
            <p class="text-gray-500 mt-1">Kelola informasi pribadi dan keamanan akun Anda</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
                <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" id="profileForm" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <i class="fas fa-user text-[#FF4400]"></i>
                    </div>
                    Informasi Pribadi
                </h3>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="full_name" name="full_name" 
                               value="{{ old('full_name', $profile->full_name ?? '') }}"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('full_name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap Anda">
                    </div>
                    @error('full_name')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-sm text-red-500 hidden error-full_name flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </p>
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="tel" id="phone_number" name="phone_number" 
                               value="{{ old('phone_number', $profile->phone_number ?? '') }}"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('phone_number') border-red-500 @enderror"
                               placeholder="08xxxxxxxxxx">
                    </div>
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-sm text-red-500 hidden error-phone_number flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" disabled
                               class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-500 cursor-not-allowed"
                               value="{{ Auth::user()->email }}">
                    </div>
                    <p class="mt-1 text-xs text-gray-500 flex items-center gap-1">
                        <i class="fas fa-lock"></i>
                        Email tidak dapat diubah
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <i class="fas fa-map-marker-alt text-[#FF4400]"></i>
                    </div>
                    Alamat Default
                </h3>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <label for="default_address" class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none">
                            <i class="fas fa-home text-gray-400 mt-1"></i>
                        </div>
                        <textarea id="default_address" name="default_address" rows="3"
                                  class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition resize-none @error('default_address') border-red-500 @enderror"
                                  placeholder="Jalan, No. Rumah, RT/RW, Kelurahan">{{ old('default_address', $profile->default_address ?? '') }}</textarea>
                    </div>
                    @error('default_address')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-sm text-red-500 hidden error-default_address flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="default_province_select" class="block text-sm font-semibold text-gray-700 mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <select id="default_province_select"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('default_province') border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}" data-name="{{ $province->name }}"
                                    {{ old('default_province', $profile->default_province ?? '') == $province->name ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="default_province" id="default_province" value="{{ old('default_province', $profile->default_province ?? '') }}">
                        @error('default_province')
                            <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-sm text-red-500 hidden error-default_province flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            <span></span>
                        </p>
                    </div>

                    <div>
                        <label for="default_city_select" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kota/Kabupaten <span class="text-red-500">*</span>
                        </label>
                        <select id="default_city_select" disabled
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed @error('default_city') border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                        </select>
                        <input type="hidden" name="default_city" id="default_city" value="{{ old('default_city', $profile->default_city ?? '') }}">
                        @error('default_city')
                            <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-sm text-red-500 hidden error-default_city flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            <span></span>
                        </p>
                    </div>

                    <div>
                        <label for="default_district_select" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <select id="default_district_select" disabled
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed @error('default_district') border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Kecamatan</option>
                        </select>
                        <input type="hidden" name="default_district" id="default_district" value="{{ old('default_district', $profile->default_district ?? '') }}">
                        @error('default_district')
                            <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-sm text-red-500 hidden error-default_district flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            <span></span>
                        </p>
                    </div>
                </div>

                <div>
                    <label for="default_postal_code" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode Pos <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-mail-bulk text-gray-400"></i>
                        </div>
                        <input type="text" id="default_postal_code" name="default_postal_code" 
                               value="{{ old('default_postal_code', $profile->default_postal_code ?? '') }}"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('default_postal_code') border-red-500 @enderror"
                               placeholder="12345" maxlength="10">
                    </div>
                    @error('default_postal_code')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-sm text-red-500 hidden error-default_postal_code flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </p>
                </div>

                <div>
                    <label for="default_notes" class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan Alamat
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none">
                            <i class="fas fa-sticky-note text-gray-400 mt-1"></i>
                        </div>
                        <textarea id="default_notes" name="default_notes" rows="2"
                                  class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition resize-none"
                                  placeholder="Contoh: Rumah cat hijau, dekat minimarket">{{ old('default_notes', $profile->default_notes ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="flex-1 md:flex-none px-8 py-3.5 bg-[#FF4400] text-white rounded-xl hover:bg-[#DE3B00] transition-all font-semibold shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                Simpan Perubahan
            </button>
            <a href="{{ route('dashboard') }}" 
               class="px-6 py-3.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-semibold border border-gray-300">
                Batal
            </a>
        </div>
    </form>

    <form action="{{ route('profile.password') }}" method="POST" id="passwordForm" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <i class="fas fa-lock text-[#FF4400]"></i>
                    </div>
                    Keamanan Akun
                </h3>
            </div>

            <div class="p-6 space-y-5">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-xl">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Password harus minimal 8 karakter dan mengandung kombinasi huruf dan angka.
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password Lama <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                        <input type="password" id="current_password" name="current_password"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('current_password') border-red-500 @enderror"
                               placeholder="Masukkan password lama">
                    </div>
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-sm text-red-500 hidden error-current_password flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('password') border-red-500 @enderror"
                               placeholder="Masukkan password baru">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-sm text-red-500 hidden error-password flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Konfirmasi Password Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-gray-400"></i>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                               placeholder="Konfirmasi password baru">
                    </div>
                    <p class="mt-1 text-sm text-red-500 hidden error-password_confirmation flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </p>
                </div>
            </div>
        </div>

        <button type="submit" 
                class="w-full md:w-auto px-8 py-3.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
            <i class="fas fa-shield-alt"></i>
            Ubah Password
        </button>
    </form>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('default_province_select');
    const citySelect = document.getElementById('default_city_select');
    const districtSelect = document.getElementById('default_district_select');

    const hiddenProvinceInput = document.getElementById('default_province');
    const hiddenCityInput = document.getElementById('default_city');
    const hiddenDistrictInput = document.getElementById('default_district');

    const provinceChoices = new Choices(provinceSelect, {
        searchEnabled: true,
        searchPlaceholderValue: 'Cari provinsi...',
        itemSelectText: '',
        noResultsText: 'Tidak ditemukan',
        position: 'bottom',
        shouldSort: false
    });

    const cityChoices = new Choices(citySelect, {
        searchEnabled: true,
        searchPlaceholderValue: 'Cari kota...',
        itemSelectText: '',
        noResultsText: 'Tidak ditemukan',
        position: 'bottom',
        shouldSort: false
    });

    const districtChoices = new Choices(districtSelect, {
        searchEnabled: true,
        searchPlaceholderValue: 'Cari kecamatan...',
        itemSelectText: '',
        noResultsText: 'Tidak ditemukan',
        position: 'bottom',
        shouldSort: false
    });

    const loadCities = (provinceId, selectedCityName = null) => {
        cityChoices.clearStore();
        cityChoices.setChoices([{ value: '', label: 'Memuat kota...', disabled: true, selected: true }], 'value', 'label', true);
        citySelect.disabled = true;
        cityChoices.disable();

        districtChoices.clearStore();
        districtChoices.setChoices([{ value: '', label: 'Pilih Kecamatan', disabled: true, selected: true }], 'value', 'label', true);
        districtSelect.disabled = true;
        districtChoices.disable();

        hiddenCityInput.value = '';
        hiddenDistrictInput.value = '';

        if (provinceId) {
            fetch(`/api/cities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    const choices = data.map(city => ({
                        value: city.id,
                        label: city.name,
                        customProperties: { name: city.name }
                    }));

                    cityChoices.setChoices(choices, 'value', 'label', true);
                    citySelect.disabled = false;
                    cityChoices.enable();

                    if (selectedCityName) {
                        const cityChoice = data.find(c => c.name === selectedCityName);
                        if (cityChoice) {
                            cityChoices.setChoiceByValue(String(cityChoice.id));
                            hiddenCityInput.value = selectedCityName;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    cityChoices.setChoices([{ value: '', label: 'Gagal memuat kota', disabled: true, selected: true }], 'value', 'label', true);
                });
        }
    };

    const loadDistricts = (cityId, selectedDistrictName = null) => {
        districtChoices.clearStore();
        districtChoices.setChoices([{ value: '', label: 'Memuat kecamatan...', disabled: true, selected: true }], 'value', 'label', true);
        districtSelect.disabled = true;
        districtChoices.disable();

        hiddenDistrictInput.value = '';

        if (cityId) {
            fetch(`/api/districts/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    const choices = data.map(district => ({
                        value: district.id,
                        label: district.name,
                        customProperties: { name: district.name }
                    }));

                    districtChoices.setChoices(choices, 'value', 'label', true);
                    districtSelect.disabled = false;
                    districtChoices.enable();

                    if (selectedDistrictName) {
                        const districtChoice = data.find(d => d.name === selectedDistrictName);
                        if (districtChoice) {
                            districtChoices.setChoiceByValue(String(districtChoice.id));
                            hiddenDistrictInput.value = selectedDistrictName;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading districts:', error);
                    districtChoices.setChoices([{ value: '', label: 'Gagal memuat kecamatan', disabled: true, selected: true }], 'value', 'label', true);
                });
        }
    };

    provinceSelect.addEventListener('change', function(e) {
        const selectedId = e.detail ? e.detail.value : this.value;
        const selectedOption = this.options[this.selectedIndex];
        const selectedName = selectedOption ? selectedOption.text : '';

        hiddenProvinceInput.value = selectedName;
        loadCities(selectedId);
        clearError('default_province');
    });

    citySelect.addEventListener('change', function(e) {
        const selectedId = e.detail ? e.detail.value : this.value;
        const selectedOption = this.options[this.selectedIndex];
        const selectedName = selectedOption ? selectedOption.text : '';

        hiddenCityInput.value = selectedName;
        loadDistricts(selectedId);
        clearError('default_city');
    });

    districtSelect.addEventListener('change', function(e) {
        const selectedOption = this.options[this.selectedIndex];
        const selectedName = selectedOption ? selectedOption.text : '';

        hiddenDistrictInput.value = selectedName;
        clearError('default_district');
    });

    @if(old('default_province', $profile->default_province ?? ''))
        setTimeout(() => {
            const oldProvinceName = "{{ old('default_province', $profile->default_province ?? '') }}";
            const provinceOption = Array.from(provinceSelect.options).find(opt => opt.text === oldProvinceName);

            if (provinceOption) {
                provinceChoices.setChoiceByValue(provinceOption.value);
                hiddenProvinceInput.value = oldProvinceName;

                @if(old('default_city', $profile->default_city ?? ''))
                    const oldCityName = "{{ old('default_city', $profile->default_city ?? '') }}";
                    loadCities(provinceOption.value, oldCityName);

                    @if(old('default_district', $profile->default_district ?? ''))
                        setTimeout(() => {
                            const oldDistrictName = "{{ old('default_district', $profile->default_district ?? '') }}";
                            fetch(`/api/cities/${provinceOption.value}`)
                                .then(response => response.json())
                                .then(cities => {
                                    const city = cities.find(c => c.name === oldCityName);
                                    if (city) {
                                        loadDistricts(city.id, oldDistrictName);
                                    }
                                });
                        }, 500);
                    @endif
                @endif
            }
        }, 100);
    @endif

    function showError(fieldName, message) {
        const field = document.getElementById(fieldName) || document.querySelector(`[name="${fieldName}"]`);
        const errorElement = document.querySelector(`.error-${fieldName}`);
        
        if (field) {
            field.classList.add('border-red-500');
            field.classList.remove('border-gray-300');
        }
        
        if (errorElement) {
            errorElement.querySelector('span').textContent = message;
            errorElement.classList.remove('hidden');
            errorElement.classList.add('flex');
        }
    }

    function clearError(fieldName) {
        const field = document.getElementById(fieldName) || document.querySelector(`[name="${fieldName}"]`);
        const errorElement = document.querySelector(`.error-${fieldName}`);
        
        if (field) {
            field.classList.remove('border-red-500');
            field.classList.add('border-gray-300');
        }
        
        if (errorElement) {
            errorElement.classList.add('hidden');
            errorElement.classList.remove('flex');
        }
    }

    document.querySelectorAll('input, textarea').forEach(element => {
        element.addEventListener('input', function() {
            const fieldName = this.getAttribute('name') || this.id;
            if (fieldName) {
                clearError(fieldName);
            }
        });
    });

    document.getElementById('profileForm').addEventListener('submit', function(e) {
        let hasError = false;

        document.querySelectorAll('.error-full_name, .error-phone_number, .error-default_address, .error-default_province, .error-default_city, .error-default_district, .error-default_postal_code').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('flex');
        });
        
        document.querySelectorAll('#full_name, #phone_number, #default_address, #default_province_select, #default_city_select, #default_district_select, #default_postal_code').forEach(el => {
            el.classList.remove('border-red-500');
            el.classList.add('border-gray-300');
        });

        if (!document.getElementById('full_name').value.trim()) {
            showError('full_name', 'Nama lengkap wajib diisi');
            hasError = true;
        }

        if (!document.getElementById('phone_number').value.trim()) {
            showError('phone_number', 'Nomor telepon wajib diisi');
            hasError = true;
        } else if (!/^(\+62|62|0)[0-9]{9,13}$/.test(document.getElementById('phone_number').value.trim())) {
            showError('phone_number', 'Format nomor telepon tidak valid');
            hasError = true;
        }

        if (!document.getElementById('default_address').value.trim()) {
            showError('default_address', 'Alamat lengkap wajib diisi');
            hasError = true;
        }

        if (!hiddenProvinceInput.value) {
            showError('default_province', 'Provinsi wajib dipilih');
            hasError = true;
        }

        if (!hiddenCityInput.value) {
            showError('default_city', 'Kota/Kabupaten wajib dipilih');
            hasError = true;
        }

        if (!hiddenDistrictInput.value) {
            showError('default_district', 'Kecamatan wajib dipilih');
            hasError = true;
        }

        if (!document.getElementById('default_postal_code').value.trim()) {
            showError('default_postal_code', 'Kode pos wajib diisi');
            hasError = true;
        } else if (!/^[0-9]{5}$/.test(document.getElementById('default_postal_code').value.trim())) {
            showError('default_postal_code', 'Kode pos harus 5 digit angka');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        let hasError = false;

        document.querySelectorAll('.error-current_password, .error-password, .error-password_confirmation').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('flex');
        });
        
        document.querySelectorAll('#current_password, #password, #password_confirmation').forEach(el => {
            el.classList.remove('border-red-500');
            el.classList.add('border-gray-300');
        });

        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        if (!currentPassword.trim()) {
            showError('current_password', 'Password lama wajib diisi');
            hasError = true;
        }

        if (!newPassword.trim()) {
            showError('password', 'Password baru wajib diisi');
            hasError = true;
        } else if (newPassword.length < 8) {
            showError('password', 'Password minimal 8 karakter');
            hasError = true;
        }

        if (!confirmPassword.trim()) {
            showError('password_confirmation', 'Konfirmasi password wajib diisi');
            hasError = true;
        } else if (newPassword !== confirmPassword) {
            showError('password_confirmation', 'Konfirmasi password tidak cocok');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>
@endpush