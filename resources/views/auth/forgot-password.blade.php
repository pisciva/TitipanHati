@extends('layouts.app')

@section('title', 'Lupa Password - TitipanHati')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        {{-- Header --}}
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">
                Lupa Password?
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Masukkan email Anda dan kami akan mengirimkan link reset password
            </p>
        </div>

        {{-- Form --}}
        <div class="bg-white shadow-lg rounded-lg p-8">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input type="email" name="email" id="email" required
                           value="{{ old('email') }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Kirim Link Reset Password
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection