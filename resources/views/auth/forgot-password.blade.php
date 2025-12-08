@extends('layouts.auth')

@section('title', 'Lupa Password - TitipanHati')

@section('content')
    <div class="flex min-h-screen p-6 items-center justify-center bg-white">
        <div class="w-full max-w-lg space-y-16">
            {{-- Logo --}}
            <div class="flex justify-center">
                <img src="/images/logo-titiphanhati-lightmode.svg" alt="TitipanHati Logo" class="w-40">
            </div>

            {{-- Content Container --}}
            <div class="space-y-8 border border-[#D3D3D3] p-12 rounded-3xl">
                {{-- Header --}}
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-[#1D1D1D] mb-2">Lupa Kata Sandi</h2>
                    <p class="text-sm text-[#626262]">
                        Jangan khawatir, kami akan membantu Anda mengatur ulang kata sandi!
                    </p>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" novalidate>
                    @csrf

                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-[#FF4400] mb-1">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="Masukkan email kamu"
                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-[#E50000] @enderror">
                        
                        {{-- Backend Error --}}
                        @error('email')
                            <p class="mt-1 text-xs font-medium text-[#E50000]">{{ $message }}</p>
                        @enderror
                        
                        {{-- Frontend Error --}}
                        <p id="emailError" class="mt-1 text-xs font-medium text-[#E50000] hidden"></p>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full mt-6 py-3 px-4 bg-[#FF4400] hover:bg-[#DE3B00] text-white font-semibold rounded-full">
                        Kirim Link Reset Password
                    </button>
                </form>
            </div>

            {{-- Back Link --}}
            <div class="mt-6">
                <a href="{{ route('login') }}" class="text-sm text-[#FF4400] font-bold flex gap-2">
                    <img src="/images/back.svg" class="w-4" alt="">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- JavaScript Validation --}}
    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            const emailError = document.getElementById('emailError');
            const emailInput = document.getElementById('email');
            
            emailError.classList.add('hidden');
            emailInput.classList.remove('border-[#E50000]');
            
            let isValid = true;
            
            // Validasi Email
            const email = emailInput.value.trim();
            if (email === '') {
                emailError.textContent = 'Email harus diisi';
                emailError.classList.remove('hidden');
                emailInput.classList.add('border-[#E50000]');
                isValid = false;
            } else {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    emailError.textContent = 'Alamat email tidak valid';
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('border-[#E50000]');
                    isValid = false;
                }
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        document.getElementById('email').addEventListener('input', function() {
            const emailError = document.getElementById('emailError');
            if (!emailError.classList.contains('hidden')) {
                emailError.classList.add('hidden');
                this.classList.remove('border-[#E50000]');
            }
        });
    </script>
@endsection