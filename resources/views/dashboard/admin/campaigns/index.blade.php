@extends('layouts.admin')

@section('title', 'Daftar Campaign')

@section('content')

    {{-- 1. START: ALPINE.JS DATA FOR MODAL CONTROL --}}
    <div x-data="{ 
        openModal: false, 
        campaignToDelete: null,
        campaignTitle: '',
        
        // Fungsi untuk membuka modal dan menyimpan ID campaign
        confirmDelete(campaignId, title) {
            this.campaignToDelete = campaignId;
            this.campaignTitle = title;
            this.openModal = true;
        },

        // Fungsi untuk menghapus (submit form tersembunyi)
        deleteCampaign() {
            if (this.campaignToDelete) {
                // Submit form yang sesuai dengan ID campaign
                document.getElementById('delete-form-' + this.campaignToDelete).submit();
            }
        }
    }">
    {{-- 1. END: ALPINE.JS DATA FOR MODAL CONTROL --}}

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

    <div class="bg-white p-6 rounded-2xl shadow-lg mb-6 border border-gray-100">
        <form action="{{ route('admin.campaigns.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            
            {{-- 1. Search Field (Lebih Ringkas) --}}
            <div class="lg:col-span-1">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Cari Campaign</label>
                <input type="text" name="search" id="search" placeholder="Judul..."
                    value="{{ request('search') }}"
                    {{-- UBAH PY-3 MENJADI PY-2 --}}
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-red-600 focus:border-red-600 transition">
            </div>

            {{-- 2. Status Filter (Lebih Ringkas) --}}
            <div class="lg:col-span-1">
                <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status"
                        {{-- UBAH PY-3 MENJADI PY-2 --}}
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-red-600 focus:border-red-600 transition">
                    <option value="">Semua</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- 3. Date From Filter (Lebih Ringkas) --}}
            <div class="lg:col-span-1">
                <label for="date_from" class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                    {{-- UBAH PY-3 MENJADI PY-2 --}}
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-red-600 focus:border-red-600 transition">
            </div>

            {{-- 4. Date To Filter (Lebih Ringkas) --}}
            <div class="lg:col-span-1">
                <label for="date_to" class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                    {{-- UBAH PY-3 MENJADI PY-2 --}}
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-red-600 focus:border-red-600 transition">
            </div>

            {{-- 5. Action Buttons --}}
            <div class="lg:col-span-1 flex space-x-2 pt-2 md:pt-0">
            <button type="submit" 
                    class="flex-shrink-0 px-4 py-2 bg-[#FF4400] text-white font-semibold rounded-xl text-sm hover:bg-[#EB3F00] transition duration-150 shadow-sm flex items-center">
                <i class="fas fa-filter mr-1"></i> Terapkan
            </button>
                <a href="{{ route('admin.campaigns.index') }}" 
                class="flex-shrink-0 px-3 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg text-sm hover:bg-gray-100 transition duration-150">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Berakhir</th>
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
                            
                            {{-- KOLOM AKSI (Diperbaiki agar selalu memicu pop-up) --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative z-10">
                                <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="text-[#FF4400] hover:text-[#EB3F00] mx-2" title="Edit" onclick="event.stopPropagation()">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.campaigns.show', $campaign->id) }}" class="text-gray-600 hover:text-gray-900 mx-2 hidden" title="Lihat Detail">
                                    <i class="fas fa-eye"></i> 
                                </a>

                                {{-- Tombol Hapus Selalu Aktif (Memicu Pop-up) --}}
                                <button type="button" 
                                        @click.stop="confirmDelete({{ $campaign->id }}, '{{ $campaign->title }}')" 
                                        class="text-[#FF4400] hover:text-[#EB3F00] mx-2" 
                                        title="Hapus" 
                                        onclick="event.stopPropagation()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                {{-- Hidden Form untuk penghapusan aktual --}}
                                <form id="delete-form-{{ $campaign->id }}" action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                            {{-- END KOLOM AKSI --}}
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

    <div class="mt-6">
        {{ $campaigns->links() }}
    </div>

    {{-- MODAL KONFIRMASI DELETE (POP UP BARU) --}}
    <div x-show="openModal" 
         class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50 transition-opacity duration-300 flex items-center justify-center"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         @click.away="openModal = false">
        
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 p-6"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            {{-- Icon dan Judul --}}
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                        Konfirmasi Penghapusan Campaign
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Anda yakin ingin menghapus campaign <span x-text="campaignTitle" class="font-semibold text-gray-800"></span>?
                        </p>
                        <p class="text-sm text-red-600 font-medium mt-1">
                            Tindakan ini tidak dapat dibatalkan dan semua data terkait akan hilang!
                        </p>
                    </div>
                </div>
            </div>
            
            {{-- Tombol Aksi --}}
            <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                <button @click="deleteCampaign()" type="button"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Ya, Hapus Permanen
                </button>
                <button @click="openModal = false" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Batalkan
                </button>
            </div>
            
        </div>
    </div>
    {{-- END: MODAL KONFIRMASI DELETE --}}

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