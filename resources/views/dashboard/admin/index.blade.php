@extends('layouts.dash-admin')

@section('title', 'Ringkasan Dashboard')
@section('header', '')

@section('content')


    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Halo, Admin</h1>

        <p class="text-sm text-gray-500 mt-1">Today is {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>


    <div class="mb-10 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
        

        <form method="GET" action="{{ route('admin.campaigns.index') }}" class="flex-1 w-full sm:w-auto">
            <div class="relative  items-centerjustify-center flex">

                <input type="text" name="search" placeholder="Cari Campaign" 
                       value="{{ request('search') }}" 
                       class="w-full pl-10 pr-4 py-3 border-none bg-gray-200 rounded-xl focus:ring-red-600 focus:border-red-600 text-base transition shadow-none" />
                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 p-0 m-0 border-none bg-transparent items-center justify-center flex">
                    <i class="fas fa-search w-4 h-4"></i>
                </button>
            </div>
        </form>

        
        <a href="{{ route('admin.campaigns.create') }}" 
           class="w-full sm:w-auto px-6 py-3 bg-[#FF4400] text-white font-semibold rounded-xl hover:bg-[#EB3F00] transition duration-150 shadow-md flex items-center justify-center">
            <span>Tambah Campaign</span>
        </a>
    </div>


    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    

        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 rounded-full bg-gray-100">
                    <i class="fas fa-hand-holding-heart w-6 h-6 text-gray-800"></i>
                </div>
                <h2 class="text-base font-semibold text-[#FF4400]">Campaign Aktif</h2>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-4xl font-bold text-gray-900">{{ $stats['active_campaigns'] ?? 0 }}</p>
                

                @php
                    $change = $stats['active_campaign_change'] ?? 0;
                    $isPositive = $change >= 0;
                    $class = $isPositive ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100';
                    $icon = $isPositive ? 'fas fa-arrow-up' : 'fas fa-arrow-down';
                @endphp
                <div class="flex items-center text-xs font-bold px-3 py-1 rounded-full {{ $class }}">
                    <i class="{{ $icon }} text-xs mr-1"></i> 
                    {{ abs($change) }}%
                </div>

            </div>
        </div>


        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 rounded-full bg-gray-100">
                    <i class="fas fa-box w-6 h-6 text-gray-800"></i>
                </div>
                <h2 class="text-base font-semibold text-[#FF4400]">Donasi Tersalurkan</h2>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-4xl font-bold text-gray-900">{{ $stats['total_donations'] ?? 0 }}</p>
                

                @php
                    $change = $stats['total_donations_change'] ?? 0;

                    $isPositive = $change >= 0;
                    $class = $isPositive ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100';
                    $icon = $isPositive ? 'fas fa-arrow-up' : 'fas fa-arrow-down';
                @endphp
                <div class="flex items-center text-xs font-bold px-3 py-1 rounded-full {{ $class }}">
                    <i class="{{ $icon }} text-xs mr-1"></i> 
                    {{ abs($change) }}%
                </div>

            </div>
        </div>


        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 rounded-full bg-gray-100">
                    <i class="fas fa-truck-loading w-6 h-6 text-gray-800"></i>
                </div>
                <h2 class="text-base font-semibold text-[#FF4400]">Menunggu Penjemputan</h2>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-4xl font-bold text-gray-900">{{ $stats['pending_pickups'] ?? 0 }}</p>
                <span class="text-sm text-gray-500">Donasi</span>
            </div>
        </div>


        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 rounded-full bg-gray-100">
                    <i class="fas fa-boxes w-6 h-6 text-gray-800"></i>
                </div>
                <h2 class="text-base font-semibold text-[#FF4400]">Total Barang (Unit)</h2>
            </div>
             <div class="flex items-center justify-between">
                <p class="text-4xl font-bold text-gray-900">{{ number_format($stats['total_items'] ?? 0, 0, ',', '.') }}</p>
                <span class="text-sm text-gray-500">Unit</span>
            </div>
        </div>

    </section>


    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        

        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex justify-between items-center">
                <span>Donasi Terbaru</span>
                <a href="{{ route('admin.donations.index') }}" class="text-sm font-medium text-[#FF4400] hover:text-[#EB3F00] transition">Lihat Semua &rarr;</a>
            </h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-xl">Donatur</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-xl">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-sm">
                        @forelse ($recentDonations as $donation)
                            <tr class="hover:bg-gray-50 transition duration-150 cursor-pointer" onclick="window.location='{{ route('admin.donations.show', $donation->id) }}'">
                                <td class="px-4 py-3 text-gray-800 font-medium">{{ $donation->donor_name ?? 'Pengguna Dihapus' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $donation->campaign->title ?? 'Campaign Dihapus' }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $status = $donation->status;
                                        $statusClass = [
                                            'selesai' => 'bg-green-100 text-green-800', 
                                            'menunggu_penjemputan' => 'bg-yellow-100 text-yellow-800',
                                            'diproses' => 'bg-blue-100 text-blue-800',
                                            'batal' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusText = [
                                            'selesai' => 'Selesai',
                                            'menunggu_penjemputan' => 'Menunggu Jemput',
                                            'diproses' => 'Diproses',
                                            'batal' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusText[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $donation->created_at->translatedFormat('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500 bg-white">
                                    Belum ada donasi terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        

        <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex justify-between items-center">
                <span>Campaign Segera Berakhir</span>
                <a href="{{ route('admin.campaigns.index') }}" class="text-sm font-medium text-[#FF4400] hover:text-[#EB3F00] transition">Semua Campaign &rarr;</a>
            </h2>
            
            <ul class="space-y-4">
                @forelse ($urgentCampaigns as $campaign)
                    <li class="border border-gray-200 p-4 rounded-xl flex flex-col bg-gray-50 hover:bg-gray-100 transition duration-150">
                        <a href="{{ route('admin.campaigns.show', $campaign->id) }}" class="text-base font-semibold text-gray-800 hover:text-red-600 transition mb-1 line-clamp-1">
                            {{ $campaign->title }}
                        </a>
                        <div class="flex justify-between items-end mt-1">
                            <p class="text-sm text-gray-500">
                                Batas Akhir: 
                                <span class="text-red-600 font-medium">
                                    {{ $campaign->deadline->diffForHumans() }}
                                </span>
                            </p>
                            <p class="text-sm font-bold text-[#FF4400]">

                                {{ $campaign->target_quantity ?? 'N/A' }} Unit
                            </p>
                        </div>
                    </li>
                @empty
                    <li class="p-4 text-center text-gray-500 bg-gray-50 rounded-xl">
                        Tidak ada campaign yang mendekati batas waktu.
                    </li>
                @endforelse
            </ul>
        </div>

    </section>

@endsection