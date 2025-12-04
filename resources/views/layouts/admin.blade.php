{{-- ============================================ --}}
{{-- 2. resources/views/layouts/admin.blade.php --}}
{{-- Admin Layout --}}
{{-- ============================================ --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - TitipanHati')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-gray-800 text-white transition-all duration-300">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <h2 x-show="sidebarOpen" class="text-xl font-bold">Admin Panel</h2>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white">
                        <i class="fas" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>

            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('admin.campaigns.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 transition {{ request()->routeIs('admin.campaigns.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-bullhorn w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Campaign</span>
                </a>
                <a href="{{ route('admin.donations.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 transition {{ request()->routeIs('admin.donations.index') || request()->routeIs('admin.donations.show') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-box w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Donasi</span>
                </a>
                <a href="{{ route('admin.donations.calendar') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 transition {{ request()->routeIs('admin.donations.calendar') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-calendar w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Kalender</span>
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 overflow-auto">
            {{-- Header --}}
            <header class="bg-white shadow">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                    
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700">
                            <i class="fas fa-user-circle text-2xl"></i>
                            <span>{{ Auth::user()->profile->full_name ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-home mr-2"></i> Lihat Website
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="m-6">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="m-6">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Content --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>