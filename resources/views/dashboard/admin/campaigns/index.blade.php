@extends('layouts.admin')

@section('title', 'Daftar Campaign')

@section('content')

    <!-- Header Section and Create Button -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-semibold text-gray-900">Manajemen Campaign</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua campaign pengumpulan donasi yang terdaftar di sistem.</p>
        </div>
        <a href="{{ route('admin.campaigns.create') }}" 
           class="px-5 py-2.5 bg-[#FF4400] text-white font-semibold rounded-xl hover:bg-[#EB3F00] transition duration-150 shadow-md flex items-center">
            <i class="fas fa-plus mr-2"></i> Buat Campaign Baru
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4" role="alert">
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filtering and Search Form -->
    <div class="bg-white p-6 rounded-2xl shadow-lg mb-6 border border-gray-100">
        <form action="{{ route('admin.campaigns.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            
            {{-- Search Field --}}
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Campaign</label>
                <input type="text" name="search" id="search" placeholder="Judul atau Deskripsi..."
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
            </div>

            {{-- Status Filter --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                <select name="status" id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- Action Buttons --}}
            <div class="flex space-x-2">
                <button type="submit" 
                        class="flex-shrink-0 px-4 py-2 bg-[#FF4400] text-[#F8FAFC] font-medium rounded-xl hover:bg-[#EB3F00] transition duration-150">
                    <i class="fas fa-filter mr-1"></i> Terapkan
                </button>
                <a href="{{ route('admin.campaigns.index') }}" 
                   class="flex-shrink-0 px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-100 transition duration-150">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Campaign List Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($campaigns as $campaign)
                        <tr class="group hover:bg-gray-50 cursor-pointer relative">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.campaigns.show', $campaign->id) }}" class="absolute inset-0"></a>
                                <div class="text-sm font-medium text-gray-900 group-hover:text-[#FF4400] transition">{{ $campaign->title }}</div>
                                <div class="text-xs text-gray-500">{{ $campaign->city }}, {{ $campaign->province }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $campaign->organization->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ number_format($campaign->target_quantity) }} unit
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $campaign->deadline->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = $campaign->status == 'aktif' 
                                        ? 'bg-green-100 text-green-800' 
                                        : 'bg-red-100 text-red-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                            {{-- Kolom Aksi diubah agar elemen di dalamnya memiliki z-index yang lebih tinggi --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative z-10">
                                <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="text-[#FF4400] hover:text-[#EB3F00] mx-2" title="Edit" onclick="event.stopPropagation()">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.campaigns.show', $campaign->id) }}" class="text-gray-600 hover:text-gray-900 mx-2 hidden" title="Lihat Detail">
                                    <i class="fas fa-eye"></i> 
                                </a>

                                {{-- Delete Form --}}
                                <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" class="inline-block" onsubmit="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus campaign ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#FF4400] hover:text-[#EB3F00] mx-2" title="Hapus" onclick="event.stopPropagation()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-lg">
                                Tidak ada campaign yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $campaigns->links() }}
    </div>

@endsection