@extends('layouts.app')

@section('title', 'Buat Donasi - ' . $campaign->title)

@section('content')
    <div class="container mx-auto px-4 py-8">

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

            <div class="lg:col-span-2">
                <form action="{{ route('donations.store') }}" method="POST" id="donationForm" class="flex flex-col gap-6">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">


                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user text-[#FF4400]"></i>
                            </div>
                            Data Donatur
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

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
                                <p class="mt-1 text-sm text-red-500 hidden error-donor_name"></p>
                            </div>


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
                                <p class="mt-1 text-sm text-red-500 hidden error-donor_phone"></p>
                            </div>


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
                                <p class="mt-1 text-sm text-red-500 hidden error-donor_email"></p>
                            </div>
                        </div>
                    </div>


                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-[#FF4400]"></i>
                            </div>
                            Alamat Penjemputan
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

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
                                <p class="mt-1 text-sm text-red-500 hidden error-pickup_address"></p>
                            </div>


                            <div>
                                <label for="pickup_province_select" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>

                                <select id="pickup_province_select" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('pickup_province') border-red-500 @enderror">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" data-name="{{ $province->name }}">
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="hidden" name="pickup_province" id="pickup_province">
                                @error('pickup_province')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-red-500 hidden error-pickup_province"></p>
                            </div>


                            <div>
                                <label for="pickup_city_select" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kota/Kabupaten <span class="text-red-500">*</span>
                                </label>

                                <select id="pickup_city_select" required disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed @error('pickup_city') border-red-500 @enderror">
                                    <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                </select>

                                <input type="hidden" name="pickup_city" id="pickup_city">
                                @error('pickup_city')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-red-500 hidden error-pickup_city"></p>
                            </div>


                            <div>
                                <label for="pickup_district_select" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kecamatan <span class="text-red-500">*</span>
                                </label>

                                <select id="pickup_district_select" required disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed @error('pickup_district') border-red-500 @enderror">
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                </select>

                                <input type="hidden" name="pickup_district" id="pickup_district">
                                @error('pickup_district')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-red-500 hidden error-pickup_district"></p>
                            </div>


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
                                <p class="mt-1 text-sm text-red-500 hidden error-pickup_postal_code"></p>
                            </div>


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
                                <p class="mt-1 text-sm text-red-500 hidden error-pickup_date"></p>
                            </div>


                            <div>
                                <label for="pickup_time_slot_select" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Waktu Penjemputan <span class="text-red-500">*</span>
                                </label>
                                <select id="pickup_time_slot_select" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('pickup_time_slot') border-red-500 @enderror">
                                    <option value="" disabled selected>Pilih Waktu</option>
                                    <option value="09:00-13:00">09:00 - 13:00</option>
                                    <option value="13:00-17:00">13:00 - 17:00</option>
                                </select>
                                <input type="hidden" name="pickup_time_slot" id="pickup_time_slot">
                                @error('pickup_time_slot')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-red-500 hidden error-pickup_time_slot"></p>
                            </div>
                        </div>
                    </div>


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

                            <div class="item-row border border-gray-200 rounded-xl p-5 relative bg-gray-50" data-index="0">
                                <button type="button"
                                    class="remove-item absolute top-3 right-3 text-red-500 hover:text-red-700 hidden transition-colors">
                                    <i class="fas fa-times-circle text-2xl"></i>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jenis Kelamin <span class="text-red-500">*</span>
                                        </label>
                                        <select id="item_gender_0"
                                            class="item-gender w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white"
                                            required>
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="Laki-laki (Anak)">Anak Laki-laki</option>
                                            <option value="Perempuan (Anak)">Anak Perempuan</option>
                                            <option value="Laki-laki (Dewasa)">Laki-laki</option>
                                            <option value="Perempuan (Dewasa)">Perempuan</option>
                                        </select>
                                        <input type="hidden" name="items[0][gender]" class="hidden-gender">
                                        <p class="mt-1 text-sm text-red-500 hidden error-item-gender"></p>
                                    </div>


                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Kategori <span class="text-red-500">*</span>
                                        </label>
                                        <select id="item_category_0"
                                            class="item-category w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white"
                                            required>
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="Atasan">Atasan</option>
                                            <option value="Bawahan">Bawahan</option>
                                            <option value="Other">Lainnya</option>
                                        </select>
                                        <input type="hidden" name="items[0][item_category]" class="hidden-category">
                                        <p class="mt-1 text-sm text-red-500 hidden error-item-category"></p>
                                    </div>


                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jumlah <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="items[0][quantity]" min="1" required
                                            class="item-quantity w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                                            placeholder="0">
                                        <p class="mt-1 text-sm text-red-500 hidden error-item-quantity"></p>
                                    </div>


                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Kondisi <span class="text-red-500">*</span>
                                        </label>
                                        <select id="item_condition_0"
                                            class="item-condition w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white"
                                            required>
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="Baru">Baru</option>
                                            <option value="Layak pakai">Layak Pakai</option>
                                            <option value="Tidak layak">Tidak Layak</option>
                                        </select>
                                        <input type="hidden" name="items[0][condition]" class="hidden-condition">
                                        <p class="mt-1 text-sm text-red-500 hidden error-item-condition"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('items')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>


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


            <div class="lg:col-span-1">

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Campaign</h3>

                    <img src="{{ asset('storage/' . $campaign->banner_url) }}" alt="{{ $campaign->title }}"
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css">

<script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemIndex = 1;

        const provinceSelect = document.getElementById('pickup_province_select');
        const citySelect = document.getElementById('pickup_city_select');
        const districtSelect = document.getElementById('pickup_district_select');
        const timeSlotSelect = document.getElementById('pickup_time_slot_select');

        const hiddenProvinceInput = document.getElementById('pickup_province');
        const hiddenCityInput = document.getElementById('pickup_city');
        const hiddenDistrictInput = document.getElementById('pickup_district');
        const hiddenTimeSlotInput = document.getElementById('pickup_time_slot');

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

        const timeSlotChoices = new Choices(timeSlotSelect, {
            searchEnabled: false,
            itemSelectText: '',
            shouldSort: false
        });

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

        provinceSelect.addEventListener('change', function (e) {
            const selectedId = e.detail ? e.detail.value : this.value;
            const selectedOption = this.options[this.selectedIndex];
            const selectedName = selectedOption ? selectedOption.text : '';

            hiddenProvinceInput.value = selectedName;
            loadCities(selectedId);
            clearError('pickup_province');
        });

        citySelect.addEventListener('change', function (e) {
            const selectedId = e.detail ? e.detail.value : this.value;
            const selectedOption = this.options[this.selectedIndex];
            const selectedName = selectedOption ? selectedOption.text : '';

            hiddenCityInput.value = selectedName;
            loadDistricts(selectedId);
            clearError('pickup_city');
        });

        districtSelect.addEventListener('change', function (e) {
            const selectedOption = this.options[this.selectedIndex];
            const selectedName = selectedOption ? selectedOption.text : '';

            hiddenDistrictInput.value = selectedName;
            clearError('pickup_district');
        });

        timeSlotSelect.addEventListener('change', function (e) {
            const selectedValue = e.detail ? e.detail.value : this.value;
            hiddenTimeSlotInput.value = selectedValue;
            clearError('pickup_time_slot');
        });

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

        @if(old('pickup_time_slot'))
            setTimeout(() => {
                const oldTimeSlot = "{{ old('pickup_time_slot') }}";
                timeSlotChoices.setChoiceByValue(oldTimeSlot);
                hiddenTimeSlotInput.value = oldTimeSlot;
            }, 100);
        @endif

        function initializeItemChoices(itemRow, index) {
            const genderSelect = itemRow.querySelector('.item-gender');
            const categorySelect = itemRow.querySelector('.item-category');
            const conditionSelect = itemRow.querySelector('.item-condition');

            const genderChoices = new Choices(genderSelect, {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });

            const categoryChoices = new Choices(categorySelect, {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });

            const conditionChoices = new Choices(conditionSelect, {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });

            genderSelect.addEventListener('change', function (e) {
                const hiddenInput = itemRow.querySelector('.hidden-gender');
                hiddenInput.value = e.detail ? e.detail.value : this.value;
                clearItemError(itemRow, 'gender');
            });

            categorySelect.addEventListener('change', function (e) {
                const hiddenInput = itemRow.querySelector('.hidden-category');
                hiddenInput.value = e.detail ? e.detail.value : this.value;
                clearItemError(itemRow, 'category');
            });

            conditionSelect.addEventListener('change', function (e) {
                const hiddenInput = itemRow.querySelector('.hidden-condition');
                hiddenInput.value = e.detail ? e.detail.value : this.value;
                clearItemError(itemRow, 'condition');
            });

            const quantityInput = itemRow.querySelector('.item-quantity');
            quantityInput.addEventListener('input', function () {
                clearItemError(itemRow, 'quantity');
            });
        }

        initializeItemChoices(document.querySelector('.item-row'), 0);

        const addItemBtn = document.getElementById('addItemBtn');
        const itemsContainer = document.getElementById('itemsContainer');

        addItemBtn.addEventListener('click', function () {
            const newItem = document.createElement('div');
            newItem.className = 'item-row border border-gray-200 rounded-xl p-5 relative bg-gray-50';
            newItem.setAttribute('data-index', itemIndex);
            newItem.innerHTML = `
                <button type="button"
                    class="remove-item absolute top-3 right-3 text-red-500 hover:text-red-700 transition-colors">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select id="item_gender_${itemIndex}" class="item-gender w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="Laki-laki (Anak)">Anak Laki-laki</option>
                            <option value="Perempuan (Anak)">Anak Perempuan</option>
                            <option value="Laki-laki (Dewasa)">Laki-laki</option>
                            <option value="Perempuan (Dewasa)">Perempuan</option>
                        </select>
                        <input type="hidden" name="items[${itemIndex}][gender]" class="hidden-gender">
                        <p class="mt-1 text-sm text-red-500 hidden error-item-gender"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="item_category_${itemIndex}" class="item-category w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="Atasan">Atasan</option>
                            <option value="Bawahan">Bawahan</option>
                            <option value="Other">Lainnya</option>
                        </select>
                        <input type="hidden" name="items[${itemIndex}][item_category]" class="hidden-category">
                        <p class="mt-1 text-sm text-red-500 hidden error-item-category"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="items[${itemIndex}][quantity]" min="1" required
                            class="item-quantity w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition"
                            placeholder="0">
                        <p class="mt-1 text-sm text-red-500 hidden error-item-quantity"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kondisi <span class="text-red-500">*</span>
                        </label>
                        <select id="item_condition_${itemIndex}" class="item-condition w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-white" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="Baru">Baru</option>
                            <option value="Layak pakai">Layak Pakai</option>
                            <option value="Tidak layak">Tidak Layak</option>
                        </select>
                        <input type="hidden" name="items[${itemIndex}][condition]" class="hidden-condition">
                        <p class="mt-1 text-sm text-red-500 hidden error-item-condition"></p>
                    </div>
                </div>
            `;

            itemsContainer.appendChild(newItem);
            initializeItemChoices(newItem, itemIndex);
            itemIndex++;
            updateRemoveButtons();
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-item')) {
                e.target.closest('.item-row').remove();
                updateRemoveButtons();
            }
        });

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

        function showError(fieldName, message) {
            const field = document.getElementById(fieldName) || document.querySelector(`[name="${fieldName}"]`);
            const errorElement = document.querySelector(`.error-${fieldName}`);

            if (field) {
                field.classList.add('border-red-500');
                field.classList.remove('border-gray-300');
            }

            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
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
            }
        }

        function showItemError(itemRow, fieldType, message) {
            const field = itemRow.querySelector(`.item-${fieldType}`);
            const errorElement = itemRow.querySelector(`.error-item-${fieldType}`);

            if (field) {
                field.classList.add('border-red-500');
                field.classList.remove('border-gray-300');
            }

            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }
        }

        function clearItemError(itemRow, fieldType) {
            const field = itemRow.querySelector(`.item-${fieldType}`);
            const errorElement = itemRow.querySelector(`.error-item-${fieldType}`);

            if (field) {
                field.classList.remove('border-red-500');
                field.classList.add('border-gray-300');
            }

            if (errorElement) {
                errorElement.classList.add('hidden');
            }
        }

        document.querySelectorAll('input, textarea').forEach(element => {
            element.addEventListener('input', function () {
                const fieldName = this.getAttribute('name');
                if (fieldName) {
                    clearError(fieldName);
                }
            });
        });

        document.getElementById('donationForm').addEventListener('submit', function (e) {
            let hasError = false;

            document.querySelectorAll('.error-donor_name, .error-donor_phone, .error-donor_email, .error-pickup_address, .error-pickup_province, .error-pickup_city, .error-pickup_district, .error-pickup_postal_code, .error-pickup_date, .error-pickup_time_slot').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('#donor_name, #donor_phone, #donor_email, #pickup_address, #pickup_province_select, #pickup_city_select, #pickup_district_select, #pickup_postal_code, #pickup_date, #pickup_time_slot_select').forEach(el => {
                el.classList.remove('border-red-500');
                el.classList.add('border-gray-300');
            });

            if (!document.getElementById('donor_name').value.trim()) {
                showError('donor_name', 'Nama lengkap wajib diisi');
                hasError = true;
            }

            if (!document.getElementById('donor_phone').value.trim()) {
                showError('donor_phone', 'No. telepon wajib diisi');
                hasError = true;
            }

            if (!document.getElementById('donor_email').value.trim()) {
                showError('donor_email', 'Email wajib diisi');
                hasError = true;
            }

            if (!document.getElementById('pickup_address').value.trim()) {
                showError('pickup_address', 'Alamat lengkap wajib diisi');
                hasError = true;
            }

            if (!hiddenProvinceInput.value) {
                showError('pickup_province', 'Provinsi wajib dipilih');
                hasError = true;
            }

            if (!hiddenCityInput.value) {
                showError('pickup_city', 'Kota/Kabupaten wajib dipilih');
                hasError = true;
            }

            if (!hiddenDistrictInput.value) {
                showError('pickup_district', 'Kecamatan wajib dipilih');
                hasError = true;
            }

            if (!document.getElementById('pickup_postal_code').value.trim()) {
                showError('pickup_postal_code', 'Kode pos wajib diisi');
                hasError = true;
            }

            if (!document.getElementById('pickup_date').value.trim()) {
                showError('pickup_date', 'Tanggal penjemputan wajib dipilih');
                hasError = true;
            }

            if (!hiddenTimeSlotInput.value) {
                showError('pickup_time_slot', 'Waktu penjemputan wajib dipilih');
                hasError = true;
            }

            const items = document.querySelectorAll('.item-row');
            if (items.length === 0) {
                e.preventDefault();
                alert('Tambahkan minimal 1 item donasi!');
                return;
            }

            items.forEach((itemRow, index) => {
                const genderValue = itemRow.querySelector('.hidden-gender').value;
                const categoryValue = itemRow.querySelector('.hidden-category').value;
                const quantityValue = itemRow.querySelector('.item-quantity').value;
                const conditionValue = itemRow.querySelector('.hidden-condition').value;

                if (!genderValue) {
                    showItemError(itemRow, 'gender', 'Jenis kelamin wajib dipilih');
                    hasError = true;
                }

                if (!categoryValue) {
                    showItemError(itemRow, 'category', 'Kategori wajib dipilih');
                    hasError = true;
                }

                if (!quantityValue || quantityValue < 1) {
                    showItemError(itemRow, 'quantity', 'Jumlah wajib diisi minimal 1');
                    hasError = true;
                }

                if (!conditionValue) {
                    showItemError(itemRow, 'condition', 'Kondisi wajib dipilih');
                    hasError = true;
                }
            });

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