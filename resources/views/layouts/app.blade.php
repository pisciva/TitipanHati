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
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    {{-- Navbar --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-[#FF4400]">
                        TitipanHati
                    </a>
                </div>

                {{-- Navigation Links (Desktop) --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-[#EB3F00] transition">Beranda</a>
                    <a href="{{ route('campaigns.index') }}" class="text-gray-700 hover:text-[#EB3F00] transition">Campaign</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="flex items-center space-x-4">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-[#EB3F00]">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span>{{ Auth::user()->profile->full_name ?? Auth::user()->email }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profil
                                    </a>
                                    <a href="{{ route('donations.history') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-history mr-2"></i> Riwayat Donasi
                                    </a>
                                @endif
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-[#FF4400] hover:bg-orange-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
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
                <a href="{{ route('campaigns.index') }}" class="block py-2 text-gray-700 hover:text-blue-600">Campaign</a>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
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
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="text-gray-400 hover:text-white transition">Campaign</a></li>
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
                            <a href="#" class="hover:text-white transition"><i class="fab fa-instagram text-2xl"></i></a>
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
</body>
</html>