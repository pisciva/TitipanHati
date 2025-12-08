<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TitipanHati - Titipan Kecil, Harapan Besar')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
<!--
  Perubahan:
  - Gunakan localStorage untuk menyimpan sidebarOpen sehingga tidak berubah tiap pindah halaman.
  - Tombol toggle sidebar sekarang juga menyimpan nilai ke localStorage.
-->
<div x-data="{
        mobileMenu: false,
        // baca dari localStorage jika ada, jika tidak fallback ke window.innerWidth >= 768
        sidebarOpen: (localStorage.getItem('sidebarOpen') === 'true') ? true : (localStorage.getItem('sidebarOpen') === 'false' ? false : (window.innerWidth >= 768))
    }">

    {{-- NAVBAR TANPA LOGO & TANPA BURGER --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
                        {{-- LOGO MOBILE SAJA --}}
            <a href="{{ route('home') }}" class="md:hidden absolute left-4 top-1/2 -translate-y-1/2" x-show="!mobileMenu" x-cloak>
                <img src="{{ asset('Logo.svg') }}" alt="Logo TitipanHati" class="h-8 w-auto">
            </a>
            <div class="flex items-center justify-end h-16"> {{-- <-- HANYA MENYISAKAN BAGIAN KANAN --}}
                
                {{-- MENU USER DESKTOP --}}
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-[#EB3F00]">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span>{{ Auth::user()->profile->full_name ?? Auth::user()->email }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profil
                                    </a>
                                    <a href="{{ route('profile.riwayat') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-history mr-2"></i> Riwayat Donasi
                                    </a>
                                @endif
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-[#FF4400] hover:bg-orange-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Sign In</a>
                    @endauth
                </div>

                {{-- BURGER MOBILE (TETAP) --}}
                <button @click="mobileMenu = !mobileMenu" class="text-gray-700 md:hidden">
                    <i x-show="!mobileMenu" class="fas fa-bars text-2xl"></i>
                    <i x-show="mobileMenu" class="fas fa-times text-2xl"></i>
                </button>
            </div>

            {{-- MOBILE MENU --}}
            <div x-show="mobileMenu" x-transition class="md:hidden pb-4 space-y-2 px-4 border-t border-gray-200 pt-4">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-home mr-2"></i> Beranda
                </a>
                <a href="{{ route('campaigns.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-bullhorn mr-2"></i> Campaign
                </a>
                <hr class="my-2">

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <a href="{{ route('profile.riwayat') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-history mr-2"></i> Riwayat Donasi
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-[#FF4400] hover:bg-orange-50 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-center w-full px-6 py-2 mt-2 bg-blue-600 text-white rounded-lg">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- LAYOUT DENGAN SIDEBAR --}}
    @php
        $hasSidebar = Request::routeIs('dashboard') ||
                      Request::routeIs('profile.*') ||
                      Request::routeIs('home') ||
                      Request::routeIs('campaigns.index');
    @endphp

    @if($hasSidebar)
        <div class="flex min-h-[calc(100vh-64px)]">

            {{-- SIDEBAR: HEADER DIPINDAHKAN BUTTON BURGER + LOGO --}}
            <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
                   class="bg-white border-r border-gray-200 text-gray-800 transition-all duration-300 flex flex-col shadow-lg flex-shrink-0 hidden md:flex">

                {{-- === HEADER BARU (TOMBOL BURGER + LOGO) === --}}
                <div class="h-16 flex items-center px-4 border-b border-gray-200">
                    {{-- Tombol Toggle Sidebar
                        - toggle sidebarOpen
                        - simpan ke localStorage supaya bertahan saat pindah halaman
                    --}}
                    <button @click="sidebarOpen = !sidebarOpen; localStorage.setItem('sidebarOpen', sidebarOpen)" class="text-gray-700 p-2 rounded-full hover:bg-gray-100">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>

                    {{-- Logo (hanya muncul jika sidebarOpen) --}}
                    <a href="{{ route('home') }}" x-show="sidebarOpen" class="flex items-center space-x-2 ml-3">
                        <img src="{{ asset('Logo.svg') }}" class="h-8 w-auto" alt="Logo TitipanHati">
                    </a>
                </div>
                {{-- === END HEADER BARU === --}}

                {{-- NAVIGASI --}}
                <nav class="mt-4 flex-1 overflow-y-auto px-2">
                    <a href="{{ route('home') }}"
                       class="flex items-center px-3 py-3 rounded-xl transition
                       {{ request()->routeIs('home') ? 'bg-[#FF4400] text-white' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-home w-6 text-center"></i>
                        <span x-show="sidebarOpen" class="ml-3">Beranda</span>
                    </a>

                    <a href="{{ route('campaigns.index') }}"
                       class="flex items-center mt-1 px-3 py-3 rounded-xl transition
                       {{ request()->routeIs('campaigns.index') ? 'bg-[#FF4400] text-white' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-bullhorn w-6 text-center"></i>
                        <span x-show="sidebarOpen" class="ml-3">Campaign</span>
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center mt-1 px-3 py-3 rounded-xl transition
                           {{ request()->routeIs('dashboard') ? 'bg-[#FF4400] text-white' : 'hover:bg-gray-100' }}">
                            <i class="fas fa-tachometer-alt w-6 text-center"></i>
                            <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                        </a>

                        <a href="{{ route('profile.index') }}"
                           class="flex items-center mt-1 px-3 py-3 rounded-xl transition
                           {{ request()->routeIs('profile.index') ? 'bg-[#FF4400] text-white' : 'hover:bg-gray-100' }}">
                            <i class="fas fa-user w-6 text-center"></i>
                            <span x-show="sidebarOpen" class="ml-3">Profil</span>
                        </a>

                        <a href="{{ route('profile.riwayat') }}"
                           class="flex items-center mt-1 px-3 py-3 rounded-xl transition
                           {{ request()->routeIs('profile.riwayat') ? 'bg-[#FF4400] text-white' : 'hover:bg-gray-100' }}">
                            <i class="fas fa-history w-6 text-center"></i>
                            <span x-show="sidebarOpen" class="ml-3">Riwayat Donasi</span>
                        </a>
                    @endauth
                </nav>

                {{-- FOOTER --}}
                @auth
                <div class="p-4 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-3 rounded-xl text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt w-6 text-center"></i>
                            <span x-show="sidebarOpen" class="ml-3">Logout</span>
                        </button>
                    </form>
                </div>
                @endauth

            </aside>

            {{-- MAIN CONTENT --}}
            <div class="flex-1 overflow-y-auto">
                <main class="pt-4 md:pt-8 pb-4 md:pb-8 px-4 md:px-6 lg:px-8">
                    @yield('content')
                </main>
            </div>
        </div>

    @else
        <main>
            @yield('content')
        </main>
    @endif

</div>
@stack('scripts')
</body>
</html>
