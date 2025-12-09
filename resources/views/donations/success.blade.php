@extends('layouts.app')

@section('title', 'Donasi Berhasil - TitipanHati')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-lg shadow-md p-8 text-center mb-6">
            <div class="mb-4">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-5xl"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Donasi Berhasil Dibuat!</h1>
            <p class="text-gray-600 mb-4">
                Terima kasih atas kebaikan Anda. Donasi Anda akan sangat membantu mereka yang membutuhkan.
            </p>
            <div class="inline-block px-4 py-2 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-600">Nomor Donasi</p>
                <p class="text-xl font-bold text-[#FF4400]">#{{ str_pad($donation->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>


        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-clipboard-list text-[#FF4400] mr-2"></i>
                Detail Donasi
            </h2>

            <div class="space-y-4">

                <div class="border-b pb-4">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/' . $donation->campaign->banner_url) }}" alt="{{ $donation->campaign->banner_url }}"
                             class="w-50 h-16 object-cover rounded-lg mr-3">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $donation->campaign->title }}</p>
                            <p class="text-sm text-gray-600">{{ $donation->campaign->organization->name }}</p>
                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b pb-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Nama Donatur</p>
                        <p class="font-semibold text-gray-900">{{ $donation->donor_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">No. Telepon</p>
                        <p class="font-semibold text-gray-900">{{ $donation->donor_phone }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-semibold text-gray-900">{{ $donation->donor_email }}</p>
                    </div>
                </div>


                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-1">Alamat Penjemputan</p>
                    <p class="font-semibold text-gray-900">{{ $donation->pickup_address }}</p>
                    <p class="text-gray-700">
                        {{ $donation->pickup_city }}, {{ $donation->pickup_province }} - {{ $donation->pickup_postal_code }}
                    </p>
                    @if($donation->pickup_notes)
                        <p class="text-sm text-gray-600 mt-2">
                            <i class="fas fa-sticky-note mr-1"></i> {{ $donation->pickup_notes }}
                        </p>
                    @endif
                </div>


                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <p class="text-sm text-gray-600 mb-1">Jadwal Penjemputan</p>
                    <p class="font-bold text-blue-900">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ \Carbon\Carbon::parse($donation->pickup_date)->format('d F Y') }}
                    </p>
                    <p class="text-blue-900">
                        <i class="fas fa-clock mr-2"></i>
                        Pukul {{ $donation->pickup_time_slot }}
                    </p>
                </div>
            </div>
        </div>


        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-box text-[#FF4400] mr-2"></i>
                Barang Donasi
            </h2>

            <div class="space-y-3">
                @foreach($donation->items as $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                    {{ $item->gender }}
                                </span>
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded">
                                    {{ $item->item_category }}
                                </span>
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded">
                                    {{ $item->condition }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-[#FF4400]">{{ $item->quantity }}</p>
                            <p class="text-xs text-gray-600">item</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between items-center">
                    <p class="font-semibold text-gray-900">Total Item</p>
                    <p class="text-2xl font-bold text-[#FF4400]">{{ $donation->totalQuantity() }} item</p>
                </div>
            </div>
        </div>


        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-[#FF4400] mr-2"></i>
                Status Donasi
            </h2>

            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="font-bold text-gray-900">{{ ucwords(str_replace('_', ' ', $donation->status)) }}</p>
                    <p class="text-sm text-gray-600">
                        Donasi Anda sedang dalam proses verifikasi. Kami akan menghubungi Anda untuk konfirmasi penjemputan.
                    </p>
                </div>
            </div>
        </div>


        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                Langkah Selanjutnya
            </h3>
            <ol class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-[#FF4400] text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">1</span>
                    <span>Email konfirmasi telah dikirim ke <strong>{{ $donation->donor_email }}</strong></span>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-[#FF4400] text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">2</span>
                    <span>Tim kami akan menghubungi Anda untuk konfirmasi detail penjemputan</span>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-[#FF4400] text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">3</span>
                    <span>Pastikan barang sudah disiapkan pada tanggal dan waktu yang telah ditentukan</span>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-[#FF4400] text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">4</span>
                    <span>Anda dapat melacak status donasi melalui halaman riwayat donasi</span>
                </li>
            </ol>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('donations.history') }}" 
               class="py-3 px-4 bg-[#FF4400] text-white text-center font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-history mr-2"></i>
                Lihat Riwayat Donasi
            </a>
            <a href="{{ route('campaigns.index') }}" 
               class="py-3 px-4 bg-gray-200 text-gray-700 text-center font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                <i class="fas fa-search mr-2"></i>
                Cari Campaign Lain
            </a>
            <a href="{{ route('home') }}" 
               class="py-3 px-4 bg-gray-200 text-gray-700 text-center font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>


        <div class="mt-6 text-center">
            <p class="text-gray-600 mb-3">Ajak teman Anda untuk berdonasi juga!</p>
            <div class="flex justify-center gap-3">
                <a href="#" class="w-10 h-10 bg-[#FF4400] text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection