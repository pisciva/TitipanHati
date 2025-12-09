@extends('layouts.dash-admin')

@section('title', 'Daftar Donasi')

@section('content')


    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-semibold text-[#1D1D1D]">Manajemen Donasi Barang</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola dan pantau status semua donasi barang yang masuk ke berbagai campaign.</p>
        </div>
        <a href="{{ route('admin.donations.calendar') }}" 
           class="px-5 py-2.5 bg-[#FF4400] text-white font-semibold rounded-xl hover:bg-[#EB3F00] transition duration-150 shadow-md flex items-center">
            <i class="fas fa-calendar-alt mr-2"></i> Lihat Jadwal Penjemputan
        </a>
    </div>


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


    <div class="bg-white p-6 rounded-2xl shadow-lg mb-6 border border-gray-100">
        <form action="{{ route('admin.donations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                <select name="status" id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                    <option value="">Semua Status</option>
                    <option value="menunggu_penjemputan" {{ request('status') == 'menunggu_penjemputan' ? 'selected' : '' }}>Menunggu Penjemputan</option>
                    <option value="dalam_perjalanan" {{ request('status') == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>


            <div>
                <label for="campaign_id" class="block text-sm font-medium text-gray-700 mb-1">Filter Campaign</label>
                <select name="campaign_id" id="campaign_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
                    <option value="">Semua Campaign</option>
                    @foreach ($campaigns as $campaign)
                        <option value="{{ $campaign->id }}" {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>
                            {{ $campaign->title }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" id="date_from"
                       value="{{ request('date_from') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
            </div>


            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" id="date_to"
                       value="{{ request('date_to') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-red-600 focus:border-red-600 transition">
            </div>


            <div class="col-span-full md:col-span-4 flex space-x-2 mt-2">
                <button type="submit" 
                        class="flex-shrink-0 px-4 py-2 bg-[#FF4400] text-white font-medium rounded-xl hover:bg-[#EB3F00] transition duration-150">
                    <i class="fas fa-filter mr-1"></i> Terapkan Filter
                </button>
                <a href="{{ route('admin.donations.index') }}" 
                   class="flex-shrink-0 px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-100 transition duration-150">
                    Reset
                </a>
                <a href="{{ route('admin.donations.export', request()->query()) }}" 
                   class="flex-shrink-0 px-4 py-2 border border-gray-300 text-green-600 font-medium rounded-xl hover:bg-green-50 transition duration-150">
                    <i class="fas fa-file-excel mr-1"></i> Export Data
                </a>
            </div>
        </form>
    </div>


    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Donasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donatur / Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl. Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($donations as $donation)

                        <tr class="group hover:bg-gray-50 cursor-pointer relative">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.donations.show', $donation->id) }}" class="absolute inset-0"></a>
                                <div class="text-sm font-medium text-gray-900 group-hover:text-[#EB3F00] transition">#{{ $donation->id }}</div>
                                <div class="text-xs text-gray-500">Pick-up: {{ $donation->pickup_date->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="font-medium">{{ $donation->donor_name ?? 'Anonim' }}</div>
                                <div class="text-xs text-gray-500">{{ $donation->contact_phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $donation->campaign->title ?? 'Campaign Dihapus' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $donation->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'menunggu_penjemputan' => 'bg-yellow-100 text-yellow-800',
                                        'dalam_perjalanan' => 'bg-blue-100 text-blue-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusKey = strtolower($donation->status);
                                    $statusClass = $statusClasses[$statusKey] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $donation->status)) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative z-10">

                                <a href="{{ route('admin.donations.show', $donation->id) }}" 
                                   class="text-[#FF4400] hover:text-[#EB3F00] mx-2" 
                                   title="Update Status" 
                                   onclick="event.stopPropagation()">
                                    <i class="fas fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-lg">
                                Tidak ada data donasi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="mt-6">
        {{ $donations->links() }}
    </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateFrom = document.getElementById('date_from');
            const dateTo = document.getElementById('date_to');

            const setMinDateTo = (fromValue) => {
                dateTo.min = fromValue;
                
                if (dateTo.value && fromValue && dateTo.value < fromValue) {
                    dateTo.value = fromValue; 
                }
            };
            
            dateFrom.addEventListener('change', function() {
                setMinDateTo(this.value);
            });
            
            dateTo.addEventListener('change', function() {
                if (dateFrom.value && this.value < dateFrom.value) {
                    alert('Kesalahan Filter: "Sampai Tanggal" tidak boleh sebelum "Dari Tanggal". Nilai akan disesuaikan.');
                    this.value = dateFrom.value;
                }
            });

            if (dateFrom.value) {
                setMinDateTo(dateFrom.value);
            }
        });
    </script>

@endsection