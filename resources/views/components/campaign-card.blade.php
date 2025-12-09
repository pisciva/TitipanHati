{{-- Modern Campaign Card Component --}}
<div
    class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-500 overflow-hidden transform hover:-translate-y-1">
    {{-- Banner dengan Overlay Gradient --}}
    <div class="relative h-56 overflow-hidden">
        @if($campaign->banner_url)
            <img src="{{ asset('storage/' . $campaign->banner_url) }}" alt="{{ $campaign->title }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                <i class="fas fa-image text-7xl text-gray-300"></i>
            </div>
        @endif

        {{-- Gradient Overlay --}}
        <div
            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
        </div>

        {{-- Badges Container --}}
        <div class="absolute top-3 right-3 flex flex-col gap-2">
            {{-- Badge Trending --}}
            @if($campaign->view_count > 1000)
                <div
                    class="bg-red-600 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1 animate-pulse">
                    <i class="fas fa-fire"></i>
                    <span>Trending</span>
                </div>
            @endif

            {{-- Badge Status Campaign --}}
            @php
                $now = now();
                $isActive = null;

                // Cek apakah start_date dan end_date tidak null sebelum membandingkan
                if ($campaign->start_date && $campaign->end_date) {
                    $isActive = $now->between($campaign->start_date, $campaign->end_date);
                }

                $progress = $campaign->target_quantity > 0 ? ($campaign->collected_quantity / $campaign->target_quantity) * 100 : 0;
            @endphp

            @if($progress >= 100)
                <div
                    class="bg-green-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                    <i class="fas fa-check-circle"></i>
                    <span>Target Tercapai</span>
                </div>
            @elseif($isActive === false)
                <div
                    class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                    <i class="fas fa-clock"></i>
                    <span>Berakhir</span>
                </div>
            @endif
        </div>

        {{-- Category Badge --}}
        <div class="absolute top-3 left-3">
            <div
                class="bg-white/90 backdrop-blur-sm text-gray-700 px-3 py-1.5 rounded-full text-xs font-semibold shadow-lg">
                <i class="fas fa-tag mr-1 text-[#FF4400]"></i>
                {{ ucfirst($campaign->category ?? 'Pakaian') }}
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-6">
        {{-- Title --}}
        <h3
            class="font-bold text-xl mb-3 line-clamp-2 text-gray-900 group-hover:text-[#FF4400] transition-colors duration-300">
            {{ $campaign->title }}
        </h3>

        {{-- Organization Info --}}
        <div class="flex items-start gap-3 mb-4">
            <div
                class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-building text-blue-600 text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">
                    {{ $campaign->organization->name }}
                </p>
                <p class="text-xs text-gray-500 flex items-center mt-0.5">
                    <i class="fas fa-map-marker-alt mr-1 text-[#FF4400]"></i>
                    <span class="truncate">{{ $campaign->city }}, {{ $campaign->province }}</span>
                </p>
            </div>
        </div>

        {{-- Meta Info --}}
        <div class="flex items-center gap-4 mb-4 text-xs text-gray-500">
            <div class="flex items-center gap-1">
                <i class="fas fa-calendar-alt text-[#FF4400]"></i>
                <span class="flex gap-1">Berakhir pada:
                    <p class="font-bold">{{ \Carbon\Carbon::parse($campaign->deadline)->translatedFormat('l, d F Y') }}</p></span>
            </div>

            <div class="flex items-center gap-1">
                <i class="fas fa-eye text-[#FF4400]"></i>
                <span>{{ number_format($campaign->view_count) }} dilihat</span>
            </div>
        </div>

        {{-- Progress Section --}}
        <div class="mb-5">
            <div class="flex justify-between items-end mb-2">
                <span class="text-xs font-semibold text-gray-600">Progress Donasi</span>
                <span class="text-sm font-bold text-[#FF4400]">{{ number_format($progress, 1) }}%</span>
            </div>

            {{-- Progress Bar dengan Gradient --}}
            <div class="relative w-full bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner">
                <div class="absolute inset-0 bg-[#FF4400] rounded-full transition-all duration-1000 ease-out shadow-lg"
                    style="width: {{ min($progress, 100) }}%">
                    {{-- Shimmer Effect --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer">
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="flex justify-between mt-2 text-xs">
                <span class="text-gray-600">
                    <span class="font-bold text-gray-900">{{ number_format($campaign->collected_quantity) }}</span>
                    terkumpul
                </span>
                <span class="text-gray-600">
                    Target: <span class="font-bold text-gray-900">{{ number_format($campaign->target_quantity) }}</span>
                    pcs
                </span>
            </div>
        </div>

        {{-- Action Button --}}
        <a href="{{ route('campaigns.show', $campaign->id) }}"
            class="block w-full text-center px-6 py-3 bg-[#FF4400] text-white rounded-xl font-bold hover:from-[#DE3B00] hover:to-[#DE3B00] transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.01] flex items-center justify-center gap-2 group/btn">
            <span>Detail Campaign</span>
            <i
                class="fas fa-arrow-right text-sm group-hover/btn:translate-x-1 transition-transform duration-300 mt-1"></i>
        </a>
    </div>

    {{-- Decorative Corner --}}
    <div
        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#FF4400]/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500">
    </div>
</div>

{{-- Custom Animations - Add to your CSS --}}
<style>
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .animate-shimmer {
        animation: shimmer 2s infinite;
    }
</style>