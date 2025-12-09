@extends('layouts.app')

@section('content')

{{-- Wrapper konten (Memastikan padding dan space antar section konsisten) --}}
<div class="space-y-8">
    
    {{-- HEADER: Judul dan Tombol Burger (Responsif) --}}
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-semibold text-[#1D1D1D]">Ringkasan Aktivitas</h1>
    </div>
    
    {{-- GRID STATISTIK: Responsif (1 kolom di mobile, 2 di small/tablet, 3 di large/desktop) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Kartu 1: Total Donasi Anda --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-orange-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-medium text-gray-500">Total Donasi Anda</p>
            <div class="flex items-center justify-between mt-1">
                {{-- Format angka lebih baik menggunakan number_format atau locale --}}
                <span class="text-4xl font-bold text-[#1D1D1D]">{{ number_format($stats['total_donations'] ?? 0) }}</span>
                <i class="fa-solid fa-hand-holding-heart text-orange-500 text-2xl"></i>
            </div>
            <p class="text-xs text-gray-400 mt-2">Jumlah keseluruhan donasi yang tercatat.</p>
        </div>

        {{-- Kartu 2: Total Barang Didonasikan --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-medium text-gray-500">Total Barang Didonasikan</p>
            <div class="flex items-center justify-between mt-1">
                <span class="text-4xl font-bold text-[#1D1D1D]">{{ number_format($stats['total_items'] ?? 0) }}</span>
                <i class="fa-solid fa-box-open text-red-500 text-2xl"></i>
            </div>
            <p class="text-xs text-gray-400 mt-2">Total unit barang yang Anda berikan.</p>
        </div>

        {{-- Kartu 3: Donasi Menunggu Dijemput --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-medium text-gray-500">Donasi Menunggu Dijemput</p>
            <div class="flex items-center justify-between mt-1">
                <span class="text-4xl font-bold text-[#1D1D1D]">{{ number_format($stats['active_donations'] ?? 0) }}</span>
                <i class="fa-solid fa-truck-ramp-box text-green-500 text-2xl"></i>
            </div>
            <p class="text-xs text-gray-400 mt-2">Donasi yang sedang dalam proses penjemputan.</p>
        </div>
    </div>

    <h2 class="text-2xl font-semibold text-[#1D1D1D] pt-4">Donasi Terbaru</h2>

    {{-- TABEL DONASI TERBARU --}}
    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
        @if(isset($recentDonations) && $recentDonations->isEmpty())
            <div class="text-center py-10 text-gray-500">
                <i class="fa-solid fa-sack-dollar text-4xl mb-3"></i>
                <p>Anda belum memiliki riwayat donasi terbaru.</p>
                <a href="{{ route('profile.riwayat') }}" class="mt-4 inline-block text-orange-500 hover:text-orange-600 font-medium">Lihat Semua Riwayat</a>
            </div>
        @else
            {{-- Overflow-x-auto penting untuk responsivitas tabel di mobile --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kampanye
                            </th>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Detail Barang
                            </th>
                            <th scope="col" class="px-3 sm:px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentDonations as $donation)
                        <tr>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $donation->created_at->format('d M Y') }}
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $donation->campaign->title ?? 'N/A' }}
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = [
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                        'menunggu_penjemputan' => 'bg-blue-100 text-blue-800',
                                        'dalam_perjalanan' => 'bg-purple-100 text-purple-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800',
                                    ][$donation->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ str_replace('_', ' ', ucfirst($donation->status)) }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-4 text-sm text-gray-500">
                                @foreach($donation->items as $item)
                                    <span class="block lg:inline">{{ $item->quantity }}x {{ $item->item_category }}@if(!$loop->last), @endif</span>
                                @endforeach
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('donations.show', $donation->id) }}" class="text-orange-600 hover:text-orange-900">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Tombol Lihat Semua Riwayat di bawah tabel --}}
            <div class="mt-4 text-right">
                <a href="{{ route('profile.riwayat') }}" class="text-orange-500 hover:text-orange-600 font-medium text-sm">Lihat Semua Riwayat Donasi &rarr;</a>
            </div>

        @endif
    </div>
</div>
@endsection