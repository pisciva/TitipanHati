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
    <nav id="navbar" class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center space-x-2">
                    <a href="{{ route('home') }}">
                        <img src="/images/logo-titiphanhati-lightmode.svg" class="w-40" alt="">
                    </a>
                </div>

                {{-- Navigation Links (Desktop) --}}
                <div class="flex gap-8">
                    <a href="{{ route('home') }}" class="hover:text-[#EB3F00] hover:underline">Beranda</a>
                    <a href="{{ route('campaigns.index') }}" class="hover:text-[#EB3F00] hover:underline">Campaign</a>
                    <a href="{{ route('campaigns.index') }}" class="hover:text-[#EB3F00] hover:underline">Cara Kerja</a>
                    <a href="{{ route('campaigns.index') }}" class="hover:text-[#EB3F00] hover:underline">Tentang
                        Kami</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="flex items-center space-x-4">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 text-gray-700 hover:text-[#EB3F00]">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span>{{ Auth::user()->profile->full_name ?? Auth::user()->email }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('profile.index') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profil
                                    </a>
                                    <a href="{{ route('donations.history') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-history mr-2"></i> Riwayat Donasi
                                    </a>
                                @endif
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-[#FF4400] hover:bg-orange-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-8 py-2 bg-[#FF4400] text-white rounded-full font-semibold hover:bg-blue-700 transition">
                            Sign In
                        </a>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button @click="mobileMenu = !mobileMenu" class="text-gray-700">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileMenu" class="md:hidden pb-4" x-data="{ mobileMenu: false }">
                <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-blue-600">Beranda</a>
                <a href="{{ route('campaigns.index') }}"
                    class="block py-2 text-gray-700 hover:text-blue-600">Campaign</a>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="toast-success"
            class="fixed bottom-5 right-5 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in z-[9999]">

            <i class="fa-solid fa-circle-check text-white"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div id="toast-error"
            class="fixed bottom-5 right-5 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in z-[9999]">

            <i class="fa-solid fa-circle-xmark text-white"></i>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Logo & Tagline --}}
                <div>
                    <h3 class="text-2xl font-bold mb-2">
                        <i class="fas fa-hand-holding-heart"></i> TitipanHati
                    </h3>
                    <p class="text-gray-400">Berbagi pakaian, berbagi harapan</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Beranda</a>
                        </li>
                        <li><a href="{{ route('campaigns.index') }}"
                                class="text-gray-400 hover:text-white transition">Campaign</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> info@titipanhati.com</li>
                        <li><i class="fab fa-whatsapp mr-2"></i> +62 812-3456-7890</li>
                        <li class="flex space-x-4 mt-4">
                            <a href="#" class="hover:text-white transition"><i class="fab fa-facebook text-2xl"></i></a>
                            <a href="#" class="hover:text-white transition"><i
                                    class="fab fa-instagram text-2xl"></i></a>
                            <a href="#" class="hover:text-white transition"><i class="fab fa-twitter text-2xl"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 TitipanHati. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        // Auto hide after 3 seconds
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

        let lastScrollTop = 0;
        const navbar = document.getElementById("navbar");

        window.addEventListener("scroll", function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scroll ke bawah → sembunyikan navbar
                navbar.style.transform = "translateY(-120%)";
            } else {
                // Scroll ke atas → munculkan navbar
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
    </style>
</body>

</html>