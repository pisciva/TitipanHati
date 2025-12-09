@extends('layouts.app')

@section('title', 'Buat Donasi - ' . $campaign->title)

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('campaigns.show', $campaign->id) }}"
                class="text-[#FF4400] hover:text-[#DE3B00] mb-4 inline-flex items-center font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Campaign
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Formulir Donasi</h1>
            <p class="text-gray-600 mt-2">Isi formulir berikut untuk melakukan donasi ke campaign "{{ $campaign->title }}"
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Form Section --}}
            <div class="lg:col-span-2">
                <form action="{{ route('donations.store') }}" method="POST" id="donationForm" class="flex flex-col gap-6">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

                    {{-- Data Donatur --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user text-[#FF4400]"></i>
                            </div>
                            Data Donatur
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Nama --}}
                            <div class="md:col-span-2">
                                <label for="donor_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="donor_name" id="donor_name"
                                    value="{{ old('donor_name', $profile->full_name ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('donor_name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
                                @error('donor_name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="donor_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    No. Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="donor_phone" id="donor_phone"
                                    value="{{ old('donor_phone', $profile->phone_number ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('donor_phone') border-red-500 @enderror"
                                    placeholder="08xxxxxxxxxx">
                                @error('donor_phone')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="donor_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="donor_email" id="donor_email"
                                    value="{{ old('donor_email', Auth::user()->email) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('donor_email') border-red-500 @enderror"
                                    placeholder="email@example.com">
                                @error('donor_email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Alamat Penjemputan --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-[#FF4400]"></i>
                            </div>
                            Alamat Penjemputan
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Alamat Lengkap --}}
                            <div class="md:col-span-2">
                                <label for="pickup_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea name="pickup_address" id="pickup_address" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('pickup_address') border-red-500 @enderror"
                                    placeholder="Jalan, No. Rumah, RT/RW, Kelurahan">{{ old('pickup_address', $profile->default_address ?? '') }}</textarea>
                                @error('pickup_address')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Provinsi --}}
                            <div>
                                <label for="pickup_province_select" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                {{-- Select untuk UI saja (tidak akan di-submit) --}}
                                <select id="pickup_province_select" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('pickup_province') border-red-500 @enderror">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" data-name="{{ $province->name }}">
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- Hidden input untuk submit ke database --}}
                                <input type="hidden" name="pickup_province" id="pickup_province">
                                @error('pickup_province')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kota/Kabupaten --}}
                            <div>
                                <label for="pickup_city_select" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kota/Kabupaten <span class="text-red-500">*</span>
                                </label>
                                {{-- Select untuk UI saja (tidak akan di-submit) --}}
                                <select id="pickup_city_select" required disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed @error('pickup_city') border-red-500 @enderror">
                                    <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                </select>
                                {{-- Hidden input untuk submit ke database --}}
                                <input type="hidden" name="pickup_city" id="pickup_city">
                                @error('pickup_city')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kecamatan --}}
                            <div>
                                <label for="pickup_district_select" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kecamatan <span class="text-red-500">*</span>
                                </label>
                                {{-- Select untuk UI saja (tidak akan di-submit) --}}
                                <select id="pickup_district_select" required disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed @error('pickup_district') border-red-500 @enderror">
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                </select>
                                {{-- Hidden input untuk submit ke database --}}
                                <input type="hidden" name="pickup_district" id="pickup_district">
                                @error('pickup_district')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kode Pos --}}
                            <div>
                                <label for="pickup_postal_code" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kode Pos <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pickup_postal_code" id="pickup_postal_code"
                                    value="{{ old('pickup_postal_code', $profile->default_postal_code ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('pickup_postal_code') border-red-500 @enderror"
                                    placeholder="12345" maxlength="10">
                                @error('pickup_postal_code')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Catatan --}}
                            <div class="md:col-span-2">
                                <label for="pickup_notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Catatan Alamat
                                </label>
                                <textarea name="pickup_notes" id="pickup_notes" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                                    placeholder="Misal: Rumah cat hijau, dekat minimarket">{{ old('pickup_notes', $profile->default_notes ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Jadwal Penjemputan --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-[#FF4400]"></i>
                            </div>
                            Jadwal Penjemputan
                        </h2>

                        <div class="bg-orange-50 border-l-4 border-[#FF4400] p-4 mb-5 rounded-r-lg">
                            <p class="text-sm text-gray-800">
                                <i class="fas fa-info-circle mr-2 text-[#FF4400]"></i>
                                Penjemputan minimal 3 hari dari sekarang
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Tanggal --}}
                            <div>
                                <label for="pickup_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Penjemputan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pickup_date" id="pickup_date" value="{{ old('pickup_date') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white cursor-pointer @error('pickup_date') border-red-500 @enderror"
                                    placeholder="Pilih tanggal" readonly>
                                @error('pickup_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Waktu --}}
                            <div>
                                <label for="pickup_time_slot" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Waktu Penjemputan <span class="text-red-500">*</span>
                                </label>
                                <select name="pickup_time_slot" id="pickup_time_slot"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('pickup_time_slot') border-red-500 @enderror">
                                    <option value="">Pilih Waktu</option>
                                    <option value="09:00-13:00" {{ old('pickup_time_slot') === '09:00-13:00' ? 'selected' : '' }}>
                                        09:00 - 13:00
                                    </option>
                                    <option value="13:00-17:00" {{ old('pickup_time_slot') === '13:00-17:00' ? 'selected' : '' }}>
                                        13:00 - 17:00
                                    </option>
                                </select>
                                @error('pickup_time_slot')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Barang Donasi --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-box text-[#FF4400]"></i>
                                </div>
                                Barang Donasi
                            </h2>
                            <button type="button" id="addItemBtn"
                                class="px-5 py-2.5 bg-[#FF4400] text-white font-semibold rounded-lg hover:bg-[#DE3B00] transition-colors shadow-sm">
                                <i class="fas fa-plus mr-2"></i> Tambah Item
                            </button>
                        </div>

                        <div id="itemsContainer" class="space-y-4">
                            {{-- Item pertama (default) --}}
                            <div class="item-row border border-gray-200 rounded-xl p-5 relative bg-gray-50">
                                <button type="button"
                                    class="remove-item absolute top-3 right-3 text-red-500 hover:text-red-700 hidden transition-colors">
                                    <i class="fas fa-times-circle text-2xl"></i>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Gender --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jenis Kelamin <span class="text-red-500">*</span>
                                        </label>
                                        <select name="items[0][gender]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white">
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki (Anak)">Anak Laki-laki</option>
                                            <option value="Perempuan (Anak)">Anak Perempuan</option>
                                            <option value="Laki-laki (Dewasa)">Laki-laki</option>
                                            <option value="Perempuan (Dewasa)">Perempuan</option>
                                        </select>
                                    </div>

                                    {{-- Kategori --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Kategori <span class="text-red-500">*</span>
                                        </label>
                                        <select name="items[0][item_category]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white">
                                            <option value="">Pilih</option>
                                            <option value="Atasan">Atasan</option>
                                            <option value="Bawahan">Bawahan</option>
                                            <option value="Other">Lainnya</option>
                                        </select>
                                    </div>

                                    {{-- Jumlah --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jumlah <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="items[0][quantity]" min="1" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                                            placeholder="0">
                                    </div>

                                    {{-- Kondisi --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Kondisi <span class="text-red-500">*</span>
                                        </label>
                                        <select name="items[0][condition]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white">
                                            <option value="">Pilih</option>
                                            <option value="Baru">Baru</option>
                                            <option value="Layak pakai">Layak Pakai</option>
                                            <option value="Tidak layak">Tidak Layak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('items')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 py-4 px-6 bg-[#FF4400] text-white font-bold rounded-lg hover:bg-[#DE3B00] transition-all shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Donasi
                        </button>
                        <a href="{{ route('campaigns.show', $campaign->id) }}"
                            class="px-6 py-4 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition-colors border border-gray-300">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                {{-- Campaign Info --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Campaign</h3>

                    <img src="{{ $campaign->banner_url ?? '/images/default-campaign.jpg' }}" alt="{{ $campaign->title }}"
                        class="w-full h-40 object-cover rounded-lg mb-4">

                    <h4 class="font-bold text-gray-900 mb-3">{{ $campaign->title }}</h4>

                    <div class="space-y-2.5 text-sm text-gray-600 mb-5">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-building text-[#FF4400] text-xs"></i>
                            </div>
                            <span>{{ $campaign->organization->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-[#FF4400] text-xs"></i>
                            </div>
                            <span>{{ $campaign->city }}, {{ $campaign->province }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar text-[#FF4400] text-xs"></i>
                            </div>
                            <span>Deadline: {{ $campaign->deadline->format('d M Y') }}</span>
                        </div>
                    </div>

                    {{-- Progress --}}
                    <div class="mb-5">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600 font-medium">Progress</span>
                            <span class="font-bold text-[#FF4400]">{{ $campaign->progressPercentage() }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-[#FF4400] h-2.5 rounded-full transition-all"
                                style="width: {{ $campaign->progressPercentage() }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-600 mt-2">
                            <span>{{ number_format($campaign->collected_quantity) }} terkumpul</span>
                            <span>Target: {{ number_format($campaign->target_quantity) }}</span>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-orange-50 border-l-4 border-[#FF4400] p-4 rounded-r-lg">
                        <p class="text-xs text-gray-800 leading-relaxed">
                            <i class="fas fa-info-circle mr-1 text-[#FF4400]"></i>
                            Pastikan data yang Anda masukkan sudah benar. Tim kami akan menghubungi Anda untuk konfirmasi
                            penjemputan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
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
        document.addEventListener('DOMContentLoaded', function () {
            let itemIndex = 1;

// ========== INISIALISASI SELECT ELEMENTS ==========
            const provinceSelect = document.getElementById('pickup_province_select');
            const citySelect = document.getElementById('pickup_city_select');
            const districtSelect = document.getElementById('pickup_district_select');

            // Hidden inputs (sudah ada di HTML)
            const hiddenProvinceInput = document.getElementById('pickup_province');
            const hiddenCityInput = document.getElementById('pickup_city');
            const hiddenDistrictInput = document.getElementById('pickup_district');

            // ========== INISIALISASI CHOICES.JS ==========
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

            // ========== INISIALISASI FLATPICKR ==========
            flatpickr("#pickup_date", {
                dateFormat: "Y-m-d",
                minDate: new Date().fp_incr(3),
                disableMobile: true,
                locale: {
                    firstDayOfWeek: 1,
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

            // ========== FUNGSI LOAD CITIES ==========
            const loadCities = (provinceId, selectedCityName = null) => {
                cityChoices.clearStore();
                cityChoices.setChoices([{ value: '', label: 'Memuat kota...', disabled: true, selected: true }], 'value', 'label', true);
                citySelect.disabled = true;
                cityChoices.disable();

                // Reset districts
                districtChoices.clearStore();
                districtChoices.setChoices([{ value: '', label: 'Pilih Kecamatan', disabled: true, selected: true }], 'value', 'label', true);
                districtSelect.disabled = true;
                districtChoices.disable();

                // Reset hidden inputs
                hiddenCityInput.value = '';
                hiddenDistrictInput.value = '';

                if (provinceId) {
                    fetch(`/api/cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            const choices = data.map(city => ({
                                value: city.id,
                                label: city.name,
                                customProperties: { name: city.name } // Simpan nama di custom properties
                            }));

                            cityChoices.setChoices(choices, 'value', 'label', true);
                            citySelect.disabled = false;
                            cityChoices.enable();

                            // Auto-select jika ada selectedCityName
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

            // ========== FUNGSI LOAD DISTRICTS ==========
            const loadDistricts = (cityId, selectedDistrictName = null) => {
                districtChoices.clearStore();
                districtChoices.setChoices([{ value: '', label: 'Memuat kecamatan...', disabled: true, selected: true }], 'value', 'label', true);
                districtSelect.disabled = true;
                districtChoices.disable();

                // Reset hidden input
                hiddenDistrictInput.value = '';

                if (cityId) {
                    fetch(`/api/districts/${cityId}`)
                        .then(response => response.json())
                        .then(data => {
                            const choices = data.map(district => ({
                                value: district.id,
                                label: district.name,
                                customProperties: { name: district.name } // Simpan nama di custom properties
                            }));

                            districtChoices.setChoices(choices, 'value', 'label', true);
                            districtSelect.disabled = false;
                            districtChoices.enable();

                            // Auto-select jika ada selectedDistrictName
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

            // ========== EVENT LISTENERS ==========
            provinceSelect.addEventListener('change', function (e) {
                const selectedId = e.detail ? e.detail.value : this.value;
                const selectedOption = this.options[this.selectedIndex];
                const selectedName = selectedOption ? selectedOption.text : '';

                console.log('Province changed:', { id: selectedId, name: selectedName });

                // Update hidden input dengan NAMA
                hiddenProvinceInput.value = selectedName;

                // Load cities
                loadCities(selectedId);
            });

            citySelect.addEventListener('change', function (e) {
                const selectedId = e.detail ? e.detail.value : this.value;
                const selectedOption = this.options[this.selectedIndex];
                const selectedName = selectedOption ? selectedOption.text : '';

                console.log('City changed:', { id: selectedId, name: selectedName });

                // Update hidden input dengan NAMA
                hiddenCityInput.value = selectedName;

                // Load districts
                loadDistricts(selectedId);
            });

            districtSelect.addEventListener('change', function (e) {
                const selectedOption = this.options[this.selectedIndex];
                const selectedName = selectedOption ? selectedOption.text : '';

                console.log('District changed:', { name: selectedName });

                // Update hidden input dengan NAMA
                hiddenDistrictInput.value = selectedName;
            });

            // ========== HANDLE OLD VALUES (untuk validation error) ==========
            @if(old('pickup_province'))
                setTimeout(() => {
                    const oldProvinceName = "{{ old('pickup_province') }}";
                    const provinceOption = Array.from(provinceSelect.options).find(opt => opt.text === oldProvinceName);

                    if (provinceOption) {
                        provinceChoices.setChoiceByValue(provinceOption.value);
                        hiddenProvinceInput.value = oldProvinceName;

                        @if(old('pickup_city'))
                            const oldCityName = "{{ old('pickup_city') }}";
                            loadCities(provinceOption.value, oldCityName);

                            @if(old('pickup_district'))
                                setTimeout(() => {
                                    const oldDistrictName = "{{ old('pickup_district') }}";
                                    // Kita perlu ID kota untuk load districts
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

            // ========== DONATION ITEMS ==========
            const addItemBtn = document.getElementById('addItemBtn');
            const itemsContainer = document.getElementById('itemsContainer');

            addItemBtn.addEventListener('click', function () {
                const newItem = `
                    <div class="item-row border border-gray-200 rounded-xl p-5 relative bg-gray-50">
                        <button type="button"
                            class="remove-item absolute top-3 right-3 text-red-500 hover:text-red-700 transition-colors">
                            <i class="fas fa-times-circle text-2xl"></i>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select name="items[${itemIndex}][gender]" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white">
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki (Anak)">Anak Laki-laki</option>
                                    <option value="Perempuan (Anak)">Anak Perempuan</option>
                                    <option value="Laki-laki (Dewasa)">Laki-laki</option>
                                    <option value="Perempuan (Dewasa)">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select name="items[${itemIndex}][item_category]" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white">
                                    <option value="">Pilih</option>
                                    <option value="Atasan">Atasan</option>
                                    <option value="Bawahan">Bawahan</option>
                                    <option value="Other">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jumlah <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="items[${itemIndex}][quantity]" min="1" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                                    placeholder="0">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kondisi <span class="text-red-500">*</span>
                                </label>
                                <select name="items[${itemIndex}][condition]" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white">
                                    <option value="">Pilih</option>
                                    <option value="Baru">Baru</option>
                                    <option value="Layak pakai">Layak Pakai</option>
                                    <option value="Tidak layak">Tidak Layak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;

                itemsContainer.insertAdjacentHTML('beforeend', newItem);
                itemIndex++;
                updateRemoveButtons();
            });

            // Remove item
            document.addEventListener('click', function (e) {
                if (e.target.closest('.remove-item')) {
                    e.target.closest('.item-row').remove();
                    updateRemoveButtons();
                }
            });

            // Update remove button visibility
            function updateRemoveButtons() {
                const items = document.querySelectorAll('.item-row');
                items.forEach((item) => {
                    const removeBtn = item.querySelector('.remove-item');
                    if (items.length > 1) {
                        removeBtn.classList.remove('hidden');
                    } else {
                        removeBtn.classList.add('hidden');
                    }
                });
            }

            // ========== FORM VALIDATION & DEBUG ==========
            document.getElementById('donationForm').addEventListener('submit', function (e) {
                const items = document.querySelectorAll('.item-row');

                if (items.length === 0) {
                    e.preventDefault();
                    alert('Tambahkan minimal 1 item donasi!');
                    return;
                }

                // Debug: Log form data sebelum submit
                console.log('Form Data:', {
                    province: hiddenProvinceInput.value,
                    city: hiddenCityInput.value,
                    district: hiddenDistrictInput.value,
                    totalItems: items.length
                });

                // Validasi hidden inputs tidak boleh kosong
                if (!hiddenProvinceInput.value) {
                    e.preventDefault();
                    alert('Silakan pilih provinsi!');
                    return;
                }

                if (!hiddenCityInput.value) {
                    e.preventDefault();
                    alert('Silakan pilih kota/kabupaten!');
                    return;
                }

                if (!hiddenDistrictInput.value) {
                    e.preventDefault();
                    alert('Silakan pilih kecamatan!');
                    return;
                }
            });
        });
    </script>
@endpush