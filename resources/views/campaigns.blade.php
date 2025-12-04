@extends('layouts.app')

@section('title', 'Campaigns Terbuka')

@section('content')
<div class="container mx-auto px-4 py-8">
  <!-- Header / Breadcrumbs -->
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Campaigns Terbuka</h1>
    <div class="flex items-center gap-3">
      <a href="#" class="bg-orange-500 text-white px-4 py-2 rounded shadow-sm">Tambahkan Campaign +</a>
      <div class="relative">
        <input type="text" placeholder="Cari Campaigns" class="border rounded-full pl-4 pr-10 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-orange-300" />
        <button class="absolute right-1 top-1/2 -translate-y-1/2 px-3">🔍</button>
      </div>
    </div>
  </div>

  <!-- Filters -->
  <div class="flex flex-wrap gap-3 mb-6">
    <button class="px-3 py-2 bg-gray-200 rounded">Semua Campaigns</button>
    <button class="px-3 py-2 bg-gray-200 rounded">Sudah Tercapai</button>
    <button class="px-3 py-2 bg-gray-200 rounded">Belum Tercapai</button>
    <button class="px-3 py-2 bg-gray-200 rounded">Tutup</button>
  </div>

  <!-- Toggle: Tanggal Buka / Progres -->
  <div class="flex items-center justify-end mb-4">
    <div class="bg-gray-100 rounded p-1 flex items-center">
      <button class="px-3 py-1 rounded text-sm">Tanggal Buka</button>
      <button class="px-3 py-1 rounded text-sm bg-white">Progres</button>
    </div>
  </div>

  <!-- Grid of cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($campaigns as $campaign)
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
      <div class="relative">
        <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}" class="w-full h-40 object-cover" />

        {{-- Top-left badge: days left --}}
        <div class="absolute left-3 top-3 bg-white/90 text-xs px-2 py-1 rounded">{{ $campaign->days_left }} HARI LAGI</div>

        {{-- Top-right: participants count --}}
        <div class="absolute right-3 top-3 bg-white/90 text-xs px-2 py-1 rounded">{{ number_format($campaign->participants) }}+</div>

        {{-- Featured / Completed / Target Tercapai badges --}}
        @if($campaign->is_featured)
          <div class="absolute left-3 bottom-3 bg-orange-500 text-white text-xs px-2 py-1 rounded flex items-center gap-2">★ FEATURED</div>
        @endif

        @if($campaign->status == 'completed')
          <div class="absolute right-3 bottom-3 bg-green-600 text-white text-xs px-2 py-1 rounded">COMPLETED</div>
        @elseif($campaign->status == 'target')
          <div class="absolute right-3 bottom-3 bg-orange-600 text-white text-xs px-2 py-1 rounded">TARGET TERCAPAI</div>
        @endif
      </div>

      <div class="p-4">
        <h3 class="font-semibold text-lg mb-2">{{ $campaign->title }}</h3>

        <!-- Progress bar -->
        <div class="mb-3">
          <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
            <div class="h-2 rounded-full" style="width: {{ min(100, ($campaign->collected/$campaign->target)*100) }}%; background: linear-gradient(90deg,#ff7a18,#ff4b00);"></div>
          </div>
        </div>

        <!-- CTA button -->
        <div class="mb-4">
          @if($campaign->status == 'completed')
            <button class="w-full bg-gray-300 text-gray-700 py-2 rounded">COMPLETED</button>
          @else
            <a href="{{ route('campaigns.show', $campaign->id) }}" class="w-full inline-block text-center bg-orange-500 hover:bg-orange-600 text-white py-2 rounded">Bantu Sekarang</a>
          @endif
        </div>

        <!-- Footer numbers -->
        <div class="flex items-center justify-between text-sm text-gray-700">
          <div>
            <div class="text-xs text-gray-500">Didapatkan</div>
            <div class="font-medium">{{ number_format($campaign->collected,0,',','.') }}</div>
          </div>
          <div class="text-center">
            <div class="text-xs text-gray-500">|</div>
          </div>
          <div class="text-right">
            <div class="text-xs text-gray-500">Target</div>
            <div class="font-medium">{{ number_format($campaign->target,0,',','.') }}</div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Pagination (example) -->
  <div class="mt-8 flex justify-center">
    {{ $campaigns->links() }}
  </div>
</div>
@endsection