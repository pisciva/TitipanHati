@extends('layouts.admin')

@section('title', 'Detail Campaign: ' . $campaign->title)

@section('content')

    <!-- Header Section and Action Buttons -->
    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $campaign->title }}</h1>
            <p class="text-sm text-gray-500 mt-1">Dibuat oleh: <span class="font-medium text-red-600">{{ $campaign->organization->name ?? 'Organisasi Tidak Ditemukan' }}</span></p>
        </div>
        
        <div class="flex space-x-3">
            <a href="{{ route('admin.campaigns.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-100 transition duration-150 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>

            <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" 
               class="px-4 py-2 bg-[#FF4400] text-[#F8FAFC] font-semibold rounded-xl hover:bg-[#EB3F00] transition duration-150 shadow-md flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit Campaign
            </a>

            {{-- Delete Form (Hanya muncul jika tidak ada donasi) --}}
            @if ($campaign->donations->count() == 0)
                <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Campaign akan dihapus secara permanen. Apakah Anda yakin?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-gray-200 text-red-600 font-medium rounded-xl hover:bg-red-100 transition duration-150 flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus
                    </button>
                </form>
            @else
                <button title="Tidak dapat dihapus karena sudah ada donasi masuk" class="px-4 py-2 bg-gray-100 text-gray-400 font-medium rounded-xl cursor-not-allowed flex items-center">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus
                </button>
            @endif
        </div>
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

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Banner and Details --}}
        <div class="lg:col-span-1 space-y-6">

            <!-- Banner Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                @if ($campaign->banner_url)
                    <img src="{{ asset('storage/' . $campaign->banner_url) }}" alt="Banner Campaign" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 font-medium">
                        [Tidak Ada Banner]
                    </div>
                @endif
                <div class="p-6">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Progress Donasi</p>
                    @php
                        // Hitung total kuantitas donasi yang sudah terkumpul
                        $totalDonatedQuantity = $campaign->donations->flatMap(function ($donation) {
                            return $donation->items->pluck('quantity');
                        })->sum();
                        
                        $progressPercentage = $campaign->target_quantity > 0 
                                            ? min(100, ($totalDonatedQuantity / $campaign->target_quantity) * 100) 
                                            : 0;
                    @endphp
                    
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-[#FF4400] h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>{{ number_format($totalDonatedQuantity) }} / {{ number_format($campaign->target_quantity) }} unit</span>
                        <span class="font-semibold text-[#FF4400]">{{ round($progressPercentage) }}%</span>
                    </div>
                </div>
            </div>

            <!-- Detail Information Card -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3">Informasi Campaign</h3>
                
                <div class="flex justify-between items-center border-b pb-2">
                    <span class="text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClass = $campaign->status == 'aktif' 
                            ? 'bg-green-100 text-green-800' 
                            : 'bg-red-100 text-red-800';
                    @endphp
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                        {{ ucfirst($campaign->status) }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center border-b pb-2">
                    <span class="text-sm font-medium text-gray-500">Organisasi</span>
                    <span class="text-sm font-medium text-gray-800">{{ $campaign->organization->name ?? 'N/A' }}</span>
                </div>

                <div class="flex justify-between items-center border-b pb-2">
                    <span class="text-sm font-medium text-gray-500">Batas Waktu</span>
                    <span class="text-sm font-medium text-gray-800">{{ $campaign->deadline->format('d M Y') }}</span>
                </div>

                <div class="flex justify-between items-center border-b pb-2">
                    <span class="text-sm font-medium text-gray-500">Lokasi</span>
                    <span class="text-sm font-medium text-gray-800">
                        {{ \Illuminate\Support\Str::title(strtolower($campaign->city)) }},
                        {{ \Illuminate\Support\Str::title(strtolower($campaign->province)) }}
                    </span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500 block mb-1">Kategori</span>
                    <div class="flex flex-wrap gap-2 pt-1">
                        @foreach ($campaign->categories as $category)
                            <span class="text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full font-medium">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Description and Donations --}}
        <div class="lg:col-span-2 space-y-6">

            <!-- Description Card -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-3">Deskripsi Lengkap Campaign</h3>
                <div class="prose max-w-none text-gray-700">
                    <p>{{ $campaign->description }}</p>
                </div>
            </div>
            
            <!-- Donations List Card -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-3">Daftar Donasi Masuk (Total: {{ $campaign->donations->count() }} Donasi)</h3>
                
                @if ($campaign->donations->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-box-open text-4xl mb-3"></i>
                        <p class="text-lg">Belum ada donasi untuk campaign ini.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($campaign->donations as $donation)
                            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition duration-150">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-semibold text-gray-800">Donasi #{{ $donation->id }}</h4>
                                    <span class="text-xs text-gray-500">{{ $donation->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">Status: 
                                    <span class="font-medium text-green-600">{{ ucfirst($donation->status) }}</span> 
                                    (Oleh: {{ $donation->donor_name ?? 'Anonim' }})
                                </p>

                                <div class="mt-2 border-t border-gray-100 pt-2">
                                    <p class="text-xs font-medium text-gray-500 mb-1">Barang Donasi:</p>
                                    <ul class="list-disc list-inside text-sm text-gray-700">
                                        @foreach ($donation->items as $item)
                                            <li>{{ $item->item_category }} (Jumlah: {{ number_format($item->quantity) }} unit)</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection