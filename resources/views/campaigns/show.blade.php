@extends('layouts.app')

@section('title', $campaign->title . ' - TitipanHati')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        {{-- Hero Section with Breadcrumb --}}
        <section class="bg-[#FF4400] text-white py-8">
            <div class="container mx-auto px-4">
                {{-- Breadcrumb --}}
                <nav class="flex text-sm" aria-label="Breadcrumb" data-aos="fade-right">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="text-white/80 hover:text-white transition-colors">
                                <i class="fas fa-home mr-1"></i> Beranda
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-white/60 mx-2 text-xs"></i>
                                <a href="{{ route('campaigns.index') }}"
                                    class="text-white/80 hover:text-white transition-colors">Campaign</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-white/60 mx-2 text-xs"></i>
                                <span class="text-white/90">{{ $campaign->title }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Campaign Banner --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up">
                        <div class="relative">
                            <img src="{{ $campaign->banner_url ?? '/images/default-campaign.jpg' }}"
                                alt="{{ $campaign->title }}" class="w-full h-[400px] object-cover">

                            {{-- Overlay Badge --}}
                            <div class="absolute top-4 right-4">
                                @php
                                    $daysLeft = now()->diffInDays($campaign->deadline, false);
                                @endphp

                                @if($daysLeft > 0)
                                    <div class="bg-white/95 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-clock text-orange-500"></i>
                                            <span class="font-bold text-gray-900">{{ round($daysLeft) }} Hari Lagi</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-red-500 rounded-full px-4 py-2 shadow-lg">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-exclamation-circle text-white"></i>
                                            <span class="font-bold text-white">Berakhir</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Campaign Info Card --}}
                    <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8" data-aos="fade-up" data-aos-delay="100">
                        {{-- Title --}}
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">{{ $campaign->title }}</h1>

                        {{-- Meta Info --}}
                        <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-center bg-blue-50 rounded-lg px-3 py-2">
                                <i class="fas fa-building text-blue-600 mr-2"></i>
                                <a href="#organization-info" class="hover:text-blue-600 font-medium text-sm text-gray-700">
                                    {{ $campaign->organization->name }}
                                </a>
                            </div>
                            <div class="flex items-center bg-red-50 rounded-lg px-3 py-2">
                                <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                                <span class="text-sm text-gray-700">{{ $campaign->city }}, {{ $campaign->province }}</span>
                            </div>
                            <div class="flex items-center bg-gray-50 rounded-lg px-3 py-2">
                                <i class="fas fa-eye text-gray-600 mr-2"></i>
                                <span class="text-sm text-gray-700">{{ number_format($campaign->view_count) }} views</span>
                            </div>
                        </div>

                        {{-- Categories --}}
                        @if($campaign->categories->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-8">
                                @foreach($campaign->categories as $category)
                                    <span
                                        class="inline-flex items-center px-4 py-2 bg-blue-50 to-blue-100 text-blue-700 rounded-full text-sm font-semibold border border-blue-200">
                                        <i class="fas fa-tag mr-2 text-xs"></i>
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Progress Section --}}
                        <div class="bg-gray-50 to-blue-50 rounded-xl p-6 mb-8">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-semibold text-gray-700">Progress Donasi</span>
                                <span class="text-lg font-bold text-[#FF4400]">{{ $campaign->progressPercentage() }}%</span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden mb-4 shadow-inner">
                                <div class="bg-[#FF4400] to-[#FF6B3D] h-5 rounded-full transition-all duration-700 relative overflow-hidden"
                                    style="width: {{ $campaign->progressPercentage() }}%">
                                    <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-[#FF4400]">
                                        {{ number_format($campaign->collected_quantity) }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Item Terkumpul</div>
                                </div>
                                <div class="text-center p-3 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">
                                        {{ number_format($campaign->target_quantity) }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Target Item</div>
                                </div>
                            </div>
                        </div>

                        {{-- Deadline Alert --}}
                        @if($daysLeft > 0)
                            <div class="bg-orange-50 to-orange-100 border-l-4 border-orange-500 rounded-lg p-4 mb-8">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-clock text-white"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-bold text-orange-900 text-lg">
                                            Tersisa {{ round($daysLeft) }} hari lagi!
                                        </p>
                                        <p class="text-sm text-orange-700 mt-1">
                                            Deadline: {{ $campaign->deadline->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-red-50 to-red-100 border-l-4 border-red-500 rounded-lg p-4 mb-8">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-exclamation-circle text-white"></i>
                                    </div>
                                    <p class="font-bold text-red-900 ml-4">Campaign ini telah berakhir</p>
                                </div>
                            </div>
                        @endif

                        {{-- Description --}}
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-align-left text-blue-600"></i>
                                </div>
                                Deskripsi Campaign
                            </h2>
                            <div
                                class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50 rounded-xl p-6">
                                {{ $campaign->description }}
                            </div>
                        </div>
                    </div>

                    {{-- Donation History --}}
                    <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-history text-green-600"></i>
                            </div>
                            Riwayat Donasi
                        </h2>

                        @if($campaign->donations->count() > 0)
                            <div class="space-y-4">
                                @foreach($campaign->donations->take(10) as $donation)
                                    <div
                                        class="flex items-start space-x-4 p-4 bg-gray-50 to-blue-50 rounded-xl hover:shadow-md transition-shadow duration-300">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-14 h-14 bg-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-md">
                                                <i class="fas fa-user text-white text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="font-bold text-gray-900 text-lg">
                                                        {{ $donation->user->name ?? 'Donatur Anonim' }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 flex items-center mt-1">
                                                        <i class="fas fa-clock mr-1 text-xs"></i>
                                                        {{ $donation->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <span
                                                    class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    {{ ucfirst($donation->status) }}
                                                </span>
                                            </div>
                                            @if($donation->message)
                                                <div class="bg-white rounded-lg p-3 mt-2 border-l-4 border-blue-400">
                                                    <p class="text-sm text-gray-700 italic">
                                                        "{{ $donation->message }}"
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($campaign->donations->count() > 10)
                                <div class="mt-6 text-center">
                                    <button
                                        class="inline-flex items-center px-6 py-3 bg-blue-500 to-blue-600 text-white rounded-full font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                        Lihat Semua Donasi
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-16">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 text-lg font-medium">Belum ada donasi untuk campaign ini</p>
                                <p class="text-gray-400 text-sm mt-2">Jadilah yang pertama berdonasi!</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-10 space-y-6">
                        {{-- Donation Card --}}
                        <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100" data-aos="fade-left">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-hand-holding-heart text-[#FF4400] mr-2"></i>
                                Berdonasi Sekarang
                            </h3>

                            {{-- Quick Stats --}}
                            <div class="space-y-3 mb-6 bg-gray-50 rounded-xl p-4">
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 text-sm flex items-center">
                                        <i class="fas fa-users text-blue-500 mr-2"></i>
                                        Total Donatur
                                    </span>
                                    <span class="font-bold text-gray-900 text-lg">{{ $campaign->donations->count() }}</span>
                                </div>
                                <div class="h-px bg-gray-200"></div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 text-sm flex items-center">
                                        <i class="fas fa-box text-[#FF4400] mr-2"></i>
                                        Terkumpul
                                    </span>
                                    <span
                                        class="font-bold text-[#FF4400] text-lg">{{ number_format($campaign->collected_quantity) }}</span>
                                </div>
                                <div class="h-px bg-gray-200"></div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 text-sm flex items-center">
                                        <i class="fas fa-bullseye text-green-500 mr-2"></i>
                                        Target
                                    </span>
                                    <span
                                        class="font-bold text-gray-900 text-lg">{{ number_format($campaign->target_quantity) }}</span>
                                </div>
                            </div>

                            @if($campaign->isActive() && $daysLeft > 0)
                                <a href="{{ route('donations.create', $campaign->id) }}"
                                    class="block w-full py-4 px-6 bg-[#FF4400] to-[#FF6B3D] text-white text-center font-bold rounded-xl hover:from-[#DE3B00] hover:to-[#FF4400] transition-all shadow-lg hover:shadow-xl hover:bg-[#DE3B00] transform duration-300 mb-3">
                                    <i class="fas fa-hand-holding-heart mr-2"></i>
                                    Donasi Sekarang
                                </a>
                            @else
                                <div
                                    class="bg-gray-100 to-gray-200 text-gray-600 text-center py-4 px-6 rounded-xl border-2 border-gray-300">
                                    <i class="fas fa-lock mr-2"></i>
                                    Campaign Tidak Aktif
                                </div>
                            @endif
                        </div>

                        {{-- Organization Info --}}
                        <div id="organization-info" class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100"
                            data-aos="fade-left" data-aos-delay="100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-building text-blue-600 mr-2"></i>
                                Tentang Yayasan
                            </h3>

                            <div class="flex items-center mb-6 p-4 bg-blue-50 to-blue-100 rounded-xl">
                                <div
                                    class="w-16 h-16 bg-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-md flex-shrink-0">
                                    <i class="fas fa-building text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">{{ $campaign->organization->name }}</h4>
                                    @if($campaign->organization->is_verified)
                                        <span
                                            class="inline-flex items-center text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full mt-1">
                                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($campaign->organization->description)
                                <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 rounded-lg p-4">
                                    {{ Str::limit($campaign->organization->description, 200) }}
                                </p>
                            @endif
                        </div>

                        {{-- Campaign Stats --}}
                        <div class="bg-[#FF4400] to-[#DE3B00] rounded-2xl shadow-lg p-6 text-white" data-aos="fade-left"
                            data-aos-delay="200">
                            <h3 class="text-xl font-bold mb-6 flex items-center">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Statistik Campaign
                            </h3>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-white/10 backdrop-blur-sm rounded-xl">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <span class="text-sm font-medium">Progress</span>
                                    </div>
                                    <span class="font-bold text-xl">{{ $campaign->progressPercentage() }}%</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-white/10 backdrop-blur-sm rounded-xl">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <span class="text-sm font-medium">Donatur</span>
                                    </div>
                                    <span class="font-bold text-xl">{{ $campaign->donations->count() }}</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-white/10 backdrop-blur-sm rounded-xl">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        <span class="text-sm font-medium">Views</span>
                                    </div>
                                    <span class="font-bold text-xl">{{ number_format($campaign->view_count) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Campaigns --}}
            @php
                $relatedCampaigns = \App\Models\Campaign::where('status', 'aktif')
                    ->where('id', '!=', $campaign->id)
                    ->where(function ($q) use ($campaign) {
                        $q->where('province', $campaign->province)
                            ->orWhereHas('categories', function ($q) use ($campaign) {
                                $q->whereIn('categories.id', $campaign->categories->pluck('id'));
                            });
                    })
                    ->limit(3)
                    ->get();
            @endphp

            @if($relatedCampaigns->count() > 0)
                <div class="mt-16" data-aos="fade-up">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">Campaign Serupa</h2>
                        <p class="text-gray-600">Jelajahi campaign lainnya yang mungkin Anda minati</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedCampaigns as $relatedCampaign)
                            @include('components.campaign-card', ['campaign' => $relatedCampaign])
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- AOS Animation Library --}}
    @push('scripts')
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100
            });
        </script>
    @endpush
@endsection