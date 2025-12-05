@extends('layouts.app')

@section('content')
<div class="w-full flex">

    <!-- Sidebar kiri -->
    <div class="w-1/4 border-r min-h-screen p-8 flex flex-col justify-between">

        <!-- Bagian atas -->
        <div>
            <div class="flex flex-col items-center mt-10">
                <!-- Placeholder untuk Foto Profil -->
                <div class="w-28 h-28 rounded-full bg-gray-200 mb-4 flex items-center justify-center text-gray-400 text-sm">
                    <!-- Anda bisa menambahkan gambar profil di sini -->
                    <i class="fa-solid fa-camera text-2xl"></i>
                </div>

                <h2 class="text-xl font-semibold text-[#1d1d1d]">Halo, {{ Auth::user()->profile?->full_name ?? Auth::user()->name ?? 'Pengguna' }}</h2>
                <p class="text-gray-500 text-base mt-1">{{ Auth::user()->email }}</p>
            </div>

        <div class="w-full flex justify-center mt-16">
            <div class="space-y-4">
                <!-- Link Baru: Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-gray-500 text-lg hover:text-black">
                    <span class="w-6 flex justify-center">
                        <i class="fa-solid fa-house text-[20px] leading-none"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
                
                <!-- Link Aktif: Profil (tetap aktif karena ini halaman profil) -->
                <a href="#" class="flex items-center gap-3 text-orange-600 font-semibold text-lg">
                    <span class="w-6 flex justify-center">
                        <i class="fa-solid fa-user text-[20px] leading-none"></i>
                    </span>
                    <span>Profil</span>
                </a>

                <!-- Link Non-aktif: Riwayat -->
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
                <button type="submit" class="px-4 py-2 w-40 border border-orange-500 text-orange-500 rounded-2xl hover:bg-orange-50">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>

    <!-- Konten kanan -->
    <div class="w-3/4 p-10">
        {{-- FLASH MESSAGE GLOBAL (Update Profil & Password) --}}
        @if(session('success'))
            <div id="flash-message" class="fixed bottom-6 right-6 bg-[#E6F9EC] border border-[#A8E4B8] text-[#1D7A41] px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 opacity-0 transition-opacity duration-300">

                <!-- Icon hijau dalam lingkaran -->
                <div class="w-6 h-6 rounded-full bg-[#1D7A41] flex items-center justify-center">
                    <i class="fa-solid fa-check text-white text-sm"></i>
                </div>

                <!-- Text -->
                <span class="font-medium">
                    {{ session('success') }}
                </span>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const flashMessage = document.getElementById('flash-message');
                    if (flashMessage) {
                        // Fade in
                        setTimeout(() => flashMessage.classList.remove('opacity-0'), 100);

                        // Fade out and remove after 5 seconds
                        setTimeout(() => {
                            flashMessage.classList.add('opacity-0');
                            setTimeout(() => flashMessage.remove(), 300); // Remove after transition
                        }, 5000);
                    }
                });
            </script>
        @endif


        {{-- FORM UPDATE PROFIL --}}
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT') <!-- Menggunakan metode PUT/PATCH untuk update -->

            <!-- Informasi Pribadi -->
            <div class="border p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-6 text-[#1D1D1D]">Informasi Pribadi</h3>

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label for="full_name" class="block mb-2 text-sm font-regular text-[#FF4400]">Nama Lengkap</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}"
                        class="w-full p-3 border rounded-2xl @error('full_name') border-red-500 @enderror"
                        placeholder="Masukkan Nama Lengkap Kamu">
                    @error('full_name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label for="phone_number" class="block mb-2 text-sm font-regular text-[#FF4400]">Nomor Telepon</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $profile->phone_number ?? '') }}"
                        class="w-full p-3 border rounded-2xl @error('phone_number') border-red-500 @enderror"
                        placeholder="(62) Nomor Telepon Anda">
                    @error('phone_number')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Email (Non-editable) -->
                <div>
                    <label class="block mb-2 text-sm font-regular text-[#FF4400]">Alamat Email</label>
                    <input disabled
                           class="w-full p-3 border rounded-2xl bg-gray-100 text-gray-500"
                           value="{{ Auth::user()->email }}">
                </div>
            </div>

            <!-- Alamat Default -->
            <div class="border p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-6 text-[#1D1D1D]">Alamat Default</h3>

                <!-- Alamat Lengkap -->
                <div class="mb-4">
                    <label for="default_address" class="block mb-2 text-sm font-regular text-[#FF4400]">Alamat Lengkap</label>
                    <input type="text" id="default_address" name="default_address" value="{{ old('default_address', $profile->default_address ?? '') }}"
                        class="w-full p-3 border rounded-2xl @error('default_address') border-red-500 @enderror"
                        placeholder="Masukkan Alamat Default Kamu">
                    @error('default_address')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Kota -->
                    <div>
                        <label for="default_city" class="block mb-2 text-sm font-regular text-[#FF4400]">Kota</label>
                        <input type="text" id="default_city" name="default_city" value="{{ old('default_city', $profile->default_city ?? '') }}"
                               class="w-full p-3 border rounded-2xl @error('default_city') border-red-500 @enderror">
                        @error('default_city')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div>
                        <label for="default_district" class="block mb-2 text-sm font-regular text-[#FF4400]">Kecamatan</label>
                        <input type="text" id="default_district" name="default_district" value="{{ old('default_district', $profile->default_district ?? '') }}"
                               class="w-full p-3 border rounded-2xl @error('default_district') border-red-500 @enderror">
                        @error('default_district')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kode Pos -->
                    <div>
                        <label for="default_postal_code" class="block mb-2 text-sm font-regular text-[#FF4400]">Kode Pos</label>
                        <input type="text" id="default_postal_code" name="default_postal_code" value="{{ old('default_postal_code', $profile->default_postal_code ?? '') }}"
                               class="w-full p-3 border rounded-2xl @error('default_postal_code') border-red-500 @enderror">
                        @error('default_postal_code')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <button type="submit" class="px-8 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition duration-150">
                Simpan
            </button>
        </form>

        <!-- Ubah Password -->
        <form action="{{ route('profile.password') }}" method="POST" class="mt-12">
            @csrf
            @method('PUT') <!-- Menggunakan metode PUT/PATCH untuk update password -->

            <div class="border p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-6 text-[#1D1D1D]">Ubah Password</h3>

                <!-- Password Lama -->
                <div class="mb-4">
                    <label for="current_password" class="block mb-2 text-sm font-regular text-[#FF4400]">Password Lama</label>
                    <input type="password" id="current_password" name="current_password"
                           class="w-full p-3 border rounded-2xl @error('current_password') border-red-500 @enderror"
                           placeholder="Masukkan Password Lama">
                    @error('current_password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Baru -->
                <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-regular text-[#FF4400]">Password Baru</label>
                    <input type="password" id="password" name="password"
                           class="w-full p-3 border rounded-2xl @error('password') border-red-500 @enderror"
                           placeholder="Masukkan Password Baru">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block mb-2 text-sm font-regular text-[#FF4400]">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full p-3 border rounded-2xl"
                           placeholder="Konfirmasi Password Baru">
                </div>
            </div>

            <button type="submit" class="mt-4 px-8 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition duration-150">
                Ubah Password
            </button>
        </form>

    </div>

</div>
@endsection