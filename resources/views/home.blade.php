@extends('layouts.app')

@section('title', 'TitipanHati - Titipan Kecil, Harapan Besar')

@section('content')
{{-- Hero Section --}}
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Titipan Kecil, Harapan Besar
                </h1>
                <p class="text-xl mb-8">
                    Platform donasi pakaian untuk membantu mereka yang membutuhkan, bersama yayasan & komunitas terpercaya.
                </p>
                <a href="#campaigns" class="inline-block px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Lihat Campaign
                </a>
            </div>
            <div class="hidden md:block">
                <img src="https://via.placeholder.com/500x400" alt="Hero Image" class="rounded-lg shadow-lg">
            </div>
        </div>
    </div>
</section>

{{-- Campaign Section --}}
<section id="campaigns" class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Campaign Aktif</h2>
        
        {{-- Terbaru --}}
        <div class="mb-12">
            <h3 class="text-2xl font-semibold mb-6 flex items-center">
                <i class="fas fa-star text-yellow-500 mr-2"></i> Terbaru
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($newest as $campaign)
                    @include('components.campaign-card', ['campaign' => $campaign])
                @endforeach
            </div>
        </div>

        {{-- Trending --}}
        <div>
            <h3 class="text-2xl font-semibold mb-6 flex items-center">
                <i class="fas fa-fire text-red-500 mr-2"></i> Trending
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($trending as $campaign)
                    @include('components.campaign-card', ['campaign' => $campaign])
                @endforeach
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('campaigns.index') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                Lihat Semua Campaign
            </a>
        </div>
    </div>
</section>

{{-- Cara Kerja Section --}}
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Cara Kerja</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="font-semibold text-xl mb-2">1. Pilih Campaign</h3>
                <p class="text-gray-600">Cari campaign yang sesuai dengan pakaian yang ingin Anda donasikan</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fas fa-edit"></i>
                </div>
                <h3 class="font-semibold text-xl mb-2">2. Isi Form Donasi</h3>
                <p class="text-gray-600">Lengkapi data barang, jumlah, kondisi, dan jadwal penjemputan</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fas fa-truck"></i>
                </div>
                <h3 class="font-semibold text-xl mb-2">3. Pakaian Disalurkan</h3>
                <p class="text-gray-600">Kami jemput dan salurkan ke penerima yang membutuhkan</p>
            </div>
        </div>
    </div>
</section>

{{-- Tentang Kami Section --}}
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold mb-4">Tentang Kami</h2>
                <p class="text-gray-700 mb-4">
                    TitipanHati adalah platform yang menghubungkan donatur dengan yayasan dan komunitas terpercaya untuk menyalurkan pakaian layak pakai kepada mereka yang membutuhkan.
                </p>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <span><strong>Transparan:</strong> Lacak donasi Anda hingga sampai ke penerima</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <span><strong>Terverifikasi:</strong> Semua yayasan telah melalui proses verifikasi</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <span><strong>Mudah:</strong> Proses donasi yang simple dan cepat</span>
                    </div>
                </div>
            </div>
            <div>
                <img src="https://via.placeholder.com/500x400" alt="Tentang Kami" class="rounded-lg shadow-lg">
            </div>
        </div>
    </div>
</section>

{{-- Statistik Section --}}
<section class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-5xl font-bold mb-2">
                    <i class="fas fa-tshirt"></i>
                </div>
                <div class="text-4xl font-bold mb-2">{{ number_format($statistics['total_items']) }}+</div>
                <div class="text-xl">Pakaian Terkumpul</div>
            </div>
            <div>
                <div class="text-5xl font-bold mb-2">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="text-4xl font-bold mb-2">{{ $statistics['active_campaigns'] }}</div>
                <div class="text-xl">Campaign Aktif</div>
            </div>
            <div>
                <div class="text-5xl font-bold mb-2">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <div class="text-4xl font-bold mb-2">{{ $statistics['total_organizations'] }}</div>
                <div class="text-xl">Yayasan Terlibat</div>
            </div>
        </div>
    </div>
</section>

{{-- Testimoni Section --}}
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Testimoni</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mr-3">
                        <i class="fas {{ $testimonial->type === 'donatur' ? 'fa-user' : 'fa-building' }}"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold">{{ $testimonial->name }}</h4>
                        <p class="text-sm text-gray-600">{{ ucfirst($testimonial->type) }}</p>
                    </div>
                </div>
                <div class="flex mb-2">
                    @for($i = 0; $i < $testimonial->rating; $i++)
                        <i class="fas fa-star text-yellow-400"></i>
                    @endfor
                </div>
                <p class="text-gray-700">{{ $testimonial->content }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection