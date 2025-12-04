@extends('layouts.app')

@section('content')
<div class="w-full flex">

    <!-- Sidebar kiri -->
    <div class="w-1/4 border-r min-h-screen p-8 flex flex-col justify-between">

        <!-- Bagian atas -->
        <div>
            <div class="flex flex-col items-center mt-10">
                <div class="w-28 h-28 rounded-full bg-gray-200 mb-4"></div>

                <h2 class="text-xl font-semibold text-[#1d1d1d]">Profil Pengguna</h2>
                <p class="text-gray-500 text-base mt-1">{{ Auth::user()->email }}</p>
            </div>

        <div class="w-full flex justify-center mt-16">
            <div class="space-y-4">
                <a href="#" class="flex items-center gap-3 text-orange-600 font-semibold text-lg">
                    <span class="w-6 flex justify-center">
                        <i class="fa-solid fa-user text-[20px] leading-none"></i>
                    </span>
                    <span>Profil</span>
                </a>

                <a href="{{ route('profile.riwayat') }}" class="flex items-center gap-3 text-gray-500 text-lg hover:text-black">
                    <span class="w-6 flex justify-center">
                        <i class="fa-solid fa-clock-rotate-left text-[20px] leading-none"></i>
                    </span>
                    <span>Riwayat</span>
                </a>
            </div>
        </div>
    </div>

        <!-- Bagian bawah (Logout) -->
        <div class="mt-10 flex justify-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="px-4 py-2 w-40 border border-orange-500 text-orange-500 rounded-2xl hover:bg-orange-50">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>

    <!-- Konten kanan -->
    <div class="w-3/4 p-10">
        {{-- FLASH MESSAGE GLOBAL (Update Profil & Password) --}}
        @if(session('success'))
            <div class="fixed bottom-6 right-6 bg-[#E6F9EC] border border-[#A8E4B8] text-[#1D7A41] px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-fade-in">

                <!-- Icon hijau dalam lingkaran -->
                <div class="w-6 h-6 rounded-full bg-[#1D7A41] flex items-center justify-center">
                    <i class="fa-solid fa-check text-white text-sm"></i>
                </div>

                <!-- Text -->
                <span class="font-medium">
                    {{ session('success') }}
                </span>
            </div>

            <!-- Animasi fade-in -->
            <style>
                @keyframes fade-in {
                    from { opacity: 0; transform: translateY(8px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-fade-in { animation: fade-in .4s ease-out; }
            </style>
        @endif


        {{-- FORM UPDATE PROFIL --}}
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Informasi Pribadi -->
            <div class="border p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-4 text-[#1D1D1D]">Informasi Pribadi</h3>

                <label class="block mb-2 text-sm font-regular text-[#FF4400]">Nama Lengkap</label>
                <input type="text" name="full_name" value="{{ $profile->full_name ?? '' }}"
                       class="w-full p-3 border rounded-2xl"
                       placeholder="Masukkan Nama Depan Kamu">

                <label class="block mt-4 mb-2 text-sm font-regular text-[#FF4400]">Nomor Telepon</label>
                <input type="text" name="phone_number" value="{{ $profile->phone_number ?? '' }}"
                       class="w-full p-3 border rounded-2xl"
                       placeholder="(62) Nomor Telepon Anda">

                <label class="block mt-4 mb-2 text-sm font-regular text-[#FF4400]">Alamat Email</label>
                <input disabled
                       class="w-full p-3 border rounded-2xl bg-gray-100 text-gray-500"
                       value="{{ Auth::user()->email }}">
            </div>

            <!-- Alamat Default -->
            <div class="border p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-4 text-[#1D1D1D]">Alamat Default</h3>

                <label class="block mb-2 text-sm font-regular text-[#FF4400]">Alamat Lengkap</label>
                <input type="text" name="default_address" value="{{ $profile->default_address ?? '' }}"
                       class="w-full p-3 border rounded-2xl"
                       placeholder="Masukkan Alamat Default Kamu">

                <div class="grid grid-cols-3 gap-4 mt-4">

                    <div>
                        <label class="block mb-2 text-sm font-regular text-[#FF4400]">Kota</label>
                        <input type="text" name="default_city" value="{{ $profile->default_city ?? '' }}"
                               class="w-full p-3 border rounded-2xl">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-regular text-[#FF4400]">Kecamatan</label>
                        <input type="text" name="default_district" value="{{ $profile->default_district ?? '' }}"
                               class="w-full p-3 border rounded-2xl">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-regular text-[#FF4400]">Kode Pos</label>
                        <input type="text" name="default_postal_code" value="{{ $profile->default_postal_code ?? '' }}"
                               class="w-full p-3 border rounded-2xl">
                    </div>

                </div>
            </div>

            <button class="px-8 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600">
                Simpan
            </button>
        </form>

        <!-- Ubah Password -->
        <form action="{{ route('profile.password') }}" method="POST" class="mt-12">
            @csrf

            <div class="border p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-4 text-[#1D1D1D]">Ubah Password</h3>

                <label class="block mb-2 text-sm font-regular text-[#FF4400]">Password Lama</label>
                <input type="password" name="current_password"
                       class="w-full p-3 border rounded-2xl"
                       placeholder="Masukkan Password Lama">

                <label class="block mt-4 mb-2 text-sm font-regular text-[#FF4400]">Password Baru</label>
                <input type="password" name="password"
                       class="w-full p-3 border rounded-2xl"
                       placeholder="Masukkan Password Baru">

                <label class="block mt-4 mb-2 text-sm font-regular text-[#FF4400]">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                       class="w-full p-3 border rounded-2xl"
                       placeholder="Konfirmasi Password Baru">
            </div>

            <button class="mt-4 px-8 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600">
                Ubah Password
            </button>
        </form>

    </div>

</div>
@endsection
