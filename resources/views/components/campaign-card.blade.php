<div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
    {{-- Banner --}}
    <div class="relative h-48 bg-gray-200">
        @if($campaign->banner_url)
            <img src="{{ asset('storage/' . $campaign->banner_url) }}" alt="{{ $campaign->title }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <i class="fas fa-image text-6xl"></i>
            </div>
        @endif
        
        {{-- Badge Trending jika view_count > 1000 --}}
        @if($campaign->view_count > 1000)
            <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                <i class="fas fa-fire"></i> Trending
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-6">
        <h3 class="font-bold text-xl mb-2 line-clamp-2">{{ $campaign->title }}</h3>
        
        <p class="text-sm text-gray-600 mb-2">
            <i class="fas fa-building mr-1"></i> {{ $campaign->organization->name }}
        </p>
        
        <p class="text-sm text-gray-600 mb-4">
            <i class="fas fa-map-marker-alt mr-1"></i> {{ $campaign->city }}, {{ $campaign->province }}
        </p>

        {{-- Progress Bar --}}
        <div class="mb-4">
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600">Terkumpul</span>
                <span class="font-semibold">{{ $campaign->collected_quantity }} / {{ $campaign->target_quantity }} pcs</span>
            </div>
            @php
                $progress = $campaign->target_quantity > 0 ? ($campaign->collected_quantity / $campaign->target_quantity) * 100 : 0;
            @endphp
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($progress, 100) }}%"></div>
            </div>
        </div>

        <a href="{{ route('campaigns.show', $campaign->id) }}" 
           class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Detail Campaign
        </a>
    </div>
</div>