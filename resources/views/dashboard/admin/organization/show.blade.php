@extends('layouts.dash-admin')

@section('title', 'Detail Organisasi: ' . $organization->name)

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Organisasi</h1>
        
        <div class="flex space-x-3">
            
            <a href="{{ route('admin.organizations.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition flex items-center shadow-sm font-semibold">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>

            <a href="{{ route('admin.organizations.edit', $organization->id) }}" class="bg-[#FF4400] text-white px-5 py-2.5 rounded-xl hover:bg-[#EB3F00] transition flex items-center shadow-md font-semibold">
                <i class="fas fa-edit mr-2"></i> Edit Organisasi
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-4 shadow-sm" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4 shadow-sm" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100 mb-8 space-y-8"> 

        <div class="flex flex-col lg:flex-row lg:items-center justify-between border-b pb-6 space-y-4 lg:space-y-0">
            <div class="flex items-center space-x-6">
                <img class="h-24 w-24 object-cover rounded-full shadow-lg border-4 border-gray-100"
                     src="{{ $organization->logo_url ? Storage::url($organization->logo_url) : asset('path/to/default/logo.png') }}"
                     alt="{{ $organization->name }} Logo">
                
                <div>
                    <h2 class="text-3xl font-bold text-[#1D1D1D]">{{ $organization->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">ID: <span class="font-semibold">{{ $organization->id }}</span></p>
                </div>
            </div>

            @php
                $statusColor = $organization->is_verified ? 'bg-green-50 text-green-800' : 'bg-yellow-50 text-yellow-800';
                $statusIcon = $organization->is_verified ? 'fas fa-check-circle' : 'fas fa-clock';
                $statusText = $organization->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi';
            @endphp
            <div class="py-2 px-4 rounded-xl {{ $statusColor }} text-center self-start lg:self-auto">
                <h4 class="text-sm font-medium text-gray-700 mb-1">Status Verifikasi</h4>
                <span class="inline-flex text-lg leading-5 font-bold">
                    <i class="{{ $statusIcon }} mr-2 mt-0.5"></i> {{ $statusText }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 p-6 bg-gray-50 rounded-xl border border-gray-200">
                <h3 class="text-xl font-semibold text-[#FF4400] mb-4 flex items-center"><i class="fas fa-info-circle mr-2"></i> Informasi Dasar</h3>
                
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between items-center pb-2 border-b">
                        <p class="text-gray-500 font-medium">Email Kontak</p>
                        <p class="font-semibold text-gray-800 text-right">{{ $organization->contact_email }}</p>
                    </div>

                    <div class="flex justify-between items-center pb-2 border-b">
                        <p class="text-gray-500 font-medium">Nomor Telepon</p>
                        <p class="font-semibold text-gray-800 text-right">{{ $organization->contact_phone ?? '-' }}</p>
                    </div>

                    <div class="flex justify-between items-center pb-2 border-b">
                        <p class="text-gray-500 font-medium">Dibuat Pada</p>
                        <p class="font-semibold text-gray-800 text-right">{{ $organization->created_at->translatedFormat('d F Y') }}</p>
                    </div>

                    <div class="flex justify-between items-center">
                        <p class="text-gray-500 font-medium">Terakhir Diperbarui</p>
                        <p class="font-semibold text-gray-800 text-right">{{ $organization->updated_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-xl font-semibold text-[#FF4400] mb-3 flex items-center"><i class="fas fa-file-alt mr-2"></i> Deskripsi Organisasi</h3>
                    <p class="text-gray-700 italic leading-relaxed">
                        {{ $organization->description ?? 'Tidak ada deskripsi yang tersedia.' }}
                    </p>
                </div>
                
                <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-xl font-semibold text-[#FF4400] mb-3 flex items-center"><i class="fas fa-map-marker-alt mr-2"></i> Alamat Lengkap</h3>
                    <p class="text-gray-700 font-medium">
                        {{ $organization->address }}
                    </p>
                </div>
            </div>

        </div>

        <div class="p-6 border border-gray-200 rounded-xl shadow-lg mt-8 bg-white">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-cogs mr-2"></i> Opsi Administrasi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <form action="{{ route('admin.organizations.verify', $organization->id) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin MENGUBAH status verifikasi organisasi ini?');">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="w-full py-3 rounded-xl transition text-white font-bold flex items-center justify-center shadow-md
                        {{ $organization->is_verified ? 'bg-[#FF4400] hover:bg-[#EB3F00]' : 'bg-purple-600 hover:bg-purple-700' }}">
                        @if ($organization->is_verified)
                            <i class="fas fa-times-circle mr-2"></i> Batalkan Verifikasi
                        @else
                            <i class="fas fa-check-circle mr-2"></i> Verifikasi Sekarang
                        @endif
                    </button>
                </form>

                <form action="{{ route('admin.organizations.destroy', $organization->id) }}" method="POST"
                      onsubmit="return confirm('PERINGATAN! Apakah Anda yakin ingin menghapus organisasi {{ $organization->name }}? Ini akan menghapus semua data terkait dan TIDAK dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-red-100 text-red-600 font-bold rounded-xl hover:bg-red-200 transition flex items-center justify-center shadow-sm border border-red-300">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus Permanen
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection