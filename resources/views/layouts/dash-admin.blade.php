<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - TitipanHati')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <div class="flex h-screen">
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-white border-r border-gray-200 text-gray-800 transition-all duration-300 flex flex-col shadow-lg">

            <div class="p-4 flex-shrink-0 border-b border-gray-200 h-16 flex items-center"
                :class="sidebarOpen ? 'justify-start space-x-3' : 'justify-center'">

                <button @click="toggleSidebar()" x-show="sidebarOpen"
                    class="p-2 text-primary rounded-full hover:bg-gray-100 transition focus:outline-none -ml-2">
                    <i class="fas fa-arrow-left text-xl"></i>
                </button>

                <a href="{{ route('home') }}" class="flex items-center">
                    <img x-show="sidebarOpen" src="{{ asset('Logo.svg') }}" alt="Logo TitipanHati"
                        class="h-full max-h-8 w-auto">
                </a>

                <button @click="toggleSidebar()" x-show="!sidebarOpen"
                    class="p-2 text-primary rounded-full hover:bg-gray-100 transition focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <nav class="mt-4 flex-1 overflow-y-auto px-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition 
                   {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-home w-6 text-center"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.campaigns.index') }}"
                    class="flex items-center mt-1 px-3 py-3 rounded-xl transition
                   {{ request()->routeIs('admin.campaigns.*') ? 'bg-primary text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-bullhorn w-6 text-center"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Campaign</span>
                </a>

                <a href="{{ route('admin.donations.index') }}"
                    class="flex items-center mt-1 px-3 py-3 rounded-xl transition 
                   {{ request()->routeIs('admin.donations.index') || request()->routeIs('admin.donations.show') ? 'bg-primary text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-box w-6 text-center"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Donasi</span>
                </a>

                <a href="{{ route('admin.donations.calendar') }}"
                    class="flex items-center mt-1 px-3 py-3 rounded-xl transition 
                   {{ request()->routeIs('admin.donations.calendar') ? 'bg-primary text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-calendar w-6 text-center"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Kalender</span>
                </a>
            </nav>

            <div class="p-4 flex-shrink-0 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-3 py-3 rounded-xl text-[#FF4400] hover:bg-orange-50 hover:text-[#EB3F00] transition">
                        <i class="fas fa-sign-out-alt w-6 text-center"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow sticky top-0 z-10 border-b border-gray-200">
                <div class="px-6 h-16 flex items-center justify-end">
                    <div x-data="{ userMenu: false }" class="relative">
                        <button @click="userMenu = !userMenu" @click.away="userMenu = false"
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div
                                class="w-8 h-8 rounded-full bg-[#FF4400] flex items-center justify-center text-white font-semibold">
                                {{ substr(Auth::user()->profile->full_name ?? Auth::user()->email, 0, 1) }}
                            </div>
                            <span
                                class="text-gray-700 font-medium hidden sm:inline">{{ Auth::user()->profile->full_name ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down text-sm text-gray-500" :class="{'rotate-180': userMenu}"></i>
                        </button>

                        <div x-show="userMenu" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2">

                            <a href="{{ route('home') }}"
                                class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-home mr-3 text-[#FF4400]"></i>
                                <span class="font-medium">Lihat Website</span>
                            </a>

                            <hr class="my-2 border-gray-100">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    <span class="font-medium">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="m-6" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <div
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="m-6" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(session('deleted'))
                <div class="m-6" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
                        <span class="block sm:inline">{{ session('deleted') }}</span>
                    </div>
                </div>
            @endif

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>