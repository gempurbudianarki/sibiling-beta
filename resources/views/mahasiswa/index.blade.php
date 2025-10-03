<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Mahasiswa') }}
        </h2>
    </x-slot>

    {{-- Kita gunakan Alpine.js untuk membuat komponen interaktif --}}
    <div 
        x-data="{ 
            search: '',
            mahasiswa: {{ $all_mahasiswa->toJson() }},
            isLoading: false,
            showModal: false, 
            selectedMhs: {},
            searchMahasiswa() {
                this.isLoading = true;
                if (this.search.trim() === '') {
                    // Jika kotak pencarian kosong, kembali ke data awal dengan pagination
                    window.location.href = '{{ route('mahasiswa.index') }}';
                    return;
                }
                fetch(`/api/mahasiswa/search?q=${this.search}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    this.mahasiswa = { data: data, links: {} }; // Menyesuaikan format untuk live search
                    this.isLoading = false;
                });
            }
        }" 
        class="py-12"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- KOTAK PENCARIAN LIVE SEARCH --}}
                    <div class="mb-4">
                        <input 
                            x-model="search" 
                            @input.debounce.500ms="searchMahasiswa()"
                            type="text" 
                            placeholder="Ketik untuk mencari nama atau NIM mahasiswa secara real-time..." 
                            class="form-input rounded-md shadow-sm w-full lg:w-2/3"
                        >
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program Studi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Angkatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Menampilkan loading spinner --}}
                                <template x-if="isLoading">
                                    <tr><td colspan="5" class="text-center py-4 text-gray-500">Mencari...</td></tr>
                                </template>

                                {{-- Looping data dari hasil pencarian atau data awal --}}
                                <template x-if="!isLoading && mahasiswa.data.length > 0">
                                    <template x-for="mhs in mahasiswa.data" :key="mhs.nim">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="mhs.nim"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="mhs.nm_mhs"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="mhs.prodi ? mhs.prodi.nm_prodi : 'N/A'"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="mhs.angkatan"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button @click="showModal = true; selectedMhs = mhs" class="text-indigo-600 hover:text-indigo-900">
                                                    Lihat Detail
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </template>

                                {{-- Pesan jika tidak ada data --}}
                                <template x-if="!isLoading && mahasiswa.data.length === 0">
                                    <tr><td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data mahasiswa ditemukan.</td></tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- Link Navigasi Pagination (hanya tampil saat tidak mencari) --}}
                    <div class="mt-4" x-show="search.trim() === ''">
                        {{ $all_mahasiswa->links() }}
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Dialog untuk Menampilkan Detail Mahasiswa -->
        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                <div @click="showModal = false" x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-4xl p-8 my-20 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle">
                    <div class="flex items-center justify-between space-x-4">
                        <h3 class="text-xl font-semibold text-gray-800" x-text="selectedMhs.nm_mhs || 'Detail Mahasiswa'"></h3>
                        <button @click="showModal = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </button>
                    </div>
                    <div class="mt-6 border-t border-gray-200 max-h-[60vh] overflow-y-auto">
                        <dl class="divide-y divide-gray-200">
                            <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50"><dt class="text-sm font-medium text-gray-500">NIM</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.nim || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4"><dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.nm_mhs || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50"><dt class="text-sm font-medium text-gray-500">Program Studi</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.prodi ? selectedMhs.prodi.nm_prodi : 'N/A'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4"><dt class="text-sm font-medium text-gray-500">Angkatan</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.angkatan || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50"><dt class="text-sm font-medium text-gray-500">Email</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.email || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4"><dt class="text-sm font-medium text-gray-500">No. HP</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.no_hp || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50"><dt class="text-sm font-medium text-gray-500">Tempat, Tgl Lahir</dt><dd class="text-sm text-gray-900 col-span-2"><span x-text="selectedMhs.tmpt_lahir || '-'"></span>, <span x-text="selectedMhs.tgl_lahir || '-'"></span></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4"><dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.jk || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50"><dt class="text-sm font-medium text-gray-500">Dosen Wali</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.id_dosen_wali || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4"><dt class="text-sm font-medium text-gray-500">Nama Ayah</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.nm_ayah || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50"><dt class="text-sm font-medium text-gray-500">Nama Ibu</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.nm_ibu_kandung || '-'"></dd></div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4"><dt class="text-sm font-medium text-gray-500">Sekolah Asal</dt><dd class="text-sm text-gray-900 col-span-2" x-text="selectedMhs.nm_sekolah_asal || '-'"></dd></div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

