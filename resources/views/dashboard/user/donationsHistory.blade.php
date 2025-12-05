@extends('layouts.app') {{-- Asumsikan Anda memiliki layout utama bernama 'layouts.app' --}}

@section('title', 'Detail Donasi Admin')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header dan Navigasi --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-gray-800">Detail Donasi</h2>
        <a href="{{ url()->previous() }}" class="text-[#FF4400] hover:text-orange-600 font-medium flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Riwayat
        </a>
    </div>
    
    <hr class="mb-6">

    {{-- Detail Donasi --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        
        {{-- Status Donasi - Mirip Tombol pada Gambar --}}
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-700">ID Donasi: <span class="text-orange-600">#{{ $donation->id }}</span></h3>
                <span class="px-4 py-2 text-xl text-[#FF4400] font-semibold rounded-full 
                    @if($donation->status == 'menunggu_penjemputan') bg-yellow-100 text-yellow-800
                    @elseif($donation->status == 'dalam_perjalanan') bg-blue-100 text-blue-800
                    @elseif($donation->status == 'selesai_disalurkan') bg-green-100 text-green-800
                    @elseif($donation->status == 'dibatalkan') bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $donation->status)) }}
                </span>
            </div>
            <p class="mt-1 text-sm text-gray-500">Dibuat: {{ \Carbon\Carbon::parse($donation->created_at)->translatedFormat('d F Y, H:i') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
            
            {{-- Informasi Kampanye dan Donatur --}}
            <div class="lg:col-span-2">
                <div class="mb-6 p-5 border rounded-lg bg-white">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Kampanye</h4>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium text-gray-800">Nama Kampanye:</span> {{ $donation->campaign->name }}
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        <span class="font-medium text-gray-800">Tanggal Kampanye:</span> {{ \Carbon\Carbon::parse($donation->campaign->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($donation->campaign->end_date)->translatedFormat('d M Y') }}
                    </p>
                </div>
                
                <div class="mb-6 p-5 border rounded-lg bg-white">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Donatur</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <p><span class="font-medium text-gray-800">Nama:</span> {{ $donation->donor_name }}</p>
                            <p class="mt-2"><span class="font-medium text-gray-800">Email:</span> {{ $donation->donor_email }}</p>
                        </div>
                        <div>
                            <p><span class="font-medium text-gray-800">Telepon:</span> {{ $donation->donor_phone }}</p>
                            <p class="mt-2"><span class="font-medium text-gray-800">ID User:</span> {{ $donation->user_id ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Detail Penjemputan --}}
                <div class="p-5 border rounded-lg bg-white">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Detail Penjemputan</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <p><span class="font-medium text-gray-800">Tanggal Jemput:</span> {{ \Carbon\Carbon::parse($donation->pickup_date)->translatedFormat('d F Y') }}</p>
                            <p class="mt-2"><span class="font-medium text-gray-800">Slot Waktu:</span> {{ $donation->pickup_time_slot }}</p>
                            <p class="mt-2"><span class="font-medium text-gray-800">Kode Pos:</span> {{ $donation->pickup_postal_code }}</p>
                        </div>
                        <div>
                            <p><span class="font-medium text-gray-800">Kota/Kabupaten:</span> {{ $donation->pickup_city }}</p>
                            <p class="mt-2"><span class="font-medium text-gray-800">Kecamatan:</span> {{ $donation->pickup_district }}</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-600">
                        <span class="font-medium text-gray-800">Alamat Lengkap:</span> {{ $donation->pickup_address }}
                    </p>
                    @if($donation->pickup_notes)
                        <p class="mt-4 text-sm text-gray-600 border-t pt-2">
                            <span class="font-medium text-gray-800">Catatan Penjemputan:</span> {{ $donation->pickup_notes }}
                        </p>
                    @endif
                </div>

            </div>

            {{-- Kolom Kanan: Item Donasi dan Tracking --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Item Donasi --}}
                <div class="p-5 border rounded-lg bg-white">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Item Donasi (Total: {{ $donation->items->sum('quantity') }} Pcs)</h4>
                    <ul class="space-y-3">
                        @foreach($donation->items as $item)
                        <li class="border-b last:border-b-0 pb-2">
                            <p class="text-sm font-medium text-gray-800">{{ $item->item_category }} ({{ $item->gender }})</p>
                            <p class="text-xs text-gray-600">
                                <span class="font-semibold">{{ $item->quantity }} Pcs</span> | Kondisi: {{ $item->condition }}
                                @if($item->photo_url)
                                    <a href="{{ $item->photo_url }}" target="_blank" class="text-blue-500 hover:text-blue-600 ml-2">Lihat Foto</a>
                                @endif
                            </p>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Status Tracking --}}
                <div class="p-5 border rounded-lg bg-white">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Riwayat Status</h4>
                    <ol class="relative border-l border-gray-200 ml-3">
                        @foreach($donation->tracking->sortByDesc('status_changed_at') as $track)
                        <li class="mb-4 ml-4">
                            <div class="absolute w-3 h-3 bg-[#FF4400] rounded-full mt-1.5 -left-1.5 border border-white"></div>
                            <time class="mb-1 text-xs font-normal leading-none text-gray-400">
                                {{ \Carbon\Carbon::parse($track->status_changed_at)->translatedFormat('d M Y, H:i') }}
                            </time>
                            <h5 class="text-sm font-semibold text-[#1D1D1D] mt-1">
                                {{ ucfirst(str_replace('_', ' ', $track->status)) }}
                            </h5>
                            @if($track->notes)
                                <p class="text-xs font-normal text-gray-500">{{ $track->notes }}</p>
                            @endif
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection