@extends('layouts.app')

@section('content')
<div class="w-full flex">

    <!-- Sidebar kiri (Navigasi) -->
    <div class="w-1/4 border-r min-h-screen p-8 flex flex-col justify-between">

        <!-- Bagian atas: Info Pengguna dan Menu -->
        <div>
            <div class="flex flex-col items-center mt-10">
                <!-- Placeholder untuk Foto Profil -->
                <div class="w-28 h-28 rounded-full bg-gray-200 mb-4 flex items-center justify-center text-gray-400 text-sm">
                    <i class="fa-solid fa-camera text-2xl"></i>
                </div>

                <h2 class="text-xl font-semibold text-[#1d1d1d]">Halo, {{ Auth::user()->profile?->full_name ?? Auth::user()->name ?? 'Pengguna' }}</h2>
                <p class="text-gray-500 text-base mt-1">{{ Auth::user()->email }}</p>
            </div>

            <div class="w-full flex justify-center mt-16">
                <div class="space-y-4">
                    <!-- Link Aktif: Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-orange-600 font-semibold text-lg">
                        <span class="w-6 flex justify-center">
                            <i class="fa-solid fa-house text-[20px] leading-none"></i>
                        </span>
                        <span>Dashboard</span>
                    </a>

                    <!-- Link Non-aktif: Profil -->
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 text-gray-500 text-lg hover:text-black">
                        <span class="w-6 flex justify-center">
                            <i class="fa-solid fa-user text-[20px] leading-none"></i>
                        </span>
                        <span>Profil</span>
                    </a>

                    <!-- Link Non-aktif: Riwayat -->
                    <a href="{{ route('profile.riwayat') }}" class="flex items-center gap-3 text-gray-500 text-lg hover:text-black">
                        <span class="w-6 flex justify-center">
                            <i class="fa-solid fa-clock-rotate-left text-[20px] leading-none"></i>
                        </span>
                        <span>Riwayat</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bagian bawah (Logout) -->
        <div class="mt-10 flex justify-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 w-40 border border-orange-500 text-orange-500 rounded-2xl hover:bg-orange-50 transition duration-150">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>

    <!-- Konten kanan (Dashboard) -->
    <div class="w-3/4 p-10">
        <h1 class="text-3xl font-semibold text-[#1D1D1D] mb-8">Ringkasan Aktivitas</h1>

        <!-- Statistik Donasi -->
        <div class="grid grid-cols-3 gap-6 mb-12">

            <!-- Total Donasi -->
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-orange-500">
                <p class="text-sm font-medium text-gray-500">Total Donasi Anda</p>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-4xl font-bold text-[#1D1D1D]">{{ $stats['total_donations'] ?? 0 }}</span>
                    <i class="fa-solid fa-hand-holding-heart text-orange-500 text-2xl"></i>
                </div>
                <p class="text-xs text-gray-400 mt-2">Jumlah keseluruhan donasi yang tercatat.</p>
            </div>

            <!-- Total Barang -->
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Total Barang Didonasikan</p>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-4xl font-bold text-[#1D1D1D]">{{ $stats['total_items'] ?? 0 }}</span>
                    <i class="fa-solid fa-box-open text-red-500 text-2xl"></i>
                </div>
                <p class="text-xs text-gray-400 mt-2">Total unit barang yang Anda berikan.</p>
            </div>

            <!-- Donasi Aktif -->
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
                <p class="text-sm font-medium text-gray-500">Donasi Menunggu Dijemput</p>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-4xl font-bold text-[#1D1D1D]">{{ $stats['active_donations'] ?? 0 }}</span>
                    <i class="fa-solid fa-truck-ramp-box text-green-500 text-2xl"></i>
                </div>
                <p class="text-xs text-gray-400 mt-2">Donasi yang sedang dalam proses penjemputan.</p>
            </div>
        </div>

        <!-- Donasi Terbaru -->
        <!-- DIPERBAIKI: Menghapus angka '5' agar dinamis -->
        <h2 class="text-2xl font-semibold text-[#1D1D1D] mb-4">Donasi Terbaru</h2>

        <div class="bg-white p-6 rounded-xl shadow-lg overflow-x-auto">
            @if(isset($recentDonations) && $recentDonations->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <i class="fa-solid fa-sack-dollar text-4xl mb-3"></i>
                    <p>Anda belum memiliki riwayat donasi.</p>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kampanye
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Detail Barang
                            </th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentDonations as $donation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $donation->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $donation->campaign->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @foreach($donation->items as $item)
                                    {{ $item->quantity }}x {{ $item->item_category }}@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('donations.show', $donation->id) }}" class="text-orange-600 hover:text-orange-900">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection