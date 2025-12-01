@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-xl p-6">

    <h2 class="text-2xl font-bold mb-6">Profil Saya</h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- USER INFO --}}
    <div class="mb-8">
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        <p><strong>Google Account:</strong> {{ $user->google_id ? 'Ya' : 'Tidak' }}</p>
    </div>

    <hr class="my-6">

    {{-- PROFILE FORM --}}
    <h3 class="text-xl font-semibold mb-4">Informasi Profil</h3>

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Nama Lengkap</label>
            <input type="text" name="full_name" class="w-full border rounded-lg p-2"
                   value="{{ old('full_name', $profile->full_name ?? '') }}" required>
        </div>

        <div>
            <label class="block font-medium">Nomor Telepon</label>
            <input type="text" name="phone_number" class="w-full border rounded-lg p-2"
                   value="{{ old('phone_number', $profile->phone_number ?? '') }}" required>
        </div>

        <div>
            <label class="block font-medium">Alamat</label>
            <textarea name="default_address" class="w-full border rounded-lg p-2">{{ old('default_address', $profile->default_address ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-medium">Kota</label>
                <input type="text" name="default_city" class="w-full border rounded-lg p-2"
                       value="{{ old('default_city', $profile->default_city ?? '') }}">
            </div>

            <div>
                <label class="block font-medium">Kecamatan</label>
                <input type="text" name="default_district" class="w-full border rounded-lg p-2"
                       value="{{ old('default_district', $profile->default_district ?? '') }}">
            </div>

            <div>
                <label class="block font-medium">Kode Pos</label>
                <input type="text" name="default_postal_code" class="w-full border rounded-lg p-2"
                       value="{{ old('default_postal_code', $profile->default_postal_code ?? '') }}">
            </div>
        </div>

        <div>
            <label class="block font-medium">Catatan</label>
            <textarea name="default_notes" class="w-full border rounded-lg p-2">{{ old('default_notes', $profile->default_notes ?? '') }}</textarea>
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Simpan Perubahan
        </button>
    </form>

    <hr class="my-10">

    {{-- CHANGE PASSWORD --}}
    <h3 class="text-xl font-semibold mb-4">Ganti Password</h3>

    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Password Saat Ini</label>
            <input type="password" name="current_password" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block font-medium">Password Baru</label>
            <input type="password" name="password" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block font-medium">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="w-full border rounded-lg p-2" required>
        </div>

        <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
            Ubah Password
        </button>
    </form>

</div>
@endsection
