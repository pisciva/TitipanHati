@extends('layouts.dash-admin')

@section('title', 'Manajemen Organisasi')

@section('content')

    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-[#1D1D1D]">Daftar Organisasi</h1>
            <a href="{{ route('admin.organizations.create') }}" class="bg-[#FF4400] text-white px-4 py-2 rounded-lg hover:bg-[#EB3F00] transition duration-150 flex items-center shadow-md">
                <i class="fas fa-plus mr-2"></i> Tambah Organisasi
            </a>
        </div>
        <p class="text-sm text-gray-500 mt-1">Kelola daftar organisasi yang terdaftar dalam sistem.</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-8">
        <form method="GET" action="{{ route('admin.organizations.index') }}" class="mb-4">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-grow">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Berdasarkan Nama</label>
                    <input type="text" name="search" id="search" placeholder="Cari Organisasi..."
                           value="{{ request('search') }}"
                           class="w-full border border-gray-300 p-2 rounded-lg focus:ring-[#FF4400] focus:border-[#FF4400]">
                </div>

                <div>
                    <label for="is_verified" class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi</label>
                    <select name="is_verified" id="is_verified"
                            class="w-48 border border-gray-300 p-2 rounded-lg focus:ring-[#FF4400] focus:border-[#FF4400]">
                        <option value="">Semua</option>
                        <option value="true" {{ request('is_verified') === 'true' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="false" {{ request('is_verified') === 'false' ? 'selected' : '' }}>Belum Terverifikasi</option>
                    </select>
                </div>

                <button type="submit" class="bg-[#FF4400] text-white px-4 py-2 rounded-lg hover:bg-[#EB3F00] transition">
                    Filter
                </button>

                <a href="{{ route('admin.organizations.index') }}" class="text-gray-600 px-4 py-2 rounded-lg hover:text-gray-900 transition border border-gray-300">
                    Reset
                </a>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Organisasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Dibuat Pada</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Aksi</th> 
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($organizations as $organization)
                        <tr class="group cursor-pointer hover:bg-gray-50 transition duration-150 relative">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                {{ $organization->id }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.organizations.show', $organization->id) }}" class="absolute inset-0 z-10"></a> 
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover border" 
                                             src="{{ $organization->logo_url ? Storage::url($organization->logo_url) : asset('path/to/default/logo.png') }}" 
                                             alt="{{ $organization->name }} Logo">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-[#FF4400] transition">{{ $organization->name }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($organization->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div><i class="fas fa-envelope mr-1 text-gray-400"></i> {{ $organization->contact_email }}</div>
                                @if ($organization->contact_phone)
                                    <div><i class="fas fa-phone mr-1 text-gray-400"></i> {{ $organization->contact_phone }}</div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 max-w-xs truncate">
                                {{ Str::limit($organization->address, 50) }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                @if ($organization->is_verified)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                {{ $organization->created_at->translatedFormat('d M Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center relative z-20">
                                <div class="flex justify-center space-x-2">
                                    
                                    <a href="{{ route('admin.organizations.edit', $organization->id) }}" 
                                       class="text-[#FF4400] hover:text-[#EB3F00] p-2 rounded-full hover:bg-orange-50 transition" title="Edit Organisasi">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form id="deleteForm-{{ $organization->id }}" 
                                          action="{{ route('admin.organizations.destroy', $organization->id) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="showDeleteModal('{{ $organization->id }}', '{{ addslashes($organization->name) }}')"
                                                class="text-[#FF4400] hover:text-[#EB3F00] p-2 rounded-full hover:bg-red-50 transition" 
                                                title="Hapus Organisasi">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                <i class="fas fa-building text-4xl mb-3"></i>
                                <p>Tidak ada organisasi yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $organizations->links() }}
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 hidden flex items-center justify-center p-4 transition-opacity duration-300" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-lg w-full transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            
            <div class="bg-white px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-[#FF4400] text-lg" aria-hidden="true"></i>
                    </div>
                    
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                            Hapus Organisasi Permanen
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">
                                Apakah Anda yakin ingin menghapus organisasi <span id="organizationName" class="font-semibold text-[#EB3F00]"></span>?
                            </p>
                            <p class="text-sm text-[#EB3F00] mt-2 font-medium">
                                Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait, termasuk Campaign.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                
                <button type="button" id="confirmDeleteButton" 
                        class="w-full inline-flex justify-center items-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-[#FF4400] text-base font-medium text-white hover:bg-[#EB3F00] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF4400] sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus Permanen
                </button>
                
                <button type="button" onclick="hideDeleteModal()" 
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                    Batal
                </button>
            </div>
        </div>
    </div>
    
    <script>
        let formToSubmit = null;

        function showDeleteModal(organizationId, organizationName) {
            formToSubmit = document.getElementById('deleteForm-' + organizationId);

            document.getElementById('organizationName').innerText = organizationName;

            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            formToSubmit = null;
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            if (formToSubmit) {
                formToSubmit.submit();
            }
            hideDeleteModal();
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideDeleteModal();
            }
        });
    </script>

@endsection