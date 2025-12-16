    @extends('layouts.dash-user')

    @section('title', 'Detail Donasi')

    @section('content')
    <div class="min-h-screen py-6 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            

            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-[#FF4400] font-medium mb-3 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Riwayat</span>
                        </a>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 flex items-center gap-3">
                            <div class="w-14 h-14 bg-[#FF4400] to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-file-invoice text-white text-2xl"></i>
                            </div>
                            Detail Donasi
                        </h1>
                    </div>


                    @php
                        $status = trim(strtolower($donation->status));

                        $statusConfig = [
                            'menunggu_penjemputan' => ['class' => 'bg-blue-500', 'icon' => 'fa-clock', 'text' => 'Menunggu Penjemputan'],
                            'dalam_perjalanan' => ['class' => 'bg-purple-500', 'icon' => 'fa-truck', 'text' => 'Dalam Perjalanan'],
                            'selesai' => ['class' => 'bg-green-500', 'icon' => 'fa-check-circle', 'text' => 'Selesai'],
                            'dibatalkan' => ['class' => 'bg-red-500', 'icon' => 'fa-times-circle', 'text' => 'Dibatalkan'],
                        ];

                        $config = $statusConfig[$status]
                            ?? ['class' => 'bg-gray-500', 'icon' => 'fa-info-circle', 'text' => ucfirst(str_replace('_', ' ', $status))];
                    @endphp
                    <div class="flex flex-col items-end gap-2">
                        <span class="px-6 py-3 {{ $config['class'] }} text-white text-lg font-bold rounded-xl shadow-lg flex items-center gap-3">
                            <i class="fas {{ $config['icon'] }}"></i>
                            {{ $config['text'] }}
                        </span>
                        <p class="text-sm text-gray-500 font-medium">ID: <span class="text-[#FF4400] font-bold">#{{ $donation->id }}</span></p>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#FF4400] rounded-xl flex items-center justify-center">
                                    <i class="fas fa-bullhorn text-white"></i>
                                </div>
                                Informasi Kampanye
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-tag text-[#FF4400] text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-medium">Nama Kampanye</p>
                                    <p class="text-base font-bold text-gray-900 mt-1">{{ $donation->campaign->title }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-calendar-check text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Mulai</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($donation->campaign->start_date)->translatedFormat('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-gray-300">—</div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-calendar-times text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Selesai</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($donation->campaign->end_date)->translatedFormat('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#FF4400] rounded-xl flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                Informasi Donatur
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user-circle text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Nama Lengkap</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $donation->donor_name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-phone text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Nomor Telepon</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $donation->donor_phone }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-envelope text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Email</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1 break-all">{{ $donation->donor_email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#FF4400] rounded-xl flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                Detail Penjemputan
                            </h3>
                        </div>
                        <div class="p-6 space-y-5">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-calendar-day text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Tanggal Penjemputan</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($donation->pickup_date)->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-clock text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Slot Waktu</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $donation->pickup_time_slot }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-100">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-map text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Provinsi</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $donation->pickup_province }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-city text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Kota/Kabupaten</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $donation->pickup_city }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-mail-bulk text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Kode Pos</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $donation->pickup_postal_code }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="bg-orange-50 rounded-xl p-4 border-l-4 border-[#FF4400]">
                                <p class="text-xs text-gray-500 font-medium mb-2 flex items-center gap-2">
                                    <i class="fas fa-home text-[#FF4400]"></i>
                                    Alamat Lengkap
                                </p>
                                <p class="text-sm font-semibold text-gray-900">{{ $donation->pickup_address }}</p>
                            </div>


                            @if($donation->pickup_notes)
                            <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-gray-300">
                                <p class="text-xs text-gray-500 font-medium mb-2 flex items-center gap-2">
                                    <i class="fas fa-sticky-note text-gray-600"></i>
                                    Catatan Penjemputan
                                </p>
                                <p class="text-sm text-gray-700">{{ $donation->pickup_notes }}</p>
                            </div>
                            @endif


                            <div class="pt-4 border-t border-gray-100">
                                <p class="text-xs text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-clock"></i>
                                    Dibuat pada: <span class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($donation->created_at)->translatedFormat('d F Y, H:i') }} WIB</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="lg:col-span-1 space-y-6">
                    

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden top-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <div class="w-10 h-10 bg-[#FF4400] rounded-xl flex items-center justify-center">
                                    <i class="fas fa-box text-white"></i>
                                </div>
                                <div>
                                    Item Donasi
                                    <p class="text-xs font-normal text-gray-500 mt-0.5">Total: {{ $donation->items->sum('quantity') }} Unit</p>
                                </div>
                            </h3>
                        </div>
                        <div class="p-6 max-h-96 overflow-y-auto">
                            <div class="space-y-3">
                                @foreach($donation->items as $index => $item)
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:border-[#FF4400] transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-[#FF4400] text-white rounded-xl flex items-center justify-center flex-shrink-0 font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-gray-900">{{ $item->item_category }}</p>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg border border-gray-200">
                                                    <i class="fas fa-{{ $item->gender == 'Laki-laki' ? 'mars' : ($item->gender == 'Perempuan' ? 'venus' : 'venus-mars') }}"></i>
                                                    {{ $item->gender }}
                                                </span>
                                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg border border-gray-200">
                                                    <i class="fas fa-box"></i>
                                                    {{ $item->quantity }} Pcs
                                                </span>
                                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg border border-gray-200">
                                                    <i class="fas fa-star"></i>
                                                    {{ $item->condition }}
                                                </span>
                                            </div>
                                            @if($item->photo_url)
                                            <a href="{{ $item->photo_url }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-xs text-[#FF4400] hover:text-orange-600 font-semibold">
                                                <i class="fas fa-camera"></i>
                                                Lihat Foto
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <div class="w-10 h-10 bg-[#FF4400] rounded-xl flex items-center justify-center">
                                    <i class="fas fa-route text-white"></i>
                                </div>
                                Riwayat Status
                            </h3>
                        </div>
                        <div class="p-6">
                            <ol class="relative border-l-2 border-gray-200 ml-4">
                                @php
                                    $latestTracking = $donation->tracking
                                        ->sortByDesc('status_changed_at')
                                        ->first();
                                @endphp
                                @foreach($donation->tracking->sortByDesc('status_changed_at') as $track)
                                    @php
                                        $isLatest = $latestTracking && $track->id === $latestTracking->id;
                                    @endphp

                                    <li class="mb-6 ml-6">
                                        <div class="absolute w-4 h-4 {{ $isLatest ? 'bg-[#FF4400]' : 'bg-gray-300' }} rounded-full -left-2.5 border-4 border-white"></div>

                                        <div class="bg-gray-50 rounded-xl p-4
                                            {{ $isLatest ? 'border-2 border-[#FF4400]' : 'border border-gray-200' }}">
                                            
                                            <time class="mb-2 text-xs font-semibold text-gray-500 flex items-center gap-1">
                                                <i class="fas fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($track->status_changed_at)->translatedFormat('d M Y, H:i') }}
                                            </time>

                                            <h5 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                                <i class="fas {{ $icons[$track->status] ?? 'fa-info-circle' }}
                                                    {{ $isLatest ? 'text-[#FF4400]' : 'text-gray-600' }}"></i>
                                                {{ ucfirst(str_replace('_', ' ', $track->status)) }}
                                            </h5>

                                            @if($track->notes)
                                                <p class="text-xs text-gray-600 mt-2 pl-6">{{ $track->notes }}</p>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection