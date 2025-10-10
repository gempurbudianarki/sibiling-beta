<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Sesi Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- INFORMASI SESI (READ-ONLY) --}}
                    <div class="mb-6 pb-4 border-b">
                        <h3 class="text-lg font-semibold mb-2">Detail Sesi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="font-bold text-gray-600">Mahasiswa</p>
                                <p>{{ $jadwal->konseling->mahasiswa->nm_mhs }} ({{ $jadwal->konseling->mahasiswa->nim }})</p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-600">Jadwal</p>
                                <p>{{ \Carbon\Carbon::parse($jadwal->tgl_sesi)->translatedFormat('l, d M Y') }}, Pukul {{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- FORM PENGISIAN HASIL --}}
                    {{-- Pastikan baris action ini sudah benar --}}
                    <form action="{{ route('dosen-konseling.jadwal.simpanSesi', $jadwal->id_jadwal) }}" method="POST">
                        @csrf

                        {{-- Catatan Sesi --}}
                        <div class="mb-4">
                            <label for="catatan_sesi" class="block text-sm font-medium text-gray-700 mb-1">Catatan Sesi / Pembahasan</label>
                            <textarea id="catatan_sesi" name="catatan_sesi" rows="8" required class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tuliskan detail pembahasan selama sesi konseling..."></textarea>
                        </div>

                        {{-- Rekomendasi --}}
                        <div class="mb-4">
                            <label for="rekomendasi" class="block text-sm font-medium text-gray-700 mb-1">Kesimpulan / Rekomendasi Dosen</label>
                            <textarea id="rekomendasi" name="rekomendasi" rows="4" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tuliskan kesimpulan dan rekomendasi tindak lanjut untuk mahasiswa..."></textarea>
                        </div>

                        {{-- Status Akhir Sesi --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Akhir Sesi</label>
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <input id="status_tuntas" name="status_akhir" type="radio" value="tuntas" required class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="status_tuntas" class="ml-2 block text-sm text-gray-900">Tuntas (Sesi Konseling Selesai)</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="status_lanjutan" name="status_akhir" type="radio" value="lanjutan" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="status_lanjutan" class="ml-2 block text-sm text-gray-900">Perlu Sesi Lanjutan</label>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('dosen-konseling.jadwal.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Simpan Hasil Konseling
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>