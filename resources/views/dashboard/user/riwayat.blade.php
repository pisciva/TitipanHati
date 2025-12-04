@extends('layouts.app')

@section('title', 'Riwayat Donasi Anda')

@section('content')

@php
    $currentRouteName = Route::currentRouteName();
@endphp

<!-- Container Utama -->
<div class="w-full flex min-h-screen">

    <!-- Sidebar Kiri -->
    <div class="w-64 border-r border-gray-100 p-8 flex flex-col justify-between bg-white sticky top-0" style="min-height: 100vh;">

        <!-- Bagian atas: Profil & Navigasi -->
        <div>
            <div class="flex flex-col items-center mt-6">
                <div class="w-20 h-20 rounded-full bg-gray-200 mb-4 overflow-hidden">
                    <!-- Avatar profil jika ada -->
                </div>

                <h2 class="text-lg font-semibold text-[#1d1d1d]">{{ Auth::user()->name ?? 'Profil Pengguna' }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ Auth::user()->email }}</p>
            </div>

            <!-- Navigasi: Dashboard & Riwayat -->
            <div class="w-full flex justify-start mt-10">
                <div class="space-y-4 w-full">

                    <!-- Profil / Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-4 text-base p-2 rounded-xl transition-colors
                       {{ $currentRouteName === 'dashboard' ? 'text-[#FF4400] font-semibold bg-[#FFF4F2]' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-user text-lg w-5 text-center leading-none"></i>
                        <span>Profil</span>
                    </a>

                    <!-- Riwayat Donasi -->
                    <a href="{{ route('profile.riwayat') }}" 
                       class="flex items-center gap-4 text-base p-2 rounded-xl transition-colors
                       {{ $currentRouteName === 'profile.riwayat' ? 'text-[#FF4400] font-semibold bg-[#FFF4F2]' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-clock-rotate-left text-lg w-5 text-center leading-none"></i>
                        <span>Riwayat</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bagian bawah (Logout) -->
        <div class="mt-auto pt-8 flex justify-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 w-40 border border-[#FF4400] text-[#FF4400] rounded-xl hover:bg-[#FFF4F2] transition font-medium">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="flex-grow p-10 bg-gray-50">
        
        <!-- Judul Halaman -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Donasi</h1>
        </div>

        <!-- Filter Status Donasi -->
        @php
            $statuses = [
                '' => 'Daftar semua donasi',
                'menunggu_penjemputan' => 'Menunggu Penjemputan',
                'dalam_perjalanan' => 'Dalam Perjalanan',
                'selesai' => 'Selesai Disalurkan',
                'dibatalkan' => 'Dibatalkan',
            ];
            $currentStatus = request()->get('status', '');
        @endphp

        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            
            <!-- Header Filter -->
            <div class="mb-6">
                @if ($currentStatus === '')
                    <h2 class="text-xl font-bold text-gray-800">Daftar semua donasi</h2>
                @else
                    <h2 class="text-xl font-bold text-gray-800">Filter: {{ $statuses[$currentStatus] }}</h2>
                @endif
            </div>
            
            <div class="flex flex-wrap gap-3 pb-4 mb-6 border-b border-gray-200">
                @foreach ($statuses as $key => $label)
                    @php
                        $isActive = $currentStatus === $key;
                        $baseClass = 'px-4 py-2 text-sm font-semibold rounded-full transition-colors duration-200 border';
                        $activeClass = 'text-white bg-[#FF4400] border-[#FF4400] shadow-md';
                        $inactiveClass = 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50';
                        $url = $key ? route('profile.riwayat', ['status' => $key]) : route('profile.riwayat');
                    @endphp
                    <a href="{{ $url }}" class="{{ $baseClass }} {{ $isActive ? $activeClass : $inactiveClass }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Daftar Donasi -->
            @if ($donations->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <i class="fas fa-hand-holding-heart text-4xl mb-3 text-gray-400"></i>
                    <p class="font-medium">Tidak ada riwayat donasi dalam status ini.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($donations as $donation)
                        @php
                            $statusText = ucwords(str_replace('_', ' ', $donation->status));
                            $statusData = [
                                'Menunggu Penjemputan' => ['dot' => 'bg-[#FF4400]', 'text' => 'text-[#FF4400]'],
                                'Dalam Perjalanan' => ['dot' => 'bg-blue-500', 'text' => 'text-blue-500'],
                                'Selesai' => ['dot' => 'bg-green-500', 'text' => 'text-green-500'],
                                'Dibatalkan' => ['dot' => 'bg-red-500', 'text' => 'text-red-500'],
                            ][$statusText] ?? ['dot' => 'bg-gray-500', 'text' => 'text-gray-500'];

                            $statusDot = $statusData['dot'];
                            $totalItems = $donation->items->sum('quantity');
                        @endphp

                        <div class="p-4 border border-gray-200 rounded-xl flex items-center justify-between hover:shadow-sm transition duration-150">

                            <!-- Kiri & Tengah -->
                            <div class="flex-1 flex gap-6 items-center">

                                <!-- Tanggal -->
                                <div class="flex-shrink-0 w-32 text-left">
                                    <p class="text-sm font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse($donation->created_at)->translatedFormat('F j, Y') }}
                                    </p>
                                </div>

                                <!-- Campaign & Item Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 flex items-center">
                                        <span class="w-2 h-2 rounded-full {{ $statusDot }} mr-2"></span>
                                        Donasi {{ $donation->campaign->title ?? 'Campaign Tidak Diketahui' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5 ml-4">
                                        {{ $donation->items->count() }} Jenis Barang
                                    </p>
                                </div>
                            </div>

                            <!-- Kanan: Item Count & Detail Link -->
                            <div class="flex-shrink-0 flex items-center gap-6">

                                <!-- Item Count -->
                                <div class="text-right w-24">
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $totalItems > 0 ? $totalItems . ' + Barang' : 'Barang Tidak Diketahui' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        Pengiriman: {{ \Carbon\Carbon::parse($donation->pickup_date)->translatedFormat('F j, Y') }}
                                    </p>
                                </div>

                                <!-- Detail Link -->
                                <a href="{{ route('donations.show', $donation->id) }}"
                                   class="flex items-center text-[#FF4400] font-semibold text-sm hover:text-[#EB3F00] flex-shrink-0 transition">
                                    Detail Donasi
                                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $donations->appends(request()->except('page'))->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
