@extends('layouts.app')

@section('title', 'Semua Campaign - TitipanHati')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Semua Campaign</h1>

    {{-- Filter & Search --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('campaigns.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari Campaign
                </label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan judul atau yayasan..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            {{-- Province --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt mr-1"></i> Provinsi
                </label>
                <select name="province" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Provinsi</option>
                    <option value="DKI Jakarta" {{ request('province') === 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                    <option value="Jawa Barat" {{ request('province') === 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                    <option value="Jawa Tengah" {{ request('province') === 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                    <option value="Jawa Timur" {{ request('province') === 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                    <option value="DI Yogyakarta" {{ request('province') === 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                </select>
            </div>

            {{-- Sort --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sort mr-1"></i> Urutkan
                </label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="trending" {{ request('sort') === 'trending' ? 'selected' : '' }}>Trending</option>
                </select>
            </div>

            {{-- Submit Button --}}
            <div class="md:col-span-4 flex space-x-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('campaigns.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Campaign Grid --}}
    @if($campaigns->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach($campaigns as $campaign)
                @include('components.campaign-card', ['campaign' => $campaign])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $campaigns->links() }}
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
            <i class="fas fa-info-circle text-yellow-600 text-4xl mb-4"></i>
            <p class="text-gray-700">Tidak ada campaign yang sesuai dengan filter Anda.</p>
        </div>
    @endif
</div>
@endsection