@extends('layouts.dash-admin')

@section('title', 'Manajemen Donasi')

@section('content')

    @php
        $selectedDateKey = request()->query('date') ?? now()->format('Y-m-d');
        $selectedDate = \Carbon\Carbon::parse($selectedDateKey);

        $month = request()->query('month') ?? $selectedDate->month;
        $year = request()->query('year') ?? $selectedDate->year;

        $currentDate = \Carbon\Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $currentDate->daysInMonth;

        $firstDayOfWeek = $currentDate->dayOfWeekIso;

        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        $weekDays = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $currentDay = 1;

        $baseUrl = route('admin.donations.calendar');

        $donationsForSelectedDate = isset($donations[$selectedDateKey]) ? $donations[$selectedDateKey]->sortByDesc('pickup_date') : collect();

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
            <a href="{{ $baseUrl }}?year={{ $prevMonth->year }}&month={{ $prevMonth->month }}&date={{ $selectedDateKey }}"
               class="p-2 text-[#FF4400] hover:bg-gray-100 rounded-full transition">
                <i class="fas fa-chevron-left"></i>
            </a>

            <h2 class="text-lg font-semibold text-[#FF4400]">
                {{ $currentDate->translatedFormat('F Y') }}
            </h2>

            <a href="{{ $baseUrl }}?year={{ $nextMonth->year }}&month={{ $nextMonth->month }}&date={{ $selectedDateKey }}"
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
                    $dayOfWeek = $fullDate->dayOfWeek;
                    $isWeekend = $dayOfWeek === 0 || $dayOfWeek === 6;
                    $hasDonations = isset($donations[$dateKey]) && $donations[$dateKey]->count() > 0;

                    $inlineStyle = '';
                    $dayNumberClass = '';

                    if ($dateKey === $selectedDateKey) {
                        $baseClass = 'border-2 shadow-md';
                        $inlineStyle = 'background-color: rgba(255, 68, 0, 0.9); border-color: #EB3F00;';
                        $dayNumberClass = 'bg-white text-[#FF4400]';
                    } elseif ($fullDate->isToday()) {
                        $baseClass = 'bg-red-100 font-bold border-2 border-red-500';
                        $dayNumberClass = 'bg-red-500 text-white';
                        $inlineStyle = '';
                    } else {
                        $baseClass = 'hover:bg-gray-50 border-transparent';
                        $dayNumberClass = $isWeekend ? 'text-red-600' : 'text-gray-900';
                        $inlineStyle = '';
                    }

                    $activeDateClass = $hasDonations ? 'cursor-pointer' : '';

                    $firstDonation = $hasDonations ? $donations[$dateKey]->first() : null;
                    $statusColor = $firstDonation ? $statusColors[strtolower(str_replace(' ', '_', $firstDonation->status))] : '';
                @endphp

                <a href="{{ $baseUrl }}?year={{ $year }}&month={{ $month }}&date={{ $dateKey }}"
                   class="p-1 h-16 sm:h-20 text-xs rounded-lg flex flex-col items-center transition duration-150 relative
                          {{ $baseClass }}
                          {{ $activeDateClass }}"
                   style="{{ $inlineStyle }}">

                    <span class="w-6 h-6 flex items-center justify-center rounded-full mb-1
                                 {{ $dateKey === $selectedDateKey ? 'bg-white text-[#FF4400]' : $dayNumberClass }}">
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
                </a>

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
            <h3 class="text-xl font-bold text-gray-800">Daftar donasi pada hari ini:</h3>
            <a href="{{ route('admin.donations.index') }}" class="text-[#FF4400] font-semibold hover:text-[#EB3F00] transition">
                Lihat Semua Donasi <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if ($donationsForSelectedDate->isEmpty())
            <div class="text-center py-10 text-gray-500">
                <i class="fas fa-box-open text-4xl mb-3"></i>
                <p>Tidak ada kegiatan donasi pada {{ $selectedDate->translatedFormat('d F Y') }}.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($donationsForSelectedDate as $donation)
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

@endsection