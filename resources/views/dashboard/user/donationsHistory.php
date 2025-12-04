@extends('layouts.app')

@section('title', 'Detail Donasi #' . $donation->id)

@section('content')

@php
    $currentRouteName = Route::currentRouteName();
    \Carbon\Carbon::setLocale('id');

    // Status mapping
    $statusRaw = $donation->status ?? 'unknown';
    $statusText = ucwords(str_replace(['_', '-'], ' ', $statusRaw));
    $statusMap = [
        'Menunggu Penjemputan' => ['dot' => 'bg-[#FF4400]', 'text' => 'text-[#FF4400]', 'icon' => 'fa-hourglass-start'],
        'Dalam Perjalanan' => ['dot' => 'bg-blue-500', 'text' => 'text-blue-500', 'icon' => 'fa-truck-fast'],
        'Selesai' => ['dot' => 'bg-green-500', 'text' => 'text-green-500', 'icon' => 'fa-check-circle'],
        'Dibatalkan' => ['dot' => 'bg-red-500', 'text' => 'text-red-500', 'icon' => 'fa-times-circle'],
        'Unknown' => ['dot' => 'bg-gray-500', 'text' => 'text-gray-500', 'icon' => 'fa-question-circle'],
    ];
    $currentStatus = $statusMap[$statusText] ?? $statusMap['Unknown'];
@endphp

<div class="w-full flex min-h-screen">

    {{-- SIDEBAR --}}
    <div class="w-64 border-r border-gray-100 p-8 flex flex-col justify-between bg-white sticky top-0" style="min-height: 100vh;">
        <div>
            <div class="flex flex-col items-center mt-6">
                <div class="w-20 h-20 rounded-full bg-gray-200 mb-4 overflow-hidden flex items-center justify-center border-2 border-[#FF4400]">
                    <i class="fas fa-user text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-lg font-semibold text-[#1d1d1d] text-center">{{ Auth::user()->name ?? 'Pengguna' }}</h2>
                <p class="text-gray-500 text-sm mt-1 text-center">{{ Auth::user()->email }}</p>
            </div>

            <div class="w-full flex justify-start mt-10">
                <div class="space-y-3 w-full">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-4 text-base p-3 rounded-xl transition-colors
                       {{ $currentRouteName === 'dashboard' ? 'text-[#FF4400] font-semibold bg-[#FFF4F2]' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-user text-lg w-5 text-center leading-none"></i>
                        <span>Profil</span>
                    </a>

                    <a href="{{ route('profile.riwayat') }}" 
                       class="flex items-center gap-4 text-base p-3 rounded-xl transition-colors
                       {{ ($currentRouteName === 'profile.riwayat' || $currentRouteName === 'donations.show') ? 'text-[#FF4400] font-semibold bg-[#FFF4F2]' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-clock-rotate-left text-lg w-5 text-center leading-none"></i>
                        <span>Riwayat Donasi</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-auto pt-8 flex justify-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 w-40 border border-[#FF4400] text-[#FF4400] rounded-xl hover:bg-[#FFF4F2] transition font-medium">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>

    {{-- KONTEN DETAIL DONASI --}}
    <div class="flex-grow p-10 bg-gray-50">
        <div class="max-w-5xl mx-auto">

            {{-- Header --}}
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <a href="{{ route('profile.riwayat') }}" class="text-gray-500 hover:text-[#FF4400] transition font-medium mb-4 sm:mb-0 text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat Donasi
                </a>
                <h1 class="text-3xl font-bold text-gray-900">
                    Detail Donasi <span class="text-[#FF4400]">#{{ $donation->id }}</span>
                </h1>
            </div>

            {{-- Card Detail --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-100 pb-4 mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $donation->campaign->title ?? 'Campaign Tidak Diketahui' }}</h2>
                        <p class="text-sm text-gray-500">
                            Donasi dibuat pada: {{ \Carbon\Carbon::parse($donation->created_at)->translatedFormat('l, j F Y') }}
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex items-center">
                        <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $currentStatus['dot'] }} {{ $currentStatus['text'] }}">
                            <i class="fas {{ $currentStatus['icon'] }} mr-1"></i> {{ $statusText }}
                        </span>
                    </div>
                </div>

                {{-- Detail Barang --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($donation->items as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm font-medium text-gray-900 flex items-center">
                                            <i class="fas fa-box-open mr-2 text-[#FF4400]"></i> {{ $item->item_type }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">{{ $item->description ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-800">{{ $item->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-6 text-center text-gray-500 italic">Tidak ada barang yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Catatan --}}
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Catatan Donatur</h3>
                    <div class="p-4 rounded-lg border-l-4 {{ $donation->notes ? 'border-[#FF4400] bg-gray-50' : 'border-gray-300 bg-gray-50' }}">
                        <p class="text-gray-600 italic text-sm">
                            {{ $donation->notes ?? 'Tidak ada catatan tambahan dari donatur.' }}
                        </p>
                    </div>
                </div>

                {{-- Timeline / Tracking --}}
                @if($donation->tracking && $donation->tracking->isNotEmpty())
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Riwayat Status Donasi</h3>
                    <ol class="relative border-l-4 border-gray-200 ml-3">
                        @foreach ($donation->tracking->sortBy('created_at') as $tracking)
                            @php
                                $trackStatusText = ucwords(str_replace(['_', '-'], ' ', $tracking->status));
                                $isLast = $loop->last;
                                $dotColor = $isLast ? 'bg-[#FF4400]' : 'bg-gray-400';
                                $textColor = $isLast ? 'text-gray-900' : 'text-gray-600';
                            @endphp
                            <li class="mb-8 ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 {{ $dotColor }} rounded-full -left-3.5 ring-4 ring-white shadow-md">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </span>
                                <h3 class="mb-1 text-base font-bold {{ $textColor }}">{{ $trackStatusText }}</h3>
                                <time class="block mb-2 text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($tracking->created_at)->translatedFormat('l, j F Y, H:i') }}
                                </time>
                                <p class="text-sm text-gray-500">{{ $tracking->notes ?? 'Status donasi telah diperbarui.' }}</p>
                            </li>
                        @endforeach
                    </ol>
                </div>
                @endif

            </div>

        </div>
    </div>
</div>

@endsection
