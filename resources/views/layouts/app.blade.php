<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TitipanHati - Titipan Kecil, Harapan Besar')</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="icon" href="/images/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    {{-- Navbar --}}
    <nav id="navbar" class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300"
        x-data="{ mobileMenu: false, userMenu: false }">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="/images/logo-titiphanhati-lightmode.svg" class="h-8 md:h-10 w-auto" alt="TitipanHati">
                    </a>
                </div>

                {{-- Desktop Navigation Links --}}
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-[#FF4400] font-medium transition-colors duration-200">
                        Beranda
                    </a>
                    <a href="{{ route('campaigns.index') }}"
                        class="text-gray-700 hover:text-[#FF4400] font-medium transition-colors duration-200">
                        Campaign
                    </a>
                    <a href="#cara-kerja"
                        class="text-gray-700 hover:text-[#FF4400] font-medium transition-colors duration-200">
                        Cara Kerja
                    </a>
                    <a href="#tentang"
                        class="text-gray-700 hover:text-[#FF4400] font-medium transition-colors duration-200">
                        Tentang Kami
                    </a>
                </div>

                {{-- Desktop Auth Buttons --}}
                <div class="hidden lg:flex items-center space-x-4">
                    @auth
                        <div class="relative">
                            <button @click="userMenu = !userMenu" @click.away="userMenu = false"
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <div
                                    class="w-8 h-8 rounded-full bg-[#FF4400] flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->profile->full_name ?? Auth::user()->email, 0, 1) }}
                                </div>
                                <span
                                    class="text-gray-700 font-medium">{{ Str::limit(Auth::user()->profile->full_name ?? Auth::user()->email, 15) }}</span>
                                <i class="fas fa-chevron-down text-sm text-gray-500" :class="{'rotate-180': userMenu}"></i>
                            </button>

                            <div x-show="userMenu" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-tachometer-alt mr-3 text-[#FF4400]"></i>
                                        <span class="font-medium">Admin Dashboard</span>
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                        class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-home w-5 mr-3 text-[#FF4400]"></i>
                                        <span class="font-medium">Dashboard</span>
                                    </a>
                                    <a href="{{ route('profile.index') }}"
                                        class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-user w-5 mr-3 text-[#FF4400]"></i>
                                        <span class="font-medium">Profil</span>
                                    </a>
                                    <a href="{{ route('donations.history') }}"
                                        class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-history w-5 mr-3 text-[#FF4400]"></i>
                                        <span class="font-medium">Riwayat Donasi</span>
                                    </a>
                                @endif
                                <hr class="my-2 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                        <span class="font-medium">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-6 py-2.5 bg-[#FF4400] text-white rounded-full font-semibold hover:bg-[#DE3B00] transition-all duration-200 shadow-md hover:shadow-lg">
                            Sign In
                        </a>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenu = !mobileMenu"
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <div class="w-6 h-5 relative flex flex-col justify-between">
                        <span class="w-full h-0.5 bg-gray-600 rounded-full transition-all duration-300"
                            :class="{'rotate-45 translate-y-2': mobileMenu}"></span>
                        <span class="w-full h-0.5 bg-gray-600 rounded-full transition-all duration-300"
                            :class="{'opacity-0': mobileMenu}"></span>
                        <span class="w-full h-0.5 bg-gray-600 rounded-full transition-all duration-300"
                            :class="{'-rotate-45 -translate-y-2': mobileMenu}"></span>
                    </div>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="lg:hidden border-t border-gray-100 py-4 space-y-1">

                {{-- Mobile Navigation Links --}}
                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <i class="fas fa-home w-6 text-[#FF4400]"></i>
                    <span class="ml-3 font-medium">Beranda</span>
                </a>
                <a href="{{ route('campaigns.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <i class="fas fa-hand-holding-heart w-6 text-[#FF4400]"></i>
                    <span class="ml-3 font-medium">Campaign</span>
                </a>
                <a href="#cara-kerja"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <i class="fas fa-info-circle w-6 text-[#FF4400]"></i>
                    <span class="ml-3 font-medium">Cara Kerja</span>
                </a>
                <a href="#tentang"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <i class="fas fa-users w-6 text-[#FF4400]"></i>
                    <span class="ml-3 font-medium">Tentang Kami</span>
                </a>

                @auth
                    <div class="border-t border-gray-100 mt-4 pt-4">
                        <div class="flex items-center px-4 py-3 mb-2">
                            <div
                                class="w-10 h-10 rounded-full bg-[#FF4400] flex items-center justify-center text-white font-semibold text-lg">
                                {{ substr(Auth::user()->profile->full_name ?? Auth::user()->email, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">{{ Auth::user()->profile->full_name ?? 'User' }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <i class="fas fa-tachometer-alt w-6 text-[#FF4400]"></i>
                                <span class="ml-3 font-medium">Admin Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <i class="fas fa-home w-6 text-[#FF4400]"></i>
                                <span class="ml-3 font-medium">Dashboard</span>
                            </a>
                            <a href="{{ route('profile.index') }}"
                                class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <i class="fas fa-user w-6 text-[#FF4400]"></i>
                                <span class="ml-3 font-medium">Profil</span>
                            </a>
                            <a href="{{ route('donations.history') }}"
                                class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <i class="fas fa-history w-6 text-[#FF4400]"></i>
                                <span class="ml-3 font-medium">Riwayat Donasi</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <i class="fas fa-sign-out-alt w-6"></i>
                                <span class="ml-3 font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="px-4 pt-4">
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center w-full px-6 py-3 bg-[#FF4400] text-white rounded-full font-semibold hover:bg-[#DE3B00] transition-all duration-200 shadow-md">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="toast-success"
            class="fixed bottom-5 right-5 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in z-[9999] max-w-sm">
            <i class="fa-solid fa-circle-check text-white"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto">
                <i class="fas fa-times text-white opacity-70 hover:opacity-100"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="toast-error" class="fixed bottom-5 right-5 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in z-[9999] max-w-sm">
            <i class="fa-solid fa-circle-xmark text-white"></i>
            <span class="text-sm font-medium">{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto">
                <i class="fas fa-times text-white opacity-70 hover:opacity-100"></i>
            </button>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Modern Footer --}}
    <footer class="bg-gray-900 text-white mt-20">
        <div class="container mx-auto px-4 py-12 lg:py-16">
            {{-- Main Footer Content --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                {{-- Brand Section --}}
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <img src="/images/logo-titiphanhati-darkmode.svg" class="h-10 w-auto" alt="TitipanHati">
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Platform donasi yang menghubungkan kebaikan hati dengan harapan. Bersama membangun masa depan
                        yang lebih baik.
                    </p>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-[#FF4400] flex items-center justify-center transition-all duration-300 hover:scale-105">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-[#FF4400] flex items-center justify-center transition-all duration-300 hover:scale-105">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-[#FF4400] flex items-center justify-center transition-all duration-300 hover:scale-105">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-[#FF4400] flex items-center justify-center transition-all duration-300 hover:scale-105">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="ml-20">
                    <h4 class="text-lg font-bold mb-4 text-white">Navigasi</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}"
                                class="text-gray-400 hover:text-[#FF4400] transition-colors duration-200 flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-[1px] transition-transform duration-200"></i>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('campaigns.index') }}"
                                class="text-gray-400 hover:text-[#FF4400] transition-colors duration-200 flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-[1px] transition-transform duration-200"></i>
                                Campaign
                            </a>
                        </li>
                        <li>
                            <a href="#cara-kerja"
                                class="text-gray-400 hover:text-[#FF4400] transition-colors duration-200 flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-[1px] transition-transform duration-200"></i>
                                Cara Kerja
                            </a>
                        </li>
                        <li>
                            <a href="#tentang"
                                class="text-gray-400 hover:text-[#FF4400] transition-colors duration-200 flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-[1px] transition-transform duration-200"></i>
                                Tentang Kami
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Support --}}
                <div>
                    <h4 class="text-lg font-bold mb-4 text-white">Bantuan</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('help.index') }}#faq"
                                class="text-gray-400 hover:text-[#FF4400] transition-colors duration-200 flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-[1px] transition-transform duration-200"></i>
                                FAQ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('help.index') }}#syarat-ketentuan"
                                class="text-gray-400 hover:text-[#FF4400] transition-colors duration-200 flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-[1px] transition-transform duration-200"></i>
                                Syarat & Ketentuan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('help.index') }}#kebijakan-privasi"
                                class="text-gray-400 hover:text-[#FF4400] transition-colors duration-200 flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-[1px] transition-transform duration-200"></i>
                                Kebijakan Privasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('help.index') }}#hubungi-kami"
                                class="text-gray-400 hover:text-[#FF4400] transition-colors duration-200 flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-[1px] transition-transform duration-200"></i>
                                Hubungi Kami
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-lg font-bold mb-4 text-white">Kontak</h4>
                    <ul class="space-y-3">
                        <li
                            class="flex items-start space-x-3 text-gray-400 hover:text-[#FF4400] transition-colors duration-200 group">
                            <i
                                class="fas fa-envelope w-4 mt-1 text-[#FF4400] group-hover:scale-110 transition-transform duration-200"></i>
                            <a href="mailto:cs@titipanhati.com" class="text-sm">cs@titipanhati.com</a>
                        </li>
                        <li
                            class="flex items-start space-x-3 text-gray-400 hover:text-[#FF4400] transition-colors duration-200 group">
                            <i
                                class="fab fa-whatsapp w-4 mt-1 text-[#FF4400] group-hover:scale-110 transition-transform duration-200"></i>
                            <a href="https://wa.me/6285155110751" class="text-sm">+62 851-5511-0751</a>
                        </li>
                        <li class="flex items-start space-x-3 text-gray-400 group">
                            <i class="fas fa-map-marker-alt w-4 mt-1 text-[#FF4400]"></i>
                            <span class="text-sm">Jakarta, Indonesia</span>
                        </li>
                    </ul>

                    {{-- Newsletter --}}
                    <!-- <div class="mt-6">
                        <p class="text-sm text-gray-400 mb-3">Berlangganan Newsletter</p>
                        <div class="flex gap-2">
                            <input type="email" placeholder="Email Anda" 
                                class="flex-1 px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white text-sm focus:outline-none focus:border-[#FF4400] transition-colors duration-200">
                            <button class="px-4 py-2 bg-[#FF4400] hover:bg-[#DE3B00] rounded-lg transition-colors duration-200">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>

            {{-- Bottom Footer --}}
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-gray-400 text-sm text-center md:text-left">
                        &copy; {{ date('Y') }} <span class="text-[#FF4400] font-semibold">TitipanHati</span>. All rights
                        reserved.
                    </p>
                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                        <span class="flex items-center">
                            <i class="fas fa-heart text-red-500 mx-1 animate-pulse"></i>
                            Made with love in Indonesia
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        // Auto hide toast messages
        setTimeout(() => {
            const success = document.getElementById('toast-success');
            const error = document.getElementById('toast-error');

            [success, error].forEach(toast => {
                if (toast) {
                    toast.classList.add('opacity-0', 'transition', 'duration-500');
                    setTimeout(() => toast.remove(), 500);
                }
            });
        }, 5000);

        // Navbar hide on scroll down
        let lastScrollTop = 0;
        const navbar = document.getElementById("navbar");

        window.addEventListener("scroll", function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                navbar.style.transform = "translateY(-100%)";
            } else {
                navbar.style.transform = "translateY(0)";
            }

            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        html {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #FF4400;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #DE3B00;
        }
    </style>
</body>

</html>