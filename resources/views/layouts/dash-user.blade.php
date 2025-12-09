<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dashboard - TitipanHati') }} - @yield('title')</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#FF4400',
                        'primary-dark': '#EB3F00',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>

<body class="bg-gray-100" x-data="{
    sidebarOpen: localStorage.getItem('sidebarOpen') === 'false' ? false : true,
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
    }
}">
    @php
        $hasSidebar = in_array(request()->route()?->getName(), [
            'dashboard',
            'profile.index',
            'donations.history'
        ]);
    @endphp

    @if($hasSidebar)
        <div class="flex h-screen">
            {{-- SIDEBAR --}}
            <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
                class="bg-white border-r border-gray-200 text-gray-800 transition-all duration-300 flex flex-col shadow-lg">

                {{-- Sidebar Header --}}
                <div class="p-4 flex-shrink-0 border-b border-gray-200 h-16 flex items-center"
                    :class="sidebarOpen ? 'justify-start space-x-3' : 'justify-center'">

                    <button @click="toggleSidebar()" x-show="sidebarOpen"
                        class="p-2 text-primary rounded-full hover:bg-gray-100 transition focus:outline-none -ml-2">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </button>

                    <img x-show="sidebarOpen" src="{{ asset('Logo.svg') }}" alt="Logo TitipanHati"
                        class="h-full max-h-8 w-auto">

                    <button @click="toggleSidebar()" x-show="!sidebarOpen"
                        class="p-2 text-primary rounded-full hover:bg-gray-100 transition focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                {{-- Navigation --}}
                <nav class="mt-4 flex-1 overflow-y-auto px-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-3 py-3 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-home w-6 text-center"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('profile.index') }}"
                        class="flex items-center mt-1 px-3 py-3 rounded-xl transition {{ request()->routeIs('profile.index') ? 'bg-primary text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-user w-6 text-center"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Profil</span>
                    </a>

                    <a href="{{ route('donations.history') }}"
                        class="flex items-center mt-1 px-3 py-3 rounded-xl transition {{ request()->routeIs('donations.history') ? 'bg-primary text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-history w-6 text-center"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Riwayat Donasi</span>
                    </a>
                </nav>

                {{-- Sidebar Footer --}}
                @auth
                    <div class="p-4 flex-shrink-0 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-3 py-3 rounded-xl text-[#FF4400] hover:bg-orange-50 hover:text-[#EB3F00] transition">
                                <i class="fas fa-sign-out-alt w-6 text-center"></i>
                                <span x-show="sidebarOpen" class="ml-3 font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                @endauth
            </aside>

            {{-- MAIN CONTENT --}}
            <div class="flex-1 overflow-auto">
                {{-- HEADER --}}
                <header class="bg-white shadow sticky top-0 z-10 border-b border-gray-200">
                    <div class="px-6 h-16 flex items-center justify-end">
                        @auth
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="flex items-center space-x-2 text-gray-700 p-2 rounded-full hover:bg-gray-100 transition">
                                    <i class="fas fa-user-circle text-2xl"></i>
                                    <span class="hidden sm:inline">{{ Auth::user()->profile->full_name ?? 'User' }}</span>
                                    <i class="fas fa-chevron-down text-sm"></i>
                                </button>

                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-20 border border-gray-100">

                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                            <i class="fas fa-tachometer-alt mr-2 w-5"></i> Admin Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('home') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                            <i class="fas fa-home mr-2 w-5"></i> Lihat Website
                                        </a>
                                    @endif
                                    <hr class="my-2 border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-[#FF4400] hover:bg-orange-50 transition">
                                            <i class="fas fa-sign-out-alt mr-2 w-5"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </header>

                {{-- FLASH MESSAGES --}}
                @if(session('success'))
                    <div class="m-6" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                        x-transition:leave.duration.500ms>
                        <div
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="m-6" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                        x-transition:leave.duration.500ms>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                {{-- CONTENT --}}
                <main class="p-6">
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        {{-- LAYOUT TANPA SIDEBAR (misal: home, campaigns) --}}
        <div>
            {{-- NAVBAR --}}

            <nav class="bg-white shadow-md sticky top-0 z-50">
                <div class="container mx-auto px-4">
                    <div class="flex items-center justify-between h-16">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-primary">
                            TitipanHati
                        </a>

                        <div class="flex items-center space-x-4">
                            @auth
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open"
                                        class="flex items-center space-x-2 text-gray-700 hover:text-primary">
                                        <i class="fas fa-user-circle text-2xl"></i>
                                        <span
                                            class="hidden md:inline">{{ Str::limit(Auth::user()->profile->full_name ?? Auth::user()->email, 15) }}</span>
                                        <i class="fas fa-chevron-down text-sm"></i>
                                    </button>

                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                            </a>
                                        @else
                                            <a href="{{ route('dashboard') }}"
                                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
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
                                        <hr class="my-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-primary hover:bg-orange-50">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                                    Sign In
                                </a>
                            @endauth

                            <button @click="mobileMenu = !mobileMenu" class="text-gray-700 md:hidden">
                                <i x-show="!mobileMenu" class="fas fa-bars text-2xl"></i>
                                <i x-show="mobileMenu" class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                    </div>

                    {{-- MOBILE MENU --}}
                    <div x-data="{ mobileMenu: false }" x-show="mobileMenu" x-transition
                        class="md:hidden pb-4 space-y-2 px-4 border-t border-gray-200 pt-4">
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-home mr-2"></i> Beranda
                        </a>
                        <a href="{{ route('campaigns.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-hand-holding-heart mr-2"></i> Campaign
                        </a>
                        <hr class="my-2">
                        @auth
                            @if(Auth::user()->role !== 'admin')
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">
                                    <i class="fas fa-home mr-2"></i> Dashboard
                                </a>
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                <a href="{{ route('donations.history') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">
                                    <i class="fas fa-history mr-2"></i> Riwayat Donasi
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-primary hover:bg-orange-50 rounded-lg mt-2">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="block text-center w-full px-6 py-2 mt-2 bg-blue-600 text-white rounded-lg">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>

            {{-- FLASH MESSAGES --}}
            @if(session('success'))
                <div class="container mx-auto px-4 mt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="container mx-auto px-4 mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- MAIN CONTENT --}}
            <main class="pt-6 pb-8 px-4 md:px-6 lg:px-8">
                @yield('content')
            </main>

            {{-- FOOTER --}}
            <footer class="bg-gray-800 text-white mt-16">
                <div class="container mx-auto px-4 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">
                                <i class="fas fa-hand-holding-heart"></i> TitipanHati
                            </h3>
                            <p class="text-gray-400">Berbagi pakaian, berbagi harapan</p>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-4">Quick Links</h4>
                            <ul class="space-y-2">
                                <li><a href="{{ route('home') }}"
                                        class="text-gray-400 hover:text-white transition">Beranda</a></li>
                                <li><a href="{{ route('campaigns.index') }}"
                                        class="text-gray-400 hover:text-white transition">Campaign</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-4">Kontak</h4>
                            <ul class="space-y-2 text-gray-400">
                                <li><i class="fas fa-envelope mr-2"></i> info@titipanhati.com</li>
                                <li><i class="fab fa-whatsapp mr-2"></i> +62 851-5511-0751</li>
                                <li class="flex space-x-4 mt-4">
                                    <a href="#" class="hover:text-white transition"><i
                                            class="fab fa-facebook text-2xl"></i></a>
                                    <a href="#" class="hover:text-white transition"><i
                                            class="fab fa-instagram text-2xl"></i></a>
                                    <a href="#" class="hover:text-white transition"><i
                                            class="fab fa-twitter text-2xl"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                        <p>&copy; {{ date('Y') }} TitipanHati. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    @endif

    @stack('scripts')
</body>

</html>