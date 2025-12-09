@extends('layouts.auth')

@section('title', 'Login - TitipanHati')

@section('content')
    <div class="flex min-h-screen p-6">

        <div class="w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-lg space-y-12">
                <a href="/">
                    <img src="/images/logo-titiphanhati-lightmode.svg" alt="">
                </a>

                <div>
                    <div class="text-3xl font-bold text-[#1D1D1D]">
                        <h2 class="">Halo,</h2>
                        <h2 class="">Selamat Datang Kembali!</h2>
                    </div>


                    <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm" novalidate>
                        @csrf


                        <div>
                            <label for="email" class="block text-sm font-semibold text-[#FF4400] mb-1">
                                Email
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="Masukkan email kamu"
                                class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-[#E50000] @enderror">


                            @error('email')
                                <p class="mt-1 text-xs font-medium text-[#E50000]">{{ $message }}</p>
                            @enderror


                            <p id="emailError" class="mt-1 text-xs font-medium text-[#E50000] hidden"></p>
                        </div>


                        <div>
                            <label for="password" class="block text-sm font-semibold text-[#FF4400] mb-1">
                                Kata Sandi
                            </label>
                            <input type="password" name="password" id="password" placeholder="Masukkan Kata Sandi kamu"
                                class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-[#E50000] @enderror">


                            @error('password')
                                <p class="mt-1 text-xs font-medium text-[#E50000]">{{ $message }}</p>
                            @enderror


                            <p id="passwordError" class="mt-1 text-xs font-medium text-[#E50000] hidden"></p>
                        </div>


                        <div class="flex items-center justify-between">
                            <a href="{{ route('password.request') }}"
                                class="text-xs font-semibold text-[#626262] hover:text-[#FF4400] underline">
                                Lupa Password?
                            </a>

                            <div class="text-sm">
                                <span class="text-xs font-semibold text-[#626262]">Belum memiliki akun?</span>
                                <a href="{{ route('register') }}" class="text-xs font-semibold text-[#FF4400] underline">
                                    Sign Up
                                </a>
                            </div>
                        </div>


                        <button type="submit"
                            class="w-full py-3 px-4 bg-[#FF4400] hover:bg-[#DE3B00] text-white font-semibold rounded-full">
                            Sign in
                        </button>
                    </form>


                    <div class="mt-3">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-xs">
                                <span class="px-3 bg-white text-gray-500">atau masuk dengan</span>
                            </div>
                        </div>


                        <div class="mt-3">
                            <a href="{{ route('auth.google') }}"
                                class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335"
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                <span class="text-[#343641] font-bold text-sm">Google</span>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="mt-6 ">
                    <a href="{{ url('/') }}" class="text-sm text-[#FF4400] font-bold flex gap-2">
                        <img src="/images/back.svg" class="w-4" alt="">
                        Kembali
                    </a>
                </div>
            </div>
        </div>


        <div class="w-1/2 relative bg-gradient-to-br from-blue-500 to-blue-700 rounded-3xl">

            <div class="absolute inset-0 bg-cover bg-center rounded-3xl">
                <img src="/images/right-bg-auth.svg" class="rounded-3xl" alt="">
            </div>


            <div class="relative h-full flex flex-col items-center justify-center text-white p-12 rounded-3xl">
                <div class="flex flex-col gap-2 text-center items-center justify-center italic">
                    <p class="text-sm ">"Kebaikan sekecil apa pun yang kita berikan, bisa jadi sebesar harapan bagi orang
                        lain!"</p>
                    <img src="/images/logo-titiphanhati-darkmode.svg" alt="">
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {

            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            emailError.classList.add('hidden');
            passwordError.classList.add('hidden');
            emailInput.classList.remove('border-[#E50000]');
            passwordInput.classList.remove('border-[#E50000]');

            let isValid = true;


            const email = emailInput.value.trim();
            if (email === '') {
                emailError.textContent = 'Email harus diisi';
                emailError.classList.remove('hidden');
                emailInput.classList.add('border-[#E50000]');
                isValid = false;
            } else {

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    emailError.textContent = 'Format email tidak valid';
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('border-[#E50000]');
                    isValid = false;
                }
            }


            const password = passwordInput.value;
            if (password === '') {
                passwordError.textContent = 'Kata sandi harus diisi';
                passwordError.classList.remove('hidden');
                passwordInput.classList.add('border-[#E50000]');
                isValid = false;
            } else if (password.length < 6) {
                passwordError.textContent = 'Kata sandi minimal 6 karakter';
                passwordError.classList.remove('hidden');
                passwordInput.classList.add('border-[#E50000]');
                isValid = false;
            }


            if (!isValid) {
                e.preventDefault();
            }
        });


        document.getElementById('email').addEventListener('input', function () {
            const emailError = document.getElementById('emailError');
            if (!emailError.classList.contains('hidden')) {
                emailError.classList.add('hidden');
                this.classList.remove('border-[#E50000]');
            }
        });

        document.getElementById('password').addEventListener('input', function () {
            const passwordError = document.getElementById('passwordError');
            if (!passwordError.classList.contains('hidden')) {
                passwordError.classList.add('hidden');
                this.classList.remove('border-[#E50000]');
            }
        });
    </script>
@endsection