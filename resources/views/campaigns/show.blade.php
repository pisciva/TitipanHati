@extends('layouts.app')

@section('title', $campaign->title . ' - TitipanHati')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('campaigns.index') }}" class="text-gray-700 hover:text-blue-600">Campaign</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">{{ Str::limit($campaign->title, 30) }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            {{-- Campaign Banner --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <img src="{{ $campaign->banner_url ?? '/images/default-campaign.jpg' }}" 
                     alt="{{ $campaign->title }}"
                     class="w-full h-96 object-cover">
            </div>

            {{-- Campaign Info --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $campaign->title }}</h1>

                {{-- Meta Info --}}
                <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-building text-blue-600 mr-2"></i>
                        <a href="#" class="hover:text-blue-600 font-medium">
                            {{ $campaign->organization->name }}
                        </a>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                        <span>{{ $campaign->city }}, {{ $campaign->province }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-eye text-gray-600 mr-2"></i>
                        <span>{{ number_format($campaign->view_count) }} views</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-green-600 mr-2"></i>
                        <span>{{ $campaign->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                {{-- Categories --}}
                @if($campaign->categories->count() > 0)
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($campaign->categories as $category)
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Progress Bar --}}
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress Donasi</span>
                        <span class="text-sm font-bold text-blue-600">{{ $campaign->progressPercentage() }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full transition-all duration-500"
                             style="width: {{ $campaign->progressPercentage() }}%">
                        </div>
                    </div>
                    <div class="flex justify-between mt-2 text-sm">
                        <span class="text-gray-600">
                            <span class="font-bold text-blue-600">{{ number_format($campaign->collected_quantity) }}</span> 
                            terkumpul
                        </span>
                        <span class="text-gray-600">
                            Target: <span class="font-bold">{{ number_format($campaign->target_quantity) }}</span> item
                        </span>
                    </div>
                </div>

                {{-- Deadline Alert --}}
                @php
                    $daysLeft = now()->diffInDays($campaign->deadline, false);
                @endphp
                
                @if($daysLeft > 0)
                    <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-orange-500 mr-3"></i>
                            <div>
                                <p class="font-medium text-orange-800">
                                    Tersisa {{ $daysLeft }} hari lagi
                                </p>
                                <p class="text-sm text-orange-700">
                                    Deadline: {{ $campaign->deadline->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <p class="font-medium text-red-800">Campaign ini telah berakhir</p>
                        </div>
                    </div>
                @endif

                {{-- Description --}}
                <div class="prose max-w-none">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi Campaign</h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $campaign->description }}
                    </div>
                </div>
            </div>

            {{-- Donation History --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-history text-blue-600 mr-2"></i>
                    Riwayat Donasi
                </h2>

                @if($campaign->donations->count() > 0)
                    <div class="space-y-4">
                        @foreach($campaign->donations->take(10) as $donation)
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-gray-900">
                                                {{ $donation->user->name ?? 'Anonim' }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ $donation->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                            {{ $donation->status }}
                                        </span>
                                    </div>
                                    @if($donation->message)
                                        <p class="mt-2 text-sm text-gray-700 italic">
                                            "{{ $donation->message }}"
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($campaign->donations->count() > 10)
                        <div class="mt-4 text-center">
                            <button class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                Lihat Semua Donasi <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>Belum ada donasi untuk campaign ini</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            {{-- Donation Card --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-4">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Berdonasi Sekarang</h3>

                {{-- Quick Stats --}}
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Total Donatur</span>
                        <span class="font-bold text-gray-900">{{ $campaign->donations->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Terkumpul</span>
                        <span class="font-bold text-blue-600">{{ number_format($campaign->collected_quantity) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Target</span>
                        <span class="font-bold text-gray-900">{{ number_format($campaign->target_quantity) }}</span>
                    </div>
                </div>

                @if($campaign->isActive() && $daysLeft > 0)
                    <a href="{{ route('donations.create', $campaign->id) }}" 
                       class="block w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md">
                        <i class="fas fa-hand-holding-heart mr-2"></i>
                        Donasi Sekarang
                    </a>

                    <button class="mt-3 w-full py-3 px-4 border-2 border-gray-300 text-gray-700 text-center font-semibold rounded-lg hover:bg-gray-50 transition-all">
                        <i class="fas fa-share-alt mr-2"></i>
                        Bagikan Campaign
                    </button>
                @else
                    <div class="bg-gray-100 text-gray-600 text-center py-3 px-4 rounded-lg">
                        <i class="fas fa-lock mr-2"></i>
                        Campaign Tidak Aktif
                    </div>
                @endif
            </div>

            {{-- Organization Info --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Tentang Yayasan</h3>
                
                <div class="flex items-center mb-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-building text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $campaign->organization->name }}</h4>
                        @if($campaign->organization->is_verified)
                            <span class="text-xs text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                            </span>
                        @endif
                    </div>
                </div>

                @if($campaign->organization->description)
                    <p class="text-sm text-gray-600 mb-4">
                        {{ Str::limit($campaign->organization->description, 150) }}
                    </p>
                @endif

                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                    Lihat Profil Lengkap <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            {{-- Campaign Stats --}}
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                <h3 class="text-lg font-bold mb-4">Statistik Campaign</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-chart-line mr-3"></i>
                            <span class="text-sm">Progress</span>
                        </div>
                        <span class="font-bold">{{ $campaign->progressPercentage() }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-3"></i>
                            <span class="text-sm">Donatur</span>
                        </div>
                        <span class="font-bold">{{ $campaign->donations->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-eye mr-3"></i>
                            <span class="text-sm">Views</span>
                        </div>
                        <span class="font-bold">{{ number_format($campaign->view_count) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Campaigns --}}
    @php
        $relatedCampaigns = \App\Models\Campaign::where('status', 'aktif')
            ->where('id', '!=', $campaign->id)
            ->where(function($q) use ($campaign) {
                $q->where('province', $campaign->province)
                  ->orWhereHas('categories', function($q) use ($campaign) {
                      $q->whereIn('categories.id', $campaign->categories->pluck('id'));
                  });
            })
            ->limit(3)
            ->get();
    @endphp

    @if($relatedCampaigns->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Campaign Serupa</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedCampaigns as $relatedCampaign)
                    @include('components.campaign-card', ['campaign' => $relatedCampaign])
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection