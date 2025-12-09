@extends('layouts.app')

@section('content')
{{-- Kontainer utama diubah menjadi flex-col di mobile, dan flex-row di layar medium ke atas --}}
<div class="w-full flex flex-col md:flex-row">

    {{-- Lebar diubah: W-full di mobile, W-3/4 di medium ke atas --}}
    <div class="w-full md:w-full p-4 md:p-10">
        
        {{-- Navigasi Mobile (Muncul hanya di mobile) --}}
        <div class="md:hidden mb-6 border-b pb-4">
            <h3 class="text-xl font-bold mb-3">Menu Akun</h3>
        </div>

        {{-- FLASH MESSAGE GLOBAL (Update Profil & Password) --}}
        @if(session('success'))
            <div id="flash-message" class="fixed bottom-6 right-6 bg-[#E6F9EC] border border-[#A8E4B8] text-[#1D7A41] px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 opacity-0 transition-opacity duration-300 z-50">

                <div class="w-6 h-6 rounded-full bg-[#1D7A41] flex items-center justify-center">
                    <i class="fa-solid fa-check text-white text-sm"></i>
                </div>

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
            @method('PUT') 

            <div class="border p-4 md:p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-6 text-[#1D1D1D]">Informasi Pribadi</h3>

                <div class="mb-4">
                    <label for="full_name" class="block mb-2 text-sm font-regular text-[#FF4400]">Nama Lengkap</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}"
                        class="w-full p-3 border rounded-2xl @error('full_name') border-red-500 @enderror"
                        placeholder="Masukkan Nama Lengkap Kamu">
                    @error('full_name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block mb-2 text-sm font-regular text-[#FF4400]">Nomor Telepon</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $profile->phone_number ?? '') }}"
                        class="w-full p-3 border rounded-2xl @error('phone_number') border-red-500 @enderror"
                        placeholder="(62) Nomor Telepon Anda">
                    @error('phone_number')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-regular text-[#FF4400]">Alamat Email</label>
                    <input disabled
                           class="w-full p-3 border rounded-2xl bg-gray-100 text-gray-500"
                           value="{{ Auth::user()->email }}">
                </div>
            </div>

            <div class="border p-4 md:p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-6 text-[#1D1D1D]">Alamat Default</h3>

                <div class="mb-4">
                    <label for="default_address" class="block mb-2 text-sm font-regular text-[#FF4400]">Alamat Lengkap</label>
                    <input type="text" id="default_address" name="default_address" value="{{ old('default_address', $profile->default_address ?? '') }}"
                        class="w-full p-3 border rounded-2xl @error('default_address') border-red-500 @enderror"
                        placeholder="Masukkan Alamat Default Kamu">
                    @error('default_address')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Grid diubah menjadi grid-cols-1 di mobile, dan grid-cols-3 di medium ke atas --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="default_province" class="block mb-2 text-sm font-regular text-[#FF4400]">Kota</label>
                        <input type="text" id="default_province" name="default_province" value="{{ old('default_province', $profile->default_province ?? '') }}"
                               class="w-full p-3 border rounded-2xl @error('default_province') border-red-500 @enderror">
                        @error('default_province')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="default_city" class="block mb-2 text-sm font-regular text-[#FF4400]">Kecamatan</label>
                        <input type="text" id="default_city" name="default_city" value="{{ old('default_city', $profile->default_city ?? '') }}"
                               class="w-full p-3 border rounded-2xl @error('default_city') border-red-500 @enderror">
                        @error('default_city')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

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

        <form action="{{ route('profile.password') }}" method="POST" class="mt-12">
            @csrf
            @method('PUT') 

            <div class="border p-4 md:p-6 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold mb-6 text-[#1D1D1D]">Ubah Password</h3>

                <div class="mb-4">
                    <label for="current_password" class="block mb-2 text-sm font-regular text-[#FF4400]">Password Lama</label>
                    <input type="password" id="current_password" name="current_password"
                           class="w-full p-3 border rounded-2xl @error('current_password') border-red-500 @enderror"
                           placeholder="Masukkan Password Lama">
                    @error('current_password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-regular text-[#FF4400]">Password Baru</label>
                    <input type="password" id="password" name="password"
                           class="w-full p-3 border rounded-2xl @error('password') border-red-500 @enderror"
                           placeholder="Masukkan Password Baru">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

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

        {{-- Tombol Logout Mobile (Muncul hanya di mobile, di bawah konten) --}}
        <div class="mt-12 md:hidden flex justify-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 w-40 border border-orange-500 text-orange-500 rounded-2xl hover:bg-orange-50 transition">
                    Keluar Akun
                </button>
            </form>
        </div>

    </div>

</div>
@endsection