<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Dosen') }}
        </h2>
    </x-slot>

    {{-- Kita gunakan Alpine.js (x-data) untuk mengelola state modal --}}
    <div x-data="{ showModal: false, selectedDosen: {} }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Tabel Utama yang Menampilkan Data Ringkas --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Dosen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIDN</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. HP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($all_dosen as $d)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $d->gelar_dpn }} {{ $d->nm_dos }} {{ $d->gelar_blkg }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->nidn ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->no_hp ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- Tombol ini akan membuka modal dan mengisi data 'selectedDosen' --}}
                                            <button @click="showModal = true; selectedDosen = {{ json_encode($d) }}" class="text-indigo-600 hover:text-indigo-900">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data dosen yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Link Navigasi Pagination --}}
                    <div class="mt-4">
                        {{ $all_dosen->links() }}
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Dialog untuk Menampilkan Detail Dosen -->
        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                {{-- Latar belakang overlay --}}
                <div @click="showModal = false" x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

                {{-- Konten Modal --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-4xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-5xl">
                    <div class="flex items-center justify-between space-x-4">
                        <h3 class="text-xl font-semibold text-gray-800" x-text="selectedDosen.nm_dos"></h3>
                        <button @click="showModal = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-6 border-t border-gray-200">
                        <dl class="divide-y divide-gray-200">
                            <div class="px-4 py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900 col-span-2" x-text="selectedDosen.email_dos"></dd>
                            </div>
                             <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                <dd class="text-sm text-gray-900 col-span-2" x-text="(selectedDosen.gelar_dpn || '') + ' ' + selectedDosen.nm_dos + ' ' + (selectedDosen.gelar_blkg || '')"></dd>
                            </div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">NIDN</dt>
                                <dd class="text-sm text-gray-900 col-span-2" x-text="selectedDosen.nidn || '-'"></dd>
                            </div>
                             <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">No. HP</dt>
                                <dd class="text-sm text-gray-900 col-span-2" x-text="selectedDosen.no_hp || '-'"></dd>
                            </div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Tempat, Tgl Lahir</dt>
                                <dd class="text-sm text-gray-900 col-span-2"><span x-text="selectedDosen.tmpt_lahir || '-'"></span>, <span x-text="selectedDosen.tgl_lahir || '-'"></span></dd>
                            </div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                <dd class="text-sm text-gray-900 col-span-2" x-text="selectedDosen.jln || '-'"></dd>
                            </div>
                            <div class="px-4 py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Pendidikan S1</dt>
                                <dd class="text-sm text-gray-900 col-span-2"><span x-text="selectedDosen.s1_nm_prodi || '-'"></span> di <span x-text="selectedDosen.s1_nm_pt || '-'"></span></dd>
                            </div>
                             <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Pendidikan S2</dt>
                                <dd class="text-sm text-gray-900 col-span-2"><span x-text="selectedDosen.s2_nm_prodi || '-'"></span> di <span x-text="selectedDosen.s2_nm_pt || '-'"></span></dd>
                            </div>
                            {{-- Tambahkan data lain di sini jika perlu --}}
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

