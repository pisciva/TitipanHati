@extends('layouts.dash-admin')

@section('title', 'Detail Donasi #' . $donation->id)

@section('content')

@php
    // Helper untuk memetakan status ke warna dan ikon
    $statusMap = [
        'menunggu_penjemputan' => ['color' => 'bg-yellow-500', 'text' => 'text-yellow-800', 'icon' => 'fas fa-clock', 'display' => 'Menunggu Penjemputan'],
        'dalam_perjalanan' => ['color' => 'bg-blue-500', 'text' => 'text-blue-800', 'icon' => 'fas fa-truck', 'display' => 'Dalam Perjalanan'],
        'selesai' => ['color' => 'bg-green-500', 'text' => 'text-green-800', 'icon' => 'fas fa-check-circle', 'display' => 'Selesai'],
        'dibatalkan' => ['color' => 'bg-red-500', 'text' => 'text-red-800', 'icon' => 'fas fa-times-circle', 'display' => 'Dibatalkan'],
    ];

    $currentStatus = $statusMap[strtolower($donation->status)] ?? ['color' => 'bg-gray-500', 'text' => 'text-gray-800', 'icon' => 'fas fa-question-circle', 'display' => 'Tidak Diketahui'];
    
    // Logika tambahan untuk menentukan warna dinamis untuk kartu Update Status
    // Kita ambil basis warnanya (misal: 'yellow' dari 'bg-yellow-500')
    $colorBase = explode('-', $currentStatus['color'])[1] ?? 'gray';
    
    // Tentukan warna latar, batas, dan teks judul kartu Update Status
    $cardBg = "bg-{$colorBase}-50";
    $cardBorder = "border-{$colorBase}-200";
    $cardText = "text-{$colorBase}-700";
@endphp

<!-- Header Section -->
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Detail Donasi {{ $donation->donor_name }}</h1>
        <p class="text-sm text-gray-500 mt-1">Status saat ini: <span class="font-semibold {{ $currentStatus['text'] }}">{{ $currentStatus['display'] }}</span></p>
    </div>
    <a href="{{ route('admin.donations.index') }}" 
       class="px-5 py-2.5 bg-[#FF4400] text-[#F8FAFC] font-semibold rounded-xl hover:bg-[#EB3F00] transition duration-150 shadow-md flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Donasi
    </a>
</div>

<!-- Success/Error Messages -->
@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4" role="alert">
        <ul class="mt-1 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Column 1 & 2: Donation Info and Items -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Card: Informasi Umum Donasi -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Informasi Donasi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 font-medium">Tanggal Dibuat:</p>
                    <p class="text-gray-900 font-medium">{{ $donation->created_at->translatedFormat('d F Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Campaign Tujuan:</p>
                    <p class="text-[#FF4400] font-medium">{{ $donation->campaign->title ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Tanggal Penjemputan:</p>
                    <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($donation->pickup_date)->translatedFormat('l, d F Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Waktu Penjemputan:</p>
                    <p class="text-gray-900 font-medium">{{ $donation->pickup_time_slot }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Tipe Pengiriman:</p>
                    <p class="text-gray-900 font-medium">{{ $donation->delivery_type == 'pickup' ? 'Penjemputan' : 'Kirim Sendiri' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Catatan Penjemputan:</p>
                    <p class="text-gray-900 font-medium">{{ $donation->pickup_notes ?? 'Tidak ada catatan' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-gray-500 font-medium">Alamat Penjemputan:</p>
                    <p class="text-gray-900">{{ $donation->pickup_address }}</p>
                    @if ($donation->notes_for_courier)
                        <p class="text-xs text-red-500 italic mt-1">Catatan Kurir: {{ $donation->notes_for_courier }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card: Informasi Donatur -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Informasi Donatur</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 font-medium">Nama Donatur:</p>
                    <p class="text-gray-900 font-medium">{{ $donation->donor_name ?? 'Anonim' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Email:</p>
                    <p class="text-gray-900">{{ $donation->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Nomor Telepon:</p>
                    <p class="text-gray-900 font-medium">{{ $donation->donor_phone }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Kode Pos:</p>
                    <p class="text-gray-900">{{ $donation->pickup_postal_code }}</p>
                </div>
            </div>
        </div>

        <!-- Card: Daftar Barang Donasi -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Daftar Barang yang Didonasikan ({{ $donation->items->count() }} Jenis)</h2>
            
            <div class="space-y-3">
                @forelse ($donation->items as $item)
                    <div class="flex justify-between items-center p-3 border border-gray-100 rounded-xl bg-gray-50">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item->name }}</p>
                            <p class="text-lg text-[#1D1D1D]">{{ $item->item_category ?? 'Tidak ada' }}</p>
                        </div>
                        <span class="text-lg font-bold text-[#FF4400]">{{ $item->quantity }} pcs</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Tidak ada barang yang terdaftar untuk donasi ini.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Column 3: Status Update and Tracking -->
    <div class="lg:col-span-1 space-y-6">

        <!-- Card: Update Status Donasi -->
        {{-- MENGGUNAKAN WARNA DINAMIS BERDASARKAN STATUS SAAT INI --}}
        <div class="sticky top-6 {{ $cardBg }} p-6 rounded-2xl shadow-xl border {{ $cardBorder }}">
            <h2 class="text-xl font-bold {{ $cardText }} mb-4 border-b {{ $cardBorder }} pb-2">Perbarui Status Donasi</h2>
            
            <div class="flex items-center mb-4">
                <i class="{{ $currentStatus['icon'] }} text-3xl {{ $currentStatus['text'] }} mr-3"></i>
                <div>
                    <p class="text-sm font-medium text-gray-600">Status Saat Ini:</p>
                    <span class="text-lg font-bold {{ $currentStatus['text'] }}">{{ $currentStatus['display'] }}</span>
                </div>
            </div>

            <form action="{{ route('admin.donations.updateStatus', $donation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Baru</label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                        <option value="">Pilih Status</option>
                        <option value="menunggu_penjemputan" {{ $donation->status === 'menunggu_penjemputan' ? 'selected' : '' }}>Menunggu Penjemputan</option>
                        <option value="dalam_perjalanan" {{ $donation->status === 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                        <option value="selesai" {{ $donation->status === 'selesai' ? 'selected' : '' }}>Selesai (Barang Diterima)</option>
                        <option value="dibatalkan" {{ $donation->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition"
                              placeholder="Contoh: Kurir sudah menjemput jam 10:00"></textarea>
                </div>

                <button type="submit" 
                        class="w-full py-2.5 bg-[#FF4400] text-white font-semibold rounded-xl hover:bg-[#EB3F00] transition duration-150 shadow-md">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan Status
                </button>
            </form>
        </div>

        <!-- Card: Riwayat Status (Tracking) -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Status</h2>
            
            <ol class="relative border-l border-gray-200 ml-4 space-y-4">
                @forelse ($donation->tracking->sortByDesc('status_changed_at') as $track)
                    @php
                        $trackStatus = $statusMap[strtolower($track->status)] ?? ['text' => 'text-gray-800', 'display' => 'Unknown'];
                    @endphp
                    <li class="mb-4 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -left-3 ring-8 ring-white {{ $trackStatus['color'] }} text-white">
                            <i class="{{ $trackStatus['icon'] }} text-xs"></i>
                        </span>
                        <h3 class="flex items-center mb-1 text-base font-semibold text-gray-900">
                            {{ $trackStatus['display'] }}
                        </h3>
                        <time class="block mb-2 text-xs font-normal leading-none text-gray-500">
                            {{ \Carbon\Carbon::parse($track->status_changed_at)->translatedFormat('d M Y, H:i') }}
                        </time>
                        <p class="text-sm font-normal text-gray-700">
                            {{ $track->notes }}
                        </p>
                    </li>
                @empty
                    <p class="text-gray-500 ml-6">Belum ada riwayat pelacakan.</p>
                @endforelse
            </ol>
        </div>

    </div>
</div>


@endsection