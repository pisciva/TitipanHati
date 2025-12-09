@extends('layouts.dash-admin')

@section('title', 'Manajemen Donasi')

@section('content')


    @php

        $month = $month ?? now()->month;
        $year = $year ?? now()->year;


        $currentDate = \Carbon\Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $currentDate->daysInMonth;

        $firstDayOfWeek = $currentDate->dayOfWeekIso; 
        

        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();


        $weekDays = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $currentDay = 1;


        $baseUrl = route('admin.donations.calendar');


        $allMonthlyDonations = collect($donations)->flatten()->sortByDesc('pickup_date');


        $statusColors = [
            'menunggu_penjemputan' => 'bg-[#F59E0B]', 
            'dalam_perjalanan' => 'bg-[#00B2F3]', 
            'selesai' => 'bg-[#10B981]',
            'dibatalkan' => 'bg-[#E50000]', 
        ];
    @endphp


    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1D1D1D]">Tanggal Penjemputan</h1>
        <p class="text-sm text-gray-500">Hari ini {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>



    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-8">
        

        <div class="flex justify-between items-center mb-6">

            <a href="{{ $baseUrl }}?year={{ $prevMonth->year }}&month={{ $prevMonth->month }}" 
               class="p-2 text-[#FF4400] hover:bg-gray-100 rounded-full transition">
                <i class="fas fa-chevron-left"></i>
            </a>


            <h2 class="text-lg font-semibold text-[#FF4400]">
                {{ $currentDate->translatedFormat('F Y') }}
            </h2>


            <a href="{{ $baseUrl }}?year={{ $nextMonth->year }}&month={{ $nextMonth->month }}" 
               class="p-2 text-[#FF4400] hover:bg-gray-100 rounded-full transition">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>


        <div class="grid grid-cols-7 gap-1 text-center">
            

            @foreach ($weekDays as $dayName)
                <div class="text-xs font-semibold text-gray-500 py-1">{{ $dayName }}</div>
            @endforeach




            @for ($i = 1; $i < $firstDayOfWeek; $i++)
                <div class="p-1 text-xs text-gray-400 bg-gray-50 h-16 sm:h-20 rounded-lg"></div>
            @endfor


            @while ($currentDay <= $daysInMonth)
                @php
                    $fullDate = \Carbon\Carbon::createFromDate($year, $month, $currentDay);
                    $dateKey = $fullDate->format('Y-m-d');
                    $dayOfWeek = $fullDate->dayOfWeek; // 0 (Sunday) - 6 (Saturday)
                    $isWeekend = $dayOfWeek === 0 || $dayOfWeek === 6;
                    $hasDonations = isset($donations[$dateKey]) && $donations[$dateKey]->count() > 0;
                    
                    $todayClass = $fullDate->isToday() ? 'bg-red-100 font-bold border-2 border-red-500' : 'hover:bg-gray-50';
                    $weekendClass = $isWeekend ? 'text-red-600' : 'text-gray-900';
                    $activeDateClass = $hasDonations ? 'cursor-pointer' : '';


                    $firstDonation = $hasDonations ? $donations[$dateKey]->first() : null;
                    $statusColor = $firstDonation ? $statusColors[strtolower(str_replace(' ', '_', $firstDonation->status))] : '';
                @endphp

                <div class="p-1 h-16 sm:h-20 text-xs rounded-lg flex flex-col items-center transition duration-150 {{ $todayClass }} {{ $activeDateClass }} relative"
                     @if ($hasDonations) onclick="showDonationDetails('{{ $dateKey }}')" @endif>
                    

                    <span class="w-6 h-6 flex items-center justify-center rounded-full mb-1 
                                 {{ $fullDate->isToday() ? 'bg-red-500 text-white' : $weekendClass }}">
                        {{ $currentDay }}
                    </span>


                    @if ($hasDonations)
                        <div class="text-xs font-medium text-white px-1 py-0.5 rounded-full mt-1 max-w-full truncate" 
                             style="font-size: 0.6rem; line-height: 0.75rem;">
                             <span class="{{ $statusColor }} text-white px-2 py-0.5 rounded-full inline-block truncate">
                                {{ $donations[$dateKey]->count() }} Aktivitas
                            </span>
                        </div>
                    @endif
                </div>

                @php
                    $currentDay++;
                @endphp
            @endwhile


            @php
                $endPadding = 7 - (($firstDayOfWeek + $daysInMonth - 1) % 7);
                if ($endPadding == 7) $endPadding = 0;
            @endphp
            @for ($i = 0; $i < $endPadding; $i++)
                <div class="p-1 text-xs text-gray-400 bg-gray-50 h-16 sm:h-20 rounded-lg"></div>
            @endfor
        </div>

    </div>

    

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex justify-between items-center mb-4 border-b pb-4">
            <h3 class="text-xl font-bold text-gray-800">Daftar Seluruh Donasi Bulan Ini</h3>
            <a href="{{ route('admin.donations.index') }}" class="text-[#FF4400] font-semibold hover:text-[#EB3F00] transition">
                Lihat Semua Donasi <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if ($allMonthlyDonations->isEmpty())
            <div class="text-center py-10 text-gray-500">
                <i class="fas fa-box-open text-4xl mb-3"></i>
                <p>Tidak ada jadwal penjemputan donasi pada bulan ini.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($allMonthlyDonations as $donation)
                    @php
                        $statusText = ucwords(str_replace('_', ' ', $donation->status));
                        $statusClass = [
                            'Menunggu Penjemputan' => 'bg-yellow-100 text-yellow-800 border-yellow-500',
                            'Dalam Perjalanan' => 'bg-blue-100 text-blue-800 border-blue-500',
                            'Selesai' => 'bg-green-100 text-green-800 border-green-500',
                            'Dibatalkan' => 'bg-red-100 text-red-800 border-red-500',
                        ][$statusText] ?? 'bg-gray-100 text-gray-800 border-gray-500';
                    @endphp

                    <div class="p-4 border-l-4 {{ $statusClass }} rounded-xl flex justify-between items-center shadow-sm hover:shadow-md transition duration-150">
                        <div class="flex items-center space-x-4">

                            <div class="flex flex-col items-start">
                                <span class="text-sm font-semibold {{ str_contains($statusText, 'Selesai') ? 'text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-circle text-xs mr-2 {{ str_contains($statusText, 'Menunggu') ? 'text-yellow-500' : (str_contains($statusText, 'Dalam') ? 'text-blue-500' : (str_contains($statusText, 'Selesai') ? 'text-green-500' : 'text-red-500')) }}"></i>
                                    {{ $statusText }}
                                </span>
                                

                                <p class="text-gray-900 font-medium mt-1">
                                    {{ $donation->campaign->title ?? 'Campaign Tidak Diketahui' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Donasi {{ $donation->items->count() }} Jenis Barang
                                    <span class="text-s text-gray-500 ml-2">| Penjemputan: {{ \Carbon\Carbon::parse($donation->pickup_date)->translatedFormat('F d, Y') }}</span>
                                </p>
                            </div>
                        </div>


                        <a href="{{ route('admin.donations.show', $donation->id) }}" class="flex items-center text-[#FF4400] font-semibold text-sm hover:text-[#EB3F00]">
                            Detail Donasi <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>



    <div id="donation-details-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <h3 id="modal-title" class="text-xl font-bold mb-4 text-[#1D1D1D] border-b pb-2">Aktivitas Penjemputan Tanggal: </h3>
            <div id="modal-content" class="space-y-4 max-h-96 overflow-y-auto pr-2">
                <p class="text-gray-500">Memuat data...</p>
            </div>
            <button onclick="document.getElementById('donation-details-modal').classList.add('hidden')"
                    class="mt-6 w-full py-2 bg-[#FF4400] text-white font-medium rounded-xl hover:bg-[#EB3F00] transition shadow-lg">
                Tutup
            </button>
        </div>
    </div>

    @push('scripts')
    <script>

        async function showDonationDetails(date) {
            const modal = document.getElementById('donation-details-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalContent = document.getElementById('modal-content');
            
            modalTitle.textContent = `Aktivitas Penjemputan Tanggal ${date}`;
            modalContent.innerHTML = `<p class="text-gray-500 flex items-center justify-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...</p>`;
            modal.classList.remove('hidden');

            try {

                const response = await fetch(`{{ route('admin.donations.byDate') }}?date=${date}`);
                
                if (!response.ok) {
                    throw new Error(`Gagal mengambil data. Status: ${response.status}`);
                }

                const donations = await response.json();

                let html = '';
                if (donations.length === 0) {
                    html = '<p class="text-gray-500 text-center py-4">Tidak ada penjemputan terjadwal pada tanggal ini.</p>';
                } else {
                    donations.forEach(donation => {
                        const statusColors = {
                            'menunggu_penjemputan': 'bg-yellow-100 text-yellow-800',
                            'dalam_perjalanan': 'bg-blue-100 text-blue-800',
                            'selesai': 'bg-green-100 text-green-800',
                            'dibatalkan': 'bg-red-100 text-red-800',
                        };
                        const statusKey = donation.status.toLowerCase().replace(/ /g, '_');
                        const statusClass = statusColors[statusKey] || 'bg-gray-100 text-gray-800';

                        const displayStatus = donation.status.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');

                        html += `
                            <div class="p-4 border border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100 transition duration-150">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm font-semibold text-red-600">Donasi #${donation.id}</p>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full ${statusClass}">
                                        ${displayStatus}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-700 mt-1">Donatur: ${donation.user ? donation.user.name : 'Anonim'}</p>
                                <p class="text-sm text-gray-700">Campaign: ${donation.campaign ? donation.campaign.title : 'N/A'}</p>
                                <a href="{{ url('admin/donations') }}/${donation.id}" class="text-xs text-red-500 hover:text-red-700 mt-2 inline-block font-medium">Lihat Detail</a>
                            </div>
                        `;
                    });
                }
                modalContent.innerHTML = html;

            } catch (error) {
                console.error("Error fetching donation details:", error);
                modalContent.innerHTML = '<div class="text-center py-4"><p class="text-red-600 font-bold">Gagal memuat detail donasi.</p><p class="text-red-500 text-sm mt-1">Silakan periksa koneksi atau pastikan rute API berfungsi.</p></div>';
            }
        }
    </script>
    @endpush

@endsection