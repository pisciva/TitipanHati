@extends('layouts.app')

@section('title', 'Buat Donasi - ' . $campaign->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-block">
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
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-2"></i>
                        Data Donatur
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama --}}
                        <div class="md:col-span-2">
                            <label for="donor_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="donor_name" id="donor_name" 
                                   value="{{ old('donor_name', $profile->name ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('donor_name') border-red-500 @enderror"
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
                                   value="{{ old('donor_phone', $profile->phone ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('donor_phone') border-red-500 @enderror"
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
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('donor_email') border-red-500 @enderror"
                                   placeholder="email@example.com">
                            @error('donor_email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Alamat Penjemputan --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
                        Alamat Penjemputan
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Alamat Lengkap --}}
                        <div class="md:col-span-2">
                            <label for="pickup_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="pickup_address" id="pickup_address" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pickup_address') border-red-500 @enderror"
                                      placeholder="Jalan, No. Rumah, RT/RW, Kelurahan">{{ old('pickup_address', $profile->address ?? '') }}</textarea>
                            @error('pickup_address')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kota --}}
                        <div>
                            <label for="pickup_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kota <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pickup_city" id="pickup_city" 
                                   value="{{ old('pickup_city', $profile->city ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pickup_city') border-red-500 @enderror"
                                   placeholder="Nama kota">
                            @error('pickup_city')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label for="pickup_district" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pickup_district" id="pickup_district" 
                                   value="{{ old('pickup_district', $profile->district ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pickup_district') border-red-500 @enderror"
                                   placeholder="Nama kecamatan">
                            @error('pickup_district')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kode Pos --}}
                        <div class="md:col-span-2">
                            <label for="pickup_postal_code" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Pos <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pickup_postal_code" id="pickup_postal_code" 
                                   value="{{ old('pickup_postal_code', $profile->postal_code ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pickup_postal_code') border-red-500 @enderror"
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
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Misal: Rumah cat hijau, dekat minimarket">{{ old('pickup_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Jadwal Penjemputan --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                        Jadwal Penjemputan
                    </h2>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            Penjemputan minimal 3 hari dari sekarang
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Tanggal --}}
                        <div>
                            <label for="pickup_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Penjemputan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="pickup_date" id="pickup_date" 
                                   value="{{ old('pickup_date') }}"
                                   min="{{ now()->addDays(3)->format('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pickup_date') border-red-500 @enderror">
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pickup_time_slot') border-red-500 @enderror">
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
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-box text-blue-600 mr-2"></i>
                            Barang Donasi
                        </h2>
                        <button type="button" id="addItemBtn" 
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Tambah Item
                        </button>
                    </div>

                    <div id="itemsContainer" class="space-y-4">
                        {{-- Item pertama (default) --}}
                        <div class="item-row border border-gray-300 rounded-lg p-4 relative">
                            <button type="button" class="remove-item absolute top-2 right-2 text-red-500 hover:text-red-700 hidden">
                                <i class="fas fa-times-circle text-xl"></i>
                            </button>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Gender --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jenis Kelamin <span class="text-red-500">*</span>
                                    </label>
                                    <select name="items[0][gender]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih</option>
                                        <option value="Anak Laki-laki">Anak Laki-laki</option>
                                        <option value="Anak Perempuan">Anak Perempuan</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                {{-- Kategori --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <select name="items[0][item_category]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
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
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                           placeholder="0">
                                </div>

                                {{-- Kondisi --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kondisi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="items[0][condition]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
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
                            class="flex-1 py-4 px-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Donasi
                    </button>
                    <a href="{{ route('campaigns.show', $campaign->id) }}"
                       class="px-6 py-4 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            {{-- Campaign Info --}}
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Campaign</h3>
                
                <img src="{{ $campaign->banner_url ?? '/images/default-campaign.jpg' }}" 
                     alt="{{ $campaign->title }}"
                     class="w-full h-40 object-cover rounded-lg mb-4">

                <h4 class="font-bold text-gray-900 mb-2">{{ $campaign->title }}</h4>
                
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-building text-blue-600 mr-2 w-4"></i>
                        <span>{{ $campaign->organization->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-red-600 mr-2 w-4"></i>
                        <span>{{ $campaign->city }}, {{ $campaign->province }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-green-600 mr-2 w-4"></i>
                        <span>Deadline: {{ $campaign->deadline->format('d M Y') }}</span>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress</span>
                        <span class="font-bold text-blue-600">{{ $campaign->progressPercentage() }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $campaign->progressPercentage() }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-600 mt-1">
                        <span>{{ number_format($campaign->collected_quantity) }} terkumpul</span>
                        <span>Target: {{ number_format($campaign->target_quantity) }}</span>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <p class="text-xs text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pastikan data yang Anda masukkan sudah benar. Tim kami akan menghubungi Anda untuk konfirmasi penjemputan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    let itemIndex = 1;

    // Add new item
    document.getElementById('addItemBtn').addEventListener('click', function() {
        const container = document.getElementById('itemsContainer');
        const newItem = `
            <div class="item-row border border-gray-300 rounded-lg p-4 relative">
                <button type="button" class="remove-item absolute top-2 right-2 text-red-500 hover:text-red-700">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="items[${itemIndex}][gender]" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih</option>
                            <option value="Anak Laki-laki">Anak Laki-laki</option>
                            <option value="Anak Perempuan">Anak Perempuan</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="items[${itemIndex}][item_category]" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="0">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kondisi <span class="text-red-500">*</span>
                        </label>
                        <select name="items[${itemIndex}][condition]" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
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
        items.forEach((item, index) => {
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
</script>
@endsection