@extends('layouts.app')

@section('title', 'Semua Campaign - TitipanHati')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        

        <div class="relative mb-8 overflow-hidden">
            <div class="bg-[#FF4400] to-[#FF6B35] rounded-3xl shadow-2xl p-8 md:p-12 text-white">

                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full -ml-48 -mb-48 blur-3xl"></div>
                
                <div class="relative z-10">
                    <h1 class="text-4xl md:text-5xl font-bold mb-3 flex items-center gap-3">
                        <i class="fas fa-hand-holding-heart"></i>
                        Temukan Campaign
                    </h1>
                    <p class="text-white/90 text-lg max-w-2xl">
                        Jelajahi berbagai campaign donasi dan bantu mereka yang membutuhkan
                    </p>


                    <!-- <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-xl"></i>
                        </div>
                        <input type="text" 
                               id="realtimeSearch" 
                               placeholder="Cari campaign berdasarkan judul, organisasi, lokasi..."
                               class="w-full pl-16 pr-6 py-5 rounded-2xl bg-white text-gray-900 placeholder-gray-400 shadow-xl border-0 focus:ring-4 focus:ring-white/50 transition-all text-lg"
                               autocomplete="off">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <button type="button" 
                                    id="advancedFilterBtn"
                                    class="px-6 py-2.5 bg-[#FF4400] text-white rounded-xl font-semibold hover:bg-[#DE3B00] transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                                <i class="fas fa-sliders-h"></i>
                                <span class="hidden md:inline">Filter</span>
                            </button>
                        </div>
                    </div> -->


                    <div id="searchResultInfo" class="mt-4 text-white/80 text-sm hidden">
                        <i class="fas fa-info-circle mr-1"></i>
                        <span id="resultCount">0</span> campaign ditemukan
                    </div>
                </div>
            </div>
        </div>


        <!-- <div id="filterModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden animate-slideUp">

                <div class="bg-[#FF4400] to-[#FF6B35] p-6 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold flex items-center gap-3">
                            <i class="fas fa-filter"></i>
                            Filter Lanjutan
                        </h3>
                        <button id="closeFilterModal" class="text-white hover:bg-white/20 rounded-full p-2 transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>


                <form method="GET" action="{{ route('campaigns.index') }}" id="filterForm" class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        

                        <div class="lg:col-span-3">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-search text-[#FF4400] mr-2"></i>
                                Kata Kunci
                            </label>
                            <input type="text" 
                                   name="search" 
                                   id="modalSearch"
                                   value="{{ request('search') }}"
                                   placeholder="Cari berdasarkan judul atau yayasan..."
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] focus:border-transparent transition">
                        </div>


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-toggle-on text-[#FF4400] mr-2"></i>
                                Status Campaign
                            </label>
                            <select name="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] transition">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditutup" {{ request('status') === 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-chart-line text-[#FF4400] mr-2"></i>
                                Progress Donasi
                            </label>
                            <select name="progress" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] transition">
                                <option value="">Semua Progress</option>
                                <option value="0-25" {{ request('progress') === '0-25' ? 'selected' : '' }}>0% - 25%</option>
                                <option value="25-50" {{ request('progress') === '25-50' ? 'selected' : '' }}>25% - 50%</option>
                                <option value="50-75" {{ request('progress') === '50-75' ? 'selected' : '' }}>50% - 75%</option>
                                <option value="75-100" {{ request('progress') === '75-100' ? 'selected' : '' }}>75% - 100%</option>
                                <option value="100+" {{ request('progress') === '100+' ? 'selected' : '' }}>Target Tercapai</option>
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-tags text-[#FF4400] mr-2"></i>
                                Kategori
                            </label>
                            <select name="category" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] transition">
                                <option value="">Semua Kategori</option>
                                <option value="pakaian" {{ request('category') === 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                                <option value="makanan" {{ request('category') === 'makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="alat-tulis" {{ request('category') === 'alat-tulis' ? 'selected' : '' }}>Alat Tulis</option>
                                <option value="perlengkapan-bayi" {{ request('category') === 'perlengkapan-bayi' ? 'selected' : '' }}>Perlengkapan Bayi</option>
                                <option value="peralatan-rumah" {{ request('category') === 'peralatan-rumah' ? 'selected' : '' }}>Peralatan Rumah</option>
                                <option value="lainnya" {{ request('category') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-map-marker-alt text-[#FF4400] mr-2"></i>
                                Provinsi
                            </label>
                            <select name="province" id="province" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] transition">
                                <option value="">Semua Provinsi</option>
                                @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}" {{ request('province') == $prov->id ? 'selected' : '' }}>
                                        {{ $prov->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-city text-[#FF4400] mr-2"></i>
                                Kota / Kabupaten
                            </label>
                            <select name="city" id="city" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] transition" disabled>
                                <option value="">Pilih Provinsi Dahulu</option>
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-calendar-alt text-[#FF4400] mr-2"></i>
                                Deadline
                            </label>
                            <select name="deadline" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] transition">
                                <option value="">Semua Deadline</option>
                                <option value="7" {{ request('deadline') === '7' ? 'selected' : '' }}>7 Hari ke Depan</option>
                                <option value="14" {{ request('deadline') === '14' ? 'selected' : '' }}>14 Hari ke Depan</option>
                                <option value="30" {{ request('deadline') === '30' ? 'selected' : '' }}>30 Hari ke Depan</option>
                                <option value="expired" {{ request('deadline') === 'expired' ? 'selected' : '' }}>Sudah Berakhir</option>
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-eye text-[#FF4400] mr-2"></i>
                                Popularitas
                            </label>
                            <select name="views" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] transition">
                                <option value="">Semua</option>
                                <option value="100+" {{ request('views') === '100+' ? 'selected' : '' }}>> 100 views</option>
                                <option value="500+" {{ request('views') === '500+' ? 'selected' : '' }}>> 500 views</option>
                                <option value="1000+" {{ request('views') === '1000+' ? 'selected' : '' }}>> 1000 views (Trending)</option>
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-sort text-[#FF4400] mr-2"></i>
                                Urutkan
                            </label>
                            <select name="sort" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF4400] transition">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="trending" {{ request('sort') === 'trending' ? 'selected' : '' }}>Paling Banyak Dilihat</option>
                                <option value="deadline_soon" {{ request('sort') === 'deadline_soon' ? 'selected' : '' }}>Deadline Terdekat</option>
                                <option value="progress_high" {{ request('sort') === 'progress_high' ? 'selected' : '' }}>Progress Tertinggi</option>
                                <option value="progress_low" {{ request('sort') === 'progress_low' ? 'selected' : '' }}>Progress Terendah</option>
                            </select>
                        </div>
                    </div>


                    <div class="flex flex-wrap gap-3 mt-8 pt-6 border-t">
                        <button type="submit" class="flex-1 px-8 py-4 bg-[#FF4400] to-[#FF6B35] text-white rounded-xl font-bold hover:shadow-xl transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('campaigns.index') }}" class="px-8 py-4 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition flex items-center gap-2">
                            <i class="fas fa-redo"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div> -->

        @if(request()->hasAny(['search', 'status', 'progress', 'category', 'province', 'city', 'deadline', 'views', 'sort']))
            <div class="mb-6 bg-white rounded-2xl shadow-lg p-4 border-l-4 border-[#FF4400]">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-sm font-bold text-gray-700">
                            <i class="fas fa-filter text-[#FF4400] mr-1"></i>
                            Filter Aktif:
                        </span>
                        
                        @if(request('search'))
                            <span class="px-3 py-1.5 bg-[#FF4400]/10 text-[#FF4400] rounded-full text-sm font-semibold flex items-center gap-2">
                                <i class="fas fa-search"></i>
                                "{{ request('search') }}"
                            </span>
                        @endif

                        @if(request('status'))
                            <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                Status: {{ ucfirst(request('status')) }}
                            </span>
                        @endif

                        @if(request('progress'))
                            <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                Progress: {{ request('progress') }}%
                            </span>
                        @endif

                        @if(request('province'))
                            @php
                                $selectedProvince = $provinces->firstWhere('id', request('province'));
                            @endphp
                            <span class="px-3 py-1.5 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold">
                                {{ $selectedProvince->name ?? 'Provinsi' }}
                            </span>
                        @endif

                        @if(request('city'))
                            <span class="px-3 py-1.5 bg-pink-100 text-pink-700 rounded-full text-sm font-semibold">
                                {{ request('city') }}
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('campaigns.index') }}" class="text-[#FF4400] hover:text-[#DE3B00] font-semibold text-sm flex items-center gap-1 transition">
                        <i class="fas fa-times-circle"></i>
                        Hapus Semua
                    </a>
                </div>
            </div>
        @endif


        <div class="mb-6 bg-white rounded-2xl shadow-md p-4 flex items-center justify-between">
            <div>
                <p class="text-gray-600 flex items-center gap-2">
                    <i class="fas fa-list text-[#FF4400]"></i>
                    Menampilkan <span class="font-bold text-[#FF4400]">{{ $campaigns->count() }}</span> dari 
                    <span class="font-bold text-gray-900">{{ $campaigns->total() }}</span> campaign
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button id="gridView" class="p-2.5 rounded-lg bg-[#FF4400] text-white transition">
                    <i class="fas fa-th-large"></i>
                </button>
                <button id="listView" class="p-2.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>


        <div id="campaignsContainer">
            @if($campaigns->count() > 0)
                <div id="campaignGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($campaigns as $campaign)
                        @include('components.campaign-card', ['campaign' => $campaign])
                    @endforeach
                </div>


                <div class="mt-8">
                    {{ $campaigns->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-gray-50 to-orange-50/30 border-2 border-dashed border-gray-300 rounded-3xl p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-[#FF4400]/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-[#FF4400] text-4xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-3">Tidak Ada Campaign</h3>
                        <p class="text-gray-600 mb-8 text-lg">
                            Kami tidak menemukan campaign yang sesuai dengan pencarian Anda.
                        </p>
                        <a href="{{ route('campaigns.index') }}"
                           class="inline-flex items-center gap-3 px-8 py-4 bg-[#FF4400] to-[#FF6B35] text-white rounded-2xl font-bold hover:shadow-xl transition-all transform hover:scale-105">
                            <i class="fas fa-redo"></i>
                            Reset Pencarian
                        </a>
                    </div>
                </div>
            @endif

            @if($finishedCampaigns->count())
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        Campaign Telah Selesai
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 opacity-80">
                        @foreach($finishedCampaigns as $campaign)
                            @include('components.campaign-card', [
                                'campaign' => $campaign,
                                'isFinished' => true
                            ])
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


@push('styles')
<style>
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideUp {
        animation: slideUp 0.3s ease-out;
    }

    #filterModal {
        transition: opacity 0.3s ease;
    }

    #filterModal.show {
        display: flex !important;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #FF4400;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #DE3B00;
    }
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let searchTimeout;
    const realtimeSearch = document.getElementById('realtimeSearch');
    const searchResultInfo = document.getElementById('searchResultInfo');
    const resultCount = document.getElementById('resultCount');
    
    realtimeSearch.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (searchTerm.length >= 2) {
            searchResultInfo.classList.remove('hidden');
            resultCount.textContent = '...';
            
            searchTimeout = setTimeout(() => {

                const url = new URL(window.location.href);
                url.searchParams.set('search', searchTerm);
                window.location.href = url.toString();
            }, 800);
        } else if (searchTerm.length === 0) {
            searchResultInfo.classList.add('hidden');
        }
    });


    const filterModal = document.getElementById('filterModal');
    const advancedFilterBtn = document.getElementById('advancedFilterBtn');
    const closeFilterModal = document.getElementById('closeFilterModal');
    
    advancedFilterBtn.addEventListener('click', () => {
        filterModal.classList.remove('hidden');
        filterModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    });
    
    closeFilterModal.addEventListener('click', () => {
        filterModal.classList.add('hidden');
        filterModal.classList.remove('show');
        document.body.style.overflow = 'auto';
    });
    
    filterModal.addEventListener('click', (e) => {
        if (e.target === filterModal) {
            filterModal.classList.add('hidden');
            filterModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    });


    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const oldCityName = "{{ request('city') }}";

    const loadCities = (provinceId, cityToSelectName = null) => {
        citySelect.innerHTML = '<option value="">Memuat...</option>';
        citySelect.disabled = true;

        if (!provinceId) {
            citySelect.innerHTML = '<option value="">Pilih Provinsi Dulu</option>';
            citySelect.disabled = true;
            return;
        }

        const url = `{{ route('admin.campaigns.getCities', '') }}/${provinceId}`;

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                citySelect.innerHTML = '<option value="">Semua Kota</option>';
                
                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.name;
                    option.textContent = city.name;
                    
                    if (city.name === cityToSelectName) {
                        option.selected = true;
                    }
                    
                    citySelect.appendChild(option);
                });

                citySelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching cities:', error);
                citySelect.innerHTML = '<option value="">Gagal Memuat Kota</option>';
                citySelect.disabled = true;
            });
    };

    provinceSelect.addEventListener('change', function () {
        loadCities(this.value);
    });

    const initialProvinceId = provinceSelect.value;
    if (initialProvinceId) {
        loadCities(initialProvinceId, oldCityName);
    }


    const modalSearch = document.getElementById('modalSearch');
    if (realtimeSearch.value) {
        modalSearch.value = realtimeSearch.value;
    }


    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const campaignGrid = document.getElementById('campaignGrid');

    gridView.addEventListener('click', () => {
        campaignGrid.classList.remove('grid-cols-1');
        campaignGrid.classList.add('md:grid-cols-2', 'lg:grid-cols-3');
        gridView.classList.add('bg-[#FF4400]', 'text-white');
        gridView.classList.remove('bg-gray-100', 'text-gray-600');
        listView.classList.remove('bg-[#FF4400]', 'text-white');
        listView.classList.add('bg-gray-100', 'text-gray-600');
    });

    listView.addEventListener('click', () => {
        campaignGrid.classList.add('grid-cols-1');
        campaignGrid.classList.remove('md:grid-cols-2', 'lg:grid-cols-3');
        listView.classList.add('bg-[#FF4400]', 'text-white');
        listView.classList.remove('bg-gray-100', 'text-gray-600');
        gridView.classList.remove('bg-[#FF4400]', 'text-white');
        gridView.classList.add('bg-gray-100', 'text-gray-600');
    });
});
</script>
@endpush

@endsection