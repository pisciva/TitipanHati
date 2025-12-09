@extends('layouts.app')

@section('title', 'TitipanHati - Titipan Kecil, Harapan Besar')

@section('content')
    
    <section class="relative bg-[#FF4400] text-white py-20 lg:py-28 overflow-hidden">

        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div class="text-center lg:text-left" data-aos="fade-right">
                    <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-heart text-red-200 mr-2"></i>
                        <span class="text-sm font-semibold">Platform Donasi Terpercaya</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Titipan Kecil,<br>
                        <span class="text-yellow-200">Harapan Besar</span>
                    </h1>

                    <p class="text-lg md:text-xl mb-8 text-white/90 leading-relaxed max-w-xl">
                        Wujudkan kebaikan dengan berbagi pakaian layak pakai. Bersama yayasan & komunitas terpercaya, mari
                        bangun masa depan yang lebih baik.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#campaigns"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#FF4400] rounded-full font-bold hover:bg-gray-100 transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                            <i class="fas fa-hand-holding-heart mr-2"></i>
                            Lihat Campaign
                        </a>
                        <a href="#cara-kerja"
                            class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-full font-bold hover:bg-white hover:text-[#FF4400] transition-all duration-300">
                            <i class="fas fa-play-circle mr-2"></i>
                            Cara Kerja
                        </a>
                    </div>


                    <div class="grid grid-cols-3 gap-6 mt-12 max-w-xl mx-auto lg:mx-0">
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold mb-1">{{ number_format($statistics['total_items']) }}+</div>
                            <div class="text-sm text-white/80">Pakaian Terkumpul</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold mb-1">{{ $statistics['active_campaigns'] }}</div>
                            <div class="text-sm text-white/80">Campaign Aktif</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold mb-1">{{ $statistics['total_organizations'] }}</div>
                            <div class="text-sm text-white/80">Yayasan</div>
                        </div>
                    </div>
                </div>


                <div class="hidden lg:block" data-aos="fade-left">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 backdrop-blur-sm rounded-3xl transform rotate-6"></div>
                        <img src="/images/image1.jpg" alt="Donasi Pakaian"
                            class="relative rounded-3xl shadow-2xl w-full h-[500px] object-cover">


                        <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-2xl p-6 max-w-xs">
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">100%</div>
                                    <div class="text-sm text-gray-600">Terverifikasi</div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600">Semua yayasan telah melalui proses verifikasi ketat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="campaigns" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">

            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Campaign Aktif</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Pilih campaign yang sesuai dengan hati Anda dan mulai berbagi kebaikan hari ini
                </p>
            </div>


            <div class="mb-16" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-star text-yellow-600"></i>
                        </div>
                        Campaign Terbaru
                    </h3>
                    <a href="{{ route('campaigns.index') }}?sort=newest"
                        class="text-[#FF4400] hover:text-[#DE3B00] font-semibold text-sm flex items-center group">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($newest as $campaign)
                        @include('components.campaign-card', ['campaign' => $campaign])
                    @endforeach
                </div>
            </div>


            <div data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-fire text-red-600"></i>
                        </div>
                        Campaign Trending
                    </h3>
                    <a href="{{ route('campaigns.index') }}?sort=trending"
                        class="text-[#FF4400] hover:text-[#DE3B00] font-semibold text-sm flex items-center group">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($trending as $campaign)
                        @include('components.campaign-card', ['campaign' => $campaign])
                    @endforeach
                </div>
            </div>


            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('campaigns.index') }}"
                    class="inline-flex items-center px-8 py-4 bg-[#FF4400] text-white rounded-full font-bold hover:bg-[#DE3B00] transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-th-large mr-2"></i>
                    Lihat Semua Campaign
                </a>
            </div>
        </div>
    </section>


    <section id="cara-kerja" class="py-20 bg-white">
        <div class="container mx-auto px-4">

            <div class="text-center mb-16" data-aos="fade-up">
                <div class="inline-flex items-center bg-blue-100 rounded-full px-4 py-2 mb-4">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    <span class="text-sm font-semibold text-blue-800">Mudah & Cepat</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Berbagi kebaikan kini lebih mudah dengan 3 langkah sederhana
                </p>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">

                <div class="relative" data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">

                        <div
                            class="absolute top-3 left-1/2 transform -translate-x-7 w-12 h-12 bg-[#FF4400] text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg">
                            1
                        </div>


                        <div
                            class="w-20 h-20 bg-blue-500 text-white rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-search"></i>
                        </div>

                        <h3 class="font-bold text-xl mb-3 text-gray-900">Pilih Campaign</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Jelajahi campaign yang sesuai dengan pakaian yang ingin Anda donasikan
                        </p>
                    </div>
                </div>


                <div class="relative" data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">

                        <div
                            class="absolute top-3 left-1/2 transform -translate-x-7 w-12 h-12 bg-[#FF4400] text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg">
                            2
                        </div>


                        <div
                            class="w-20 h-20 bg-green-500 text-white rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-edit"></i>
                        </div>

                        <h3 class="font-bold text-xl mb-3 text-gray-900">Isi Form Donasi</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Lengkapi informasi barang, jumlah, kondisi, dan jadwal penjemputan
                        </p>
                    </div>
                </div>


                <div class="relative" data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">

                        <div
                            class="absolute top-3 left-1/2 transform -translate-x-7 w-12 h-12 bg-[#FF4400] text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg">
                            3
                        </div>


                        <div
                            class="w-20 h-20 bg-orange-500 text-white rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-truck"></i>
                        </div>

                        <h3 class="font-bold text-xl mb-3 text-gray-900">Pakaian Disalurkan</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Kami jemput donasi dan salurkan kepada yang membutuhkan
                        </p>
                    </div>
                </div>
            </div>


            <div class="mt-16 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="400">
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8 border-2 border-blue-100">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div
                            class="w-16 h-16 bg-blue-500 text-white rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="text-center md:text-left">
                            <h4 class="font-bold text-xl text-gray-900 mb-2">Proses Cepat & Gratis</h4>
                            <p class="text-gray-600">
                                Penjemputan dilakukan dalam 3-7 hari kerja setelah konfirmasi. Tanpa biaya apapun!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="tentang" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">

                <div data-aos="fade-right">
                    <div class="inline-flex items-center bg-purple-100 rounded-full px-4 py-2 mb-4">
                        <i class="fas fa-heart text-purple-600 mr-2"></i>
                        <span class="text-sm font-semibold text-purple-800">Tentang Kami</span>
                    </div>

                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                        Menghubungkan Kebaikan<br>dengan <span class="text-[#FF4400]">Harapan</span>
                    </h2>

                    <p class="text-gray-600 mb-6 leading-relaxed">
                        TitipanHati adalah platform yang menghubungkan donatur dengan yayasan dan komunitas terpercaya untuk
                        menyalurkan pakaian layak pakai kepada mereka yang membutuhkan.
                    </p>


                    <div class="space-y-4 mb-8">
                        <div
                            class="flex items-start bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div
                                class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-check-circle text-xl text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Transparan</h4>
                                <p class="text-sm text-gray-600">Lacak perjalanan donasi Anda hingga sampai ke penerima
                                    manfaat</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div
                                class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-shield-alt text-xl text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Terverifikasi</h4>
                                <p class="text-sm text-gray-600">Semua yayasan telah melalui proses verifikasi yang ketat
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-start bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div
                                class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-bolt text-xl text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Mudah & Cepat</h4>
                                <p class="text-sm text-gray-600">Proses donasi yang simple dengan layanan penjemputan gratis
                                </p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('help.index') }}#tentang"
                        class="inline-flex items-center px-6 py-3 bg-[#FF4400] text-white rounded-full font-semibold hover:bg-[#DE3B00] transition-all duration-300 shadow-lg hover:shadow-xl">
                        Pelajari Lebih Lanjut
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>


                <div class="relative" data-aos="fade-left">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="/images/image2.jpg" alt="Tentang TitipanHati" class="w-full h-[500px] object-cover">
                    </div>


                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-yellow-400 rounded-full opacity-20 blur-2xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-purple-400 rounded-full opacity-20 blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">

            <div class="text-center mb-12" data-aos="fade-up">
                <div class="inline-flex items-center bg-yellow-100 rounded-full px-4 py-2 mb-4">
                    <i class="fas fa-star text-yellow-600 mr-2"></i>
                    <span class="text-sm font-semibold text-yellow-800">Testimoni</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Apa Kata Mereka?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Pengalaman nyata dari para donatur dan yayasan yang telah bergabung
                </p>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($testimonials as $index => $testimonial)
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2"
                        data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                        <div class="text-[#FF4400] mb-4">
                            <i class="fas fa-quote-left text-3xl opacity-50"></i>
                        </div>


                        <div class="flex mb-4">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                                <i class="fas fa-star text-yellow-400 text-lg"></i>
                            @endfor
                        </div>


                        <p class="text-gray-700 mb-6 leading-relaxed">
                            "{{ $testimonial->content }}"
                        </p>


                        <div class="flex items-center pt-4 border-t border-gray-200">
                            <img src="{{ asset('storage/' . $testimonial->profile_picture) }}" alt="{{ $testimonial->name }}"
                                class="w-12 h-12 mr-4 rounded-full">
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $testimonial->name }}</h4>
                                <p class="text-sm text-gray-500 capitalize">{{ $testimonial->type }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 bg-[#FF4400] text-white relative overflow-hidden">

        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-10 left-10 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="zoom-in">
                <div class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                    <i class="fas fa-hands-helping mr-2"></i>
                    <span class="text-sm font-semibold">Mari Bergabung</span>
                </div>

                <h2 class="text-3xl lg:text-5xl font-bold mb-6 tracking-tight">
                    Mulai Berbagi Kebaikan Hari Ini
                </h2>

                <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Setiap pakaian yang Anda donasikan adalah harapan baru untuk mereka yang membutuhkan
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('campaigns.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#FF4400] rounded-full font-bold hover:bg-gray-100 transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                        <i class="fas fa-hand-holding-heart mr-2"></i>
                        Donasi Sekarang
                    </a>

                    @guest
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-full font-bold hover:bg-white hover:text-[#FF4400] transition-all duration-300">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Gratis
                        </a>
                    @endguest
                </div>


                <div class="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-shield-alt text-4xl mb-2"></i>
                        <div class="font-bold text-lg">Aman</div>
                        <div class="text-sm text-white/80">100% Terverifikasi</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="fas fa-hand-holding-heart text-4xl mb-2"></i>
                        <div class="font-bold text-lg">Gratis</div>
                        <div class="text-sm text-white/80">Tanpa Biaya</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="fas fa-check-circle text-4xl mb-2"></i>
                        <div class="font-bold text-lg">Transparan</div>
                        <div class="text-sm text-white/80">Dapat Dilacak</div>
                    </div>
                </div>
            </div>
        </div>
    </section>


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