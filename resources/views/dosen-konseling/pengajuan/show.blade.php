<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="text-blue-500 hover:underline">&larr; Kembali ke Daftar Pengajuan</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
            Detail Pengajuan Konseling
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- INFORMASI MAHASISWA --}}
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold">Informasi Mahasiswa</h3>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama Lengkap</p>
                                <p>{{ $konseling->mahasiswa->nm_mhs ?? 'Tidak tersedia' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">NIM</p>
                                <p>{{ $konseling->nim_mahasiswa }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Program Studi</p>
                                <p>{{ $konseling->mahasiswa->prodi->prodi ?? 'Tidak tersedia' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Angkatan</p>
                                <p>{{ $konseling->mahasiswa->angkatan ?? 'Tidak tersedia' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- DETAIL PERMASALAHAN --}}
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold">Detail Permasalahan</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Permasalahan yang Ingin Segera Diselesaikan</p>
                                <p class="bg-gray-50 p-3 rounded-md">{{ $konseling->permasalahan_segera }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Harapan Setelah Konseling</p>
                                <p class="bg-gray-50 p-3 rounded-md">{{ $konseling->harapan_konseling }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- AKSI VERIFIKASI --}}
                    <div>
                        <h3 class="text-lg font-bold">Aksi Verifikasi</h3>

                        <form method="POST"
                              action="{{ route('dosen-konseling.pengajuan.verifikasi', $konseling->id_konseling) }}"
                              class="mt-4 space-y-4"
                              x-data="{ action: '' }">
                            @csrf
                            
                            {{-- PILIH AKSI --}}
                            <div>
                                <x-input-label for="action" value="Pilih Aksi" />
                                <select id="action" name="action"
                                        x-model="action"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="" disabled selected>-- Pilih salah satu --</option>
                                    <option value="setuju">Setujui & Siap Dijadwalkan</option>
                                    <option value="revisi">Minta Revisi kepada Mahasiswa</option>
                                </select>
                            </div>

                            {{-- CATATAN REVISI --}}
                            <div x-show="action === 'revisi'" style="display: none;">
                                <x-input-label for="catatan_revisi" value="Catatan Revisi (Wajib diisi jika meminta revisi)" />
                                <textarea id="catatan_revisi" name="catatan_revisi" rows="4"
                                          class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                          placeholder="Contoh: Mohon lengkapi detail permasalahan yang dihadapi agar lebih mudah dipahami..."></textarea>
                                <x-input-error :messages="$errors->get('catatan_revisi')" class="mt-2" />
                            </div>

                            {{-- TOMBOL SIMPAN --}}
                            <div class="flex items-center gap-4">
                                {{-- PERBAIKAN FINAL ADA DI SINI --}}
                                <x-primary-button x-bind:disabled="action === ''">
                                    {{ __('Simpan Keputusan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
