@extends('layouts.app')

@section('title', 'Semua Campaign - TitipanHati')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Section Header --}}
    <div class="text-center mb-12" data-aos="fade-up">
        <div class="inline-flex items-center bg-orange-100 rounded-full px-4 py-2 mb-4">
            <i class="fas fa-fire text-orange-600 mr-2"></i>
            <span class="text-sm font-semibold text-orange-800">Semua Campaign</span>
        </div>
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Temukan Campaign yang Tepat</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Pilih campaign yang sesuai dengan hati Anda dan mulai berbagi kebaikan hari ini
        </p>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('campaigns.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Search --}}
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari Campaign
                </label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari berdasarkan judul atau yayasan..."
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-transparent transition">
            </div>

            {{-- Province --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt mr-1"></i> Provinsi
                </label>
                <select name="province" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400]">
                    <option value="">Semua Provinsi</option>
                    <option value="DKI Jakarta" {{ request('province') === 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                    <option value="Jawa Barat" {{ request('province') === 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                    <option value="Jawa Tengah" {{ request('province') === 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                    <option value="Jawa Timur" {{ request('province') === 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                    <option value="DI Yogyakarta" {{ request('province') === 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                    <!-- Tambahkan provinsi lainnya sesuai kebutuhan -->
                </select>
            </div>

            {{-- City --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-city mr-1"></i> Kota
                </label>
                <input type="text" name="city" value="{{ request('city') }}"
                       placeholder="Cari kota..."
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400]">
            </div>

            {{-- Sort --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sort mr-1"></i> Urutkan
                </label>
                <select name="sort" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400]">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="trending" {{ request('sort') === 'trending' ? 'selected' : '' }}>Paling Banyak Dilihat</option>
                    <option value="deadline_soon" {{ request('sort') === 'deadline_soon' ? 'selected' : '' }}>Deadline Terdekat</option>
                    <option value="progress_high" {{ request('sort') === 'progress_high' ? 'selected' : '' }}>Target Terdekat</option>
                    <option value="progress_low" {{ request('sort') === 'progress_low' ? 'selected' : '' }}>Target Terjauh</option>
                </select>
            </div>

            {{-- Submit Button --}}
            <div class="md:col-span-5 flex flex-wrap gap-2 mt-2">
                <button type="submit" class="px-6 py-2.5 bg-[#FF4400] text-white rounded-lg hover:bg-[#DE3B00] transition flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('campaigns.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Results Info --}}
    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">
            Menampilkan <span class="font-semibold">{{ $campaigns->count() }}</span> dari <span class="font-semibold">{{ $campaigns->total() }}</span> campaign
            @if(request('search') || request('province') || request('city'))
                untuk "<strong>{{ request('search') ?: request('province') ?: request('city') }}</strong>"
            @endif
        </p>
    </div>

    {{-- Campaign Grid --}}
    @if($campaigns->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($campaigns as $campaign)
                @include('components.campaign-card', ['campaign' => $campaign])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $campaigns->appends(request()->query())->links() }}
        </div>
    @else
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-dashed border-gray-300 rounded-2xl p-12 text-center">
            <i class="fas fa-search text-[#FF4400] text-6xl mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Campaign Tidak Ditemukan</h3>
            <p class="text-gray-600 mb-6">
                Kami tidak menemukan campaign yang sesuai dengan filter Anda. Silakan coba kata kunci atau filter lainnya.
            </p>
            <a href="{{ route('campaigns.index') }}"
               class="inline-flex items-center px-6 py-3 bg-[#FF4400] text-white rounded-full font-semibold hover:bg-[#DE3B00] transition">
                <i class="fas fa-sync-alt mr-2"></i>
                Reset Semua Filter
            </a>
        </div>
    @endif
</div>
@endsection