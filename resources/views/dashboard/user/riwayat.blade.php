@extends('layouts.dash-user')

@section('content')

{{-- Menggunakan kontainer penuh lebar, namun bisa dibatasi di layout utama jika diperlukan --}}
<div class="w-full"> 

    <div class="w-full p-4 md:p-10">

        {{-- Navigasi Mobile (Diambil dari halaman Profil agar konsisten) --}}
        <div class="md:hidden mb-6 border-b pb-4">
            <h3 class="text-xl font-bold mb-3">Menu Akun</h3>
            <div class="flex space-x-4 overflow-x-auto pb-2">
                <a href="{{ route('dashboard') }}" class="flex-shrink-0 px-4 py-2 text-gray-500 hover:text-black border rounded-full text-sm">
                    <i class="fa-solid fa-house mr-1"></i> Dashboard
                </a>
                
                {{-- PERBAIKAN: Mengganti route('profile') yang error dengan route('profile.index') --}}
                <a href="{{ route('profile.index') }}" class="flex-shrink-0 px-4 py-2 text-gray-500 hover:text-black border rounded-full text-sm">
                    <i class="fa-solid fa-user mr-1"></i> Profil
                </a>

                <a href="#" class="flex-shrink-0 px-4 py-2 text-orange-600 font-semibold border border-orange-600 rounded-full text-sm bg-orange-50">
                    <i class="fa-solid fa-clock-rotate-left mr-1"></i> Riwayat
                </a>
            </div>
        </div>

        <h1 class="text-3xl font-semibold text-[#1D1D1D] mb-8">Riwayat Donasi</h1>

        @if(isset($donations) && $donations->isNotEmpty())
            
            {{-- Bagian 1: Card View (Hanya Muncul di Mobile/Small Screen) --}}
            <div class="grid grid-cols-1 gap-4 mb-6 md:hidden">
                @foreach($donations as $donation)
                <div class="bg-white p-4 rounded-xl shadow-lg border-l-4 border-orange-500 space-y-2">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-medium text-gray-500">
                            {{ $donation->created_at->format('d M Y') }}
                        </div>
                        {{-- Tampilkan Status --}}
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
                    </div>

                    <p class="text-base font-semibold text-gray-900">
                        #{{ $donation->id }} - {{ $donation->campaign->title ?? 'N/A' }}
                    </p>
                    
                    <p class="text-sm text-gray-600">
                        Barang: **{{ $donation->items->sum('quantity') }} unit**
                    </p>

                    <a href="{{ route('donations.show', $donation->id) }}" class="text-orange-600 hover:text-orange-900 text-sm font-medium block pt-2 border-t mt-2">
                        Lihat Detail &rarr;
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Bagian 2: Table View (Hanya Muncul di Medium/Desktop) --}}
            <div class="bg-white p-6 rounded-xl shadow-lg overflow-x-auto hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID Donasi
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kampanye
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Barang (Total)
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($donations as $donation)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">
                                #{{ $donation->id }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $donation->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $donation->campaign->title ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $donation->items->sum('quantity') }} unit
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
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
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('donations.show', $donation->id) }}" class="text-orange-600 hover:text-orange-900">Lihat Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Tambahkan Pagination di sini jika ada: {{ $donations->links() }} --}}
            </div>
            
        @else
            {{-- Kondisi jika data kosong --}}
            <div class="bg-white p-6 rounded-xl shadow-lg text-center py-10 text-gray-500">
                <i class="fa-solid fa-box-open text-4xl mb-3"></i>
                <p class="text-lg font-medium">Belum ada riwayat donasi.</p>
                <p class="text-sm mt-1">Saatnya berdonasi dan melihat jejak kebaikan Anda di sini!</p>
            </div>
        @endif
    </div>
</div>
@endsection