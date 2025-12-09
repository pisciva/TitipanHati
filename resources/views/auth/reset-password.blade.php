@extends('layouts.auth')

@section('title', 'Reset Password - TitipanHati')

@section('content')
    <div class="flex min-h-screen p-6 items-center justify-center bg-white">
        <div class="w-full max-w-lg space-y-16">

            <div class="flex justify-center">
                <img src="/images/logo-titiphanhati-lightmode.svg" alt="TitipanHati Logo">
            </div>


            <div class="space-y-8 border border-[#D3D3D3] p-12 rounded-3xl">

                <div class="text-center">
                    <h2 class="text-3xl font-bold text-[#1D1D1D] mb-2">Atur Ulang Kata Sandi</h2>
                    <p class="text-sm text-[#626262]">
                        Silakan masukkan kata sandi baru Anda di bawah ini.
                    </p>
                </div>


                <form method="POST" action="{{ route('password.update') }}" class="space-y-5" id="resetPasswordForm" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">


                    <div>
                        <label for="password" class="block text-sm font-semibold text-[#FF4400] mb-1">
                            Kata Sandi Baru
                        </label>
                        <input type="password" name="password" id="password"
                            placeholder="Masukkan kata sandi baru"
                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-[#E50000] @enderror">
                        

                        @error('password')
                            <p class="mt-1 text-xs font-medium text-[#E50000]">{{ $message }}</p>
                        @enderror
                        

                        <p id="passwordError" class="mt-1 text-xs font-medium text-[#E50000] hidden"></p>
                    </div>


                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-[#FF4400] mb-1">
                            Konfirmasi Kata Sandi
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Masukkan ulang kata sandi baru"
                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        

                        <p id="confirmPasswordError" class="mt-1 text-xs font-medium text-[#E50000] hidden"></p>
                    </div>


                    <button type="submit"
                        class="w-full mt-6 py-3 px-4 bg-[#FF4400] hover:bg-[#DE3B00] text-white font-semibold rounded-full">
                        Atur Ulang Kata Sandi
                    </button>
                </form>
            </div>


            <div class="mt-6">
                <a href="{{ route('login') }}" class="text-sm text-[#FF4400] font-bold flex gap-2">
                    <img src="/images/back.svg" class="w-4" alt="">
                    Kembali
                </a>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            passwordError.classList.add('hidden');
            confirmPasswordError.classList.add('hidden');
            passwordInput.classList.remove('border-[#E50000]');
            confirmPasswordInput.classList.remove('border-[#E50000]');
            
            let isValid = true;
            

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
            

            const confirmPassword = confirmPasswordInput.value;
            if (confirmPassword === '') {
                confirmPasswordError.textContent = 'Konfirmasi kata sandi harus diisi';
                confirmPasswordError.classList.remove('hidden');
                confirmPasswordInput.classList.add('border-[#E50000]');
                isValid = false;
            } else if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Konfirmasi kata sandi tidak cocok';
                confirmPasswordError.classList.remove('hidden');
                confirmPasswordInput.classList.add('border-[#E50000]');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        document.getElementById('password').addEventListener('input', function() {
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            if (!passwordError.classList.contains('hidden')) {
                passwordError.classList.add('hidden');
                this.classList.remove('border-[#E50000]');
            }
            
            if (confirmPasswordInput.value !== '') {
                if (this.value === confirmPasswordInput.value) {
                    confirmPasswordError.classList.add('hidden');
                    confirmPasswordInput.classList.remove('border-[#E50000]');
                }
            }
        });
        
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const passwordInput = document.getElementById('password');
            
            if (!confirmPasswordError.classList.contains('hidden')) {
                confirmPasswordError.classList.add('hidden');
                this.classList.remove('border-[#E50000]');
            }
            
            if (this.value !== '' && passwordInput.value !== '') {
                if (this.value === passwordInput.value) {
                    confirmPasswordError.classList.add('hidden');
                    this.classList.remove('border-[#E50000]');
                }
            }
        });
    </script>
@endsection