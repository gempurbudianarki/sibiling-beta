<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Riwayat Kasus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 space-y-8">

                    {{-- Tombol Kembali --}}
                    <div>
                        <a href="{{ route('dosen-konseling.kasus.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Kembali ke Riwayat Kasus
                        </a>
                    </div>

                    {{-- Informasi Mahasiswa --}}
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                            Informasi Mahasiswa
                        </h3>
                        <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Mahasiswa</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $konseling->mahasiswa->nm_mhs ?? 'N/A' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIM</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $konseling->nim_mahasiswa }}</dd>
                            </div>
                             <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi Masalah Awal</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $konseling->deskripsi_masalah ?: 'Tidak ada deskripsi detail.' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Hasil dan Catatan Sesi --}}
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                            Hasil dan Catatan Sesi
                        </h3>
                        
                        {{-- === PERBAIKAN UTAMA DI SINI === --}}
                        {{-- Mengakses relasi 'jadwal' (tunggal), bukan 'jadwalKonseling' (jamak) --}}
                        @if ($konseling->jadwal && $konseling->jadwal->hasilKonseling)
                            @php
                                $jadwal = $konseling->jadwal;
                                $hasil = $jadwal->hasilKonseling;
                            @endphp
                            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Sesi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ \Carbon\Carbon::parse($jadwal->tgl_konseling)->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dosen Konselor</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $jadwal->dosenKonseling->nm_dos ?? 'N/A' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Catatan Sesi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 prose prose-sm max-w-none dark:prose-invert">
                                        {!! nl2br(e($hasil->catatan_sesi)) !!}
                                    </dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tindak Lanjut</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 prose prose-sm max-w-none dark:prose-invert">
                                        {!! nl2br(e($hasil->tindak_lanjut)) !!}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Akhir Kasus</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                         <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $hasil->status_kasus }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        @else
                            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                Data hasil sesi konseling untuk kasus ini tidak ditemukan.
                            </p>
                        @endif
                         {{-- === AKHIR PERBAIKAN === --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>