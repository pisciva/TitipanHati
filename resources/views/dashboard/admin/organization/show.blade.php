@extends('layouts.dash-admin')

@section('title', 'Detail Organisasi: ' . $organization->name)

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-[#1D1D1D]">Detail Organisasi</h1>
        
        <div class="flex space-x-3">
            
            <a href="{{ route('admin.organizations.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>

            <a href="{{ route('admin.organizations.edit', $organization->id) }}" class="bg-[#FF4400] text-white px-4 py-2 rounded-lg hover:bg-[#EB3F00] transition flex items-center shadow-md">
                <i class="fas fa-edit mr-2"></i> Edit Organisasi
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-8 space-y-8"> 

        <div class="border-b pb-6 space-y-6">
            <div class="flex flex-col items-center">
                <h3 class="text-xl font-semibold mb-4 text-[#FF4400]">Logo Organisasi</h3>
                <img class="h-40 w-40 object-cover rounded-full shadow-xl border-4 border-gray-100"
                     src="{{ $organization->logo_url ? Storage::url($organization->logo_url) : asset('path/to/default/logo.png') }}"
                     alt="{{ $organization->name }} Logo">
            </div>

            <div class="text-center p-4 border rounded-xl shadow-sm max-w-sm mx-auto">
                <h4 class="text-lg font-medium text-gray-700 mb-2">Status Verifikasi</h4>
                @if ($organization->is_verified)
                    <span class="px-4 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-2 mt-0.5"></i> Terverifikasi
                    </span>
                @else
                    <span class="px-4 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-2 mt-0.5"></i> Belum Terverifikasi
                    </span>
                @endif
            </div>
        </div>

        <div>
            <h3 class="text-xl font-semibold border-b pb-2 text-[#FF4400] mb-4"><i class="fas fa-info-circle mr-2"></i> Informasi Dasar</h3>
            
            <div class="space-y-4">

                <div class="flex items-start">
                    <i class="fas fa-building w-5 h-5 text-gray-500 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nama Organisasi</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $organization->name }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <i class="fas fa-id-card w-5 h-5 text-gray-500 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">ID Sistem</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $organization->id }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <i class="fas fa-calendar-alt w-5 h-5 text-gray-500 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dibuat Pada</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $organization->created_at->translatedFormat('d F Y (H:i)') }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <i class="fas fa-clock w-5 h-5 text-gray-500 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Terakhir Diperbarui</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $organization->updated_at->translatedFormat('d F Y (H:i)') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-semibold border-b pb-2 text-[#FF4400] mb-4"><i class="fas fa-file-alt mr-2"></i> Deskripsi</h3>
            <p class="text-gray-700 bg-gray-50 p-4 rounded-lg italic border">
                {{ $organization->description ?? 'Tidak ada deskripsi yang tersedia.' }}
            </p>
        </div>

        <div>
            <h3 class="text-xl font-semibold border-b pb-2 text-[#FF4400] mb-4"><i class="fas fa-map-marker-alt mr-2"></i> Kontak & Lokasi</h3>
            
            <div class="space-y-4">

                <div class="flex items-start">
                    <i class="fas fa-envelope w-5 h-5 text-gray-500 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email Kontak</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $organization->contact_email }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <i class="fas fa-phone w-5 h-5 text-gray-500 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nomor Telepon</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $organization->contact_phone ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <i class="fas fa-map-marked-alt w-5 h-5 text-gray-500 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Alamat Lengkap</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $organization->address }}</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="p-6 border border-gray-200 rounded-xl shadow-lg mt-8">
            
            <div class="space-y-3">

                <form action="{{ route('admin.organizations.verify', $organization->id) }}" method="POST" class="w-full"
                      onsubmit="return confirm('Apakah Anda yakin ingin MENGUBAH status verifikasi organisasi ini?');">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="w-full py-2 rounded-lg transition text-white font-semibold flex items-center justify-center
                        {{ $organization->is_verified ? 'bg-[#FF4400] hover:bg-[#EB3F00]' : 'bg-purple-600 hover:bg-purple-700' }}">
                        @if ($organization->is_verified)
                            <i class="fas fa-times-circle mr-2"></i> Batalkan Verifikasi Organisasi
                        @else
                            <i class="fas fa-check-circle mr-2"></i> Verifikasi Organisasi Sekarang
                        @endif
                    </button>
                </form>

                <form action="{{ route('admin.organizations.destroy', $organization->id) }}" method="POST" class="w-full"
                      onsubmit="return confirm('PERINGATAN! Apakah Anda yakin ingin menghapus organisasi {{ $organization->name }}? Ini akan menghapus semua data terkait dan TIDAK dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 bg-gray-200 text-[#EB3F00] font-semibold rounded-lg hover:bg-gray-300 transition flex items-center justify-center">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus Permanen Organisasi
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection