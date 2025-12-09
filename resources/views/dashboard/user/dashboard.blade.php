@extends('layouts.dash-user')

@section('title', 'Dashboard User')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Selamat Datang, {{ Auth::user()->profile->full_name ?? 'User' }}! 👋</h1>
            <p class="text-gray-500 mt-1">Berikut adalah ringkasan aktivitas donasi Anda</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-orange-50 p-6 rounded-2xl shadow-sm border border-orange-100 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-hand-holding-heart text-orange-500 text-xl"></i>
                </div>
                <div class="px-3 py-1 bg-orange-100 rounded-full">
                    <span class="text-xs font-semibold text-orange-600">Total</span>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Donasi Anda</p>
            <span class="text-4xl font-bold text-gray-900">{{ number_format($stats['total_donations'] ?? 0) }}</span>
            <p class="text-xs text-gray-500 mt-3 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>
                Jumlah keseluruhan donasi yang tercatat
            </p>
        </div>

        <div class="bg-red-50 p-6 rounded-2xl shadow-sm border border-red-100 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-box-open text-red-500 text-xl"></i>
                </div>
                <div class="px-3 py-1 bg-red-100 rounded-full">
                    <span class="text-xs font-semibold text-red-600">Items</span>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Barang Didonasikan</p>
            <span class="text-4xl font-bold text-gray-900">{{ number_format($stats['total_items'] ?? 0) }}</span>
            <p class="text-xs text-gray-500 mt-3 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>
                Total unit barang yang Anda berikan
            </p>
        </div>

        <div class="bg-green-50 p-6 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-truck-ramp-box text-green-500 text-xl"></i>
                </div>
                <div class="px-3 py-1 bg-green-100 rounded-full">
                    <span class="text-xs font-semibold text-green-600">Active</span>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Menunggu Dijemput</p>
            <span class="text-4xl font-bold text-gray-900">{{ number_format($stats['active_donations'] ?? 0) }}</span>
            <p class="text-xs text-gray-500 mt-3 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>
                Donasi sedang dalam proses penjemputan
            </p>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Donasi Terbaru</h2>
        <a href="{{ route('donations.history') }}" class="text-[#FF4400] hover:text-[#DE3B00] font-semibold text-sm flex items-center gap-2 transition-colors">
            Lihat Semua
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        @if(isset($recentDonations) && $recentDonations->isEmpty())
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-hand-holding-heart text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Donasi</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki riwayat donasi terbaru</p>
                <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#FF4400] text-white rounded-xl hover:bg-[#DE3B00] transition-colors font-semibold">
                    <i class="fas fa-plus"></i>
                    Mulai Berdonasi
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Kampanye
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Detail Barang
                            </th>
                            <th scope="col" class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($recentDonations as $donation)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar text-gray-400 text-sm"></i>
                                    <span class="text-sm font-medium text-gray-900">{{ $donation->created_at->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900 max-w-xs truncate">
                                    {{ $donation->campaign->title ?? 'N/A' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $donation->campaign->organization->name ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = [
                                        'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-check-circle'],
                                        'menunggu_pembayaran' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'fa-clock'],
                                        'menunggu_penjemputan' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-truck'],
                                        'dalam_perjalanan' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'fa-shipping-fast'],
                                        'dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'fa-times-circle'],
                                    ];
                                    $config = $statusConfig[$donation->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fa-info-circle'];
                                @endphp
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 {{ $config['bg'] }} {{ $config['text'] }} text-xs font-semibold rounded-lg">
                                    <i class="fas {{ $config['icon'] }}"></i>
                                    {{ str_replace('_', ' ', ucfirst($donation->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($donation->items->take(2) as $item)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">
                                            <i class="fas fa-box text-gray-500"></i>
                                            {{ $item->quantity }}x {{ $item->item_category }}
                                        </span>
                                    @endforeach
                                    @if($donation->items->count() > 2)
                                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-lg">
                                            +{{ $donation->items->count() - 2 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('donations.show', $donation->id) }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#FF4400] text-white text-sm font-semibold rounded-lg hover:bg-[#DE3B00] transition-colors">
                                    Detail
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection