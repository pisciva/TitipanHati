@extends('layouts.app')

@section('title', 'Buat Donasi - ' . $campaign->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-[#FF4400] hover:text-[#DE3B00] mb-4 inline-flex items-center font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Campaign
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Formulir Donasi</h1>
        <p class="text-gray-600 mt-2">Isi formulir berikut untuk melakukan donasi ke campaign "{{ $campaign->title }}"</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Form Section --}}
        <div class="lg:col-span-2">
            <form action="{{ route('donations.store') }}" method="POST" id="donationForm" class="space-y-6">
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
                            <label for="pickup_province" class="block text-sm font-semibold text-gray-700 mb-2">
                                Provinsi <span class="text-red-500">*</span>
                            </label>
                            <select name="pickup_province" id="pickup_province" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition @error('pickup_province') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" 
                                            {{ old('pickup_province', $profile->default_province ?? '') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pickup_province')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kota/Kabupaten --}}
                        <div>
                            <label for="pickup_province" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kota/Kabupaten <span class="text-red-500">*</span>
                            </label>
                            <select name="pickup_province" id="pickup_province" required disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed @error('pickup_province') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                            </select>
                            @error('pickup_province')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label for="pickup_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <select name="pickup_city" id="pickup_city" required disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-[#FF4400] transition bg-gray-50 disabled:cursor-not-allowed @error('pickup_city') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Kecamatan</option>
                            </select>
                            @error('pickup_city')
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
                                Catatan Alamat (Opsional)
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
                            <input type="text" name="pickup_date" id="pickup_date" 
                                   value="{{ old('pickup_date') }}"
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
                            <button type="button" class="remove-item absolute top-3 right-3 text-red-500 hover:text-red-700 hidden transition-colors">
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
                
                <img src="{{ $campaign->banner_url ?? '/images/default-campaign.jpg' }}" 
                     alt="{{ $campaign->title }}"
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
                        <div class="bg-[#FF4400] h-2.5 rounded-full transition-all" style="width: {{ $campaign->progressPercentage() }}%"></div>
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
                        Pastikan data yang Anda masukkan sudah benar. Tim kami akan menghubungi Anda untuk konfirmasi penjemputan.
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

    <style>
        /* Custom Choices.js Styling */
        .choices__inner {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            min-height: 48px !important;
            background-color: white !important;
        }
        
        .choices__input {
            margin-bottom: 0 !important;
            background-color: transparent !important;
        }
        
        .choices[data-type*=select-one] .choices__inner {
            padding-bottom: 0.75rem !important;
        }
        
        .choices__list--dropdown {
            border: 1px solid #e5e7eb !important;
            border-radius: 0.5rem !important;
            margin-top: 4px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            max-height: 300px !important;
        }
        
        .choices__list--dropdown .choices__item--selectable {
            padding: 0.75rem 1rem !important;
            transition: background-color 0.2s !important;
        }
        
        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background-color: #FFF5F0 !important;
            color: #FF4400 !important;
        }
        
        .choices__list--dropdown .choices__item--selectable:hover {
            background-color: #FFF5F0 !important;
        }
        
        .is-focused .choices__inner,
        .is-open .choices__inner {
            border-color: #FF4400 !important;
            box-shadow: 0 0 0 3px rgba(255, 68, 0, 0.1) !important;
        }
        
        .choices__list--single {
            padding: 0 !important;
        }
        
        /* Custom Flatpickr Styling */
        .flatpickr-calendar {
            border-radius: 0.75rem !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #e5e7eb !important;
        }
        
        .flatpickr-months {
            border-radius: 0.75rem 0.75rem 0 0 !important;
            background: #FF4400 !important;
        }
        
        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            color: white !important;
            font-weight: 600 !important;
        }
        
        .flatpickr-current-month .numInputWrapper span.arrowUp:after,
        .flatpickr-current-month .numInputWrapper span.arrowDown:after {
            border-bottom-color: white !important;
            border-top-color: white !important;
        }
        
        .flatpickr-months .flatpickr-prev-month svg,
        .flatpickr-months .flatpickr-next-month svg {
            fill: white !important;
        }
        
        .flatpickr-weekdays {
            background: #FFF5F0 !important;
        }
        
        span.flatpickr-weekday {
            color: #FF4400 !important;
            font-weight: 600 !important;
        }
        
        .flatpickr-day {
            border-radius: 0.5rem !important;
            margin: 2px !important;
        }
        
        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: #FF4400 !important;
            border-color: #FF4400 !important;
        }
        
        .flatpickr-day:hover:not(.selected):not(.flatpickr-disabled) {
            background: #FFF5F0 !important;
            border-color: #FFE5D9 !important;
            color: #FF4400 !important;
        }
        
        .flatpickr-day.today {
            border-color: #FF4400 !important;
            color: #FF4400 !important;
        }
        
        .flatpickr-day.today:hover {
            background: #FFF5F0 !important;
            border-color: #FF4400 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 1;

            // Initialize Choices.js for Province
            const provinceSelect = document.getElementById('pickup_province');
            const citySelect = document.getElementById('pickup_province');
            const districtSelect = document.getElementById('pickup_city');

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

            // Initialize Flatpickr
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

            // Load Cities when Province changes
            const loadCities = (provinceId, selectedCityId = null) => {
                cityChoices.clearStore();
                cityChoices.setChoices([{ value: '', label: 'Memuat kota...', disabled: true, selected: true }], 'value', 'label', true);
                citySelect.disabled = true;
                cityChoices.disable();
                
                // Reset districts
                districtChoices.clearStore();
                districtChoices.setChoices([{ value: '', label: 'Pilih Kecamatan', disabled: true, selected: true }], 'value', 'label', true);
                districtSelect.disabled = true;
                districtChoices.disable();

                if (provinceId) {
                    fetch(`/api/cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            const choices = data.map(city => ({ value: city.id, label: city.name }));
                            cityChoices.setChoices(choices, 'value', 'label', true);
                            citySelect.disabled = false;
                            cityChoices.enable();

                            if (selectedCityId) {
                                cityChoices.setChoiceByValue(selectedCityId);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            cityChoices.setChoices([{ value: '', label: 'Gagal memuat kota', disabled: true, selected: true }], 'value', 'label', true);
                        });
                }
            };

            // Load Districts when City changes
            const loadDistricts = (cityId, selectedDistrictId = null) => {
                districtChoices.clearStore();
                districtChoices.setChoices([{ value: '', label: 'Memuat kecamatan...', disabled: true, selected: true }], 'value', 'label', true);
                districtSelect.disabled = true;
                districtChoices.disable();

                if (cityId) {
                    fetch(`/api/districts/${cityId}`)
                        .then(response => response.json())
                        .then(data => {
                            const choices = data.map(district => ({ value: district.id, label: district.name }));
                            districtChoices.setChoices(choices, 'value', 'label', true);
                            districtSelect.disabled = false;
                            districtChoices.enable();

                            if (selectedDistrictId) {
                                districtChoices.setChoiceByValue(selectedDistrictId);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            districtChoices.setChoices([{ value: '', label: 'Gagal memuat kecamatan', disabled: true, selected: true }], 'value', 'label', true);
                        });
                }
            };

            // Event listeners
            provinceSelect.addEventListener('change', function(e) {
                const selectedProvinceId = e.detail.value || this.value;
                loadCities(selectedProvinceId);
            });

            citySelect.addEventListener('change', function(e) {
                const selectedCityId = e.detail.value || this.value;
                loadDistricts(selectedCityId);
            });

            // Initialize with old values if exists
            const initialProvinceId = provinceSelect.value;
            if (initialProvinceId) {
                setTimeout(() => {
                    loadCities(initialProvinceId, "{{ old('pickup_province', $profile->default_city ?? '') }}");
                    
                    const initialCityId = "{{ old('pickup_province', $profile->default_city ?? '') }}";
                    if (initialCityId) {
                        setTimeout(() => {
                            loadDistricts(initialCityId, "{{ old('pickup_city') }}");
                        }, 500);
                    }
                }, 100);
            }

            // Add new donation item
            document.getElementById('addItemBtn').addEventListener('click', function() {
                const container = document.getElementById('itemsContainer');
                const newItem = `
                    <div class="item-row border border-gray-200 rounded-xl p-5 relative bg-gray-50">
                        <button type="button" class="remove-item absolute top-3 right-3 text-red-500 hover:text-red-700 transition-colors">
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
                
                container.insertAdjacentHTML('beforeend', newItem);
                itemIndex++;
                updateRemoveButtons();
            });

            // Remove item
            document.addEventListener('click', function(e) {
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

            // Form validation
            document.getElementById('donationForm').addEventListener('submit', function(e) {
                const items = document.querySelectorAll('.item-row');
                if (items.length === 0) {
                    e.preventDefault();
                    alert('Tambahkan minimal 1 item donasi!');
                }
            });
        });
    </script>
@endpush