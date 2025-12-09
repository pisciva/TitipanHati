@extends('layouts.dash-user')

@section('content')
<div class="w-full min-h-screen">
    <div class="w-full p-4 md:p-10">
        

        <div class="md:hidden mb-6">
            <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-bars text-[#FF4400]"></i>
                    Menu Akun
                </h3>
                <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                    <a href="{{ route('dashboard') }}" class="flex-shrink-0 px-4 py-2.5 text-gray-600 hover:text-[#FF4400] hover:bg-orange-50 border border-gray-200 rounded-xl text-sm font-medium transition-all">
                        <i class="fas fa-house mr-1.5"></i> Dashboard
                    </a>
                    <a href="{{ route('profile.index') }}" class="flex-shrink-0 px-4 py-2.5 text-gray-600 hover:text-[#FF4400] hover:bg-orange-50 border border-gray-200 rounded-xl text-sm font-medium transition-all">
                        <i class="fas fa-user mr-1.5"></i> Profil
                    </a>
                    <a href="#" class="flex-shrink-0 px-4 py-2.5 text-white bg-[#FF4400] border border-[#FF4400] rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30">
                        <i class="fas fa-clock-rotate-left mr-1.5"></i> Riwayat
                    </a>
                </div>
            </div>
        </div>


        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-12 h-12 bg-[#FF4400] to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                            <i class="fas fa-history text-white text-xl"></i>
                        </div>
                        Riwayat Donasi
                    </h1>
                    <p class="text-gray-500 mt-2 ml-15">Pantau semua aktivitas donasi Anda</p>
                </div>
                

                <div class="flex gap-3">
                    <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">Total Donasi</p>
                        <p class="text-2xl font-bold text-[#FF4400]">{{ $donations->total() ?? $donations->count() }}</p>
                    </div>
                    <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">Total Barang</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $donations->reduce(fn($carry, $d) => $carry + $d->items->sum('quantity'), 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($donations) && $donations->isNotEmpty())
            

            <div class="grid grid-cols-1 gap-4 mb-6 md:hidden">
                @foreach($donations as $donation)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">

                    <div class="bg-orange-50 to-red-50 px-4 py-3 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fas fa-gift text-[#FF4400] text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">ID Donasi</p>
                                    <p class="text-sm font-bold text-gray-900">#{{ $donation->id }}</p>
                                </div>
                            </div>
                            @php
                                $statusConfig = [
                                    'selesai' => ['class' => 'bg-green-100 text-green-700 border-green-200', 'icon' => 'fa-check-circle'],
                                    'menunggu_penjemputan' => ['class' => 'bg-blue-100 text-blue-700 border-blue-200', 'icon' => 'fa-clock'],
                                    'dalam_perjalanan' => ['class' => 'bg-purple-100 text-purple-700 border-purple-200', 'icon' => 'fa-truck'],
                                    'dibatalkan' => ['class' => 'bg-red-100 text-red-700 border-red-200', 'icon' => 'fa-times-circle'],
                                ];
                                $config = $statusConfig[$donation->status] ?? ['class' => 'bg-gray-100 text-gray-700 border-gray-200', 'icon' => 'fa-info-circle'];
                            @endphp
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-lg border {{ $config['class'] }} flex items-center gap-1.5">
                                <i class="fas {{ $config['icon'] }}"></i>
                                {{ str_replace('_', ' ', ucfirst($donation->status)) }}
                            </span>
                        </div>
                    </div>


                    <div class="p-4 space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar text-[#FF4400]"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 font-medium">Kampanye</p>
                                <p class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $donation->campaign->title ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-100">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Total Barang</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $donation->items->sum('quantity') }} unit</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-day text-purple-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Tanggal</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $donation->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('donations.show', $donation->id) }}" class="block w-full mt-4 px-4 py-3 bg-[#FF4400] to-orange-600 text-white text-center rounded-xl font-semibold hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300">
                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>


            @if($donations->hasPages())
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 mb-6 md:hidden">
                <div class="text-center text-sm text-gray-700 mb-3">
                    Halaman {{ $donations->currentPage() }} dari {{ $donations->lastPage() }}
                </div>
                {{ $donations->links() }}
            </div>
            @endif


            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50 to-orange-50/50">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-hashtag mr-2 text-[#FF4400]"></i>ID Donasi
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-2 text-[#FF4400]"></i>Tanggal
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-bullhorn mr-2 text-[#FF4400]"></i>Kampanye
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-box mr-2 text-[#FF4400]"></i>Total Barang
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-2 text-[#FF4400]"></i>Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-cog mr-2 text-[#FF4400]"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($donations as $donation)
                            <tr class="hover:bg-orange-50/30 transition-colors duration-200">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-[#FF4400] to-orange-600 rounded-xl flex items-center justify-center shadow-sm">
                                            <i class="fas fa-gift text-white text-sm"></i>
                                        </div>
                                        <span class="text-sm font-bold text-gray-900">#{{ $donation->id }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                        <span class="text-sm text-gray-700 font-medium">{{ $donation->created_at->format('d M Y') }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $donation->created_at->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $donation->campaign->title ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $donation->campaign->organization->name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-box text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $donation->items->sum('quantity') }} unit</p>
                                            <p class="text-xs text-gray-500">{{ $donation->items->count() }} kategori</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'selesai' => ['class' => 'bg-green-100 text-green-700 border-green-200', 'icon' => 'fa-check-circle'],
                                            'menunggu_penjemputan' => ['class' => 'bg-blue-100 text-blue-700 border-blue-200', 'icon' => 'fa-clock'],
                                            'dalam_perjalanan' => ['class' => 'bg-purple-100 text-purple-700 border-purple-200', 'icon' => 'fa-truck'],
                                            'dibatalkan' => ['class' => 'bg-red-100 text-red-700 border-red-200', 'icon' => 'fa-times-circle'],
                                        ];
                                        $config = $statusConfig[$donation->status] ?? ['class' => 'bg-gray-100 text-gray-700 border-gray-200', 'icon' => 'fa-info-circle'];
                                    @endphp
                                    <span class="px-3 py-2 inline-flex items-center gap-2 text-xs font-semibold rounded-xl border {{ $config['class'] }}">
                                        <i class="fas {{ $config['icon'] }}"></i>
                                        {{ str_replace('_', ' ', ucfirst($donation->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <a href="{{ route('donations.show', $donation->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#FF4400] to-orange-600 text-white text-sm font-semibold rounded-xl hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300">
                                        <i class="fas fa-eye"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menampilkan <span class="font-semibold">{{ $donations->firstItem() ?? 0 }}</span> 
                            sampai <span class="font-semibold">{{ $donations->lastItem() ?? 0 }}</span> 
                            dari <span class="font-semibold">{{ $donations->total() }}</span> donasi
                        </div>
                        {{ $donations->links() }}
                    </div>
                </div>
            </div>
            
        @else

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="text-center py-16 px-6">
                    <div class="w-24 h-24 bg-orange-100 to-red-100 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-box-open text-5xl text-[#FF4400]"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Riwayat Donasi</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">Mulai perjalanan kebaikan Anda dengan berdonasi. Setiap kontribusi Anda akan tercatat di sini.</p>
                    <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-[#FF4400] to-orange-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300">
                        <i class="fas fa-heart"></i>
                        Mulai Berdonasi
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection