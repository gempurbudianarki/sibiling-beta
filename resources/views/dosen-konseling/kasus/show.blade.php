<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Arsip Kasus: {{ $konseling->mahasiswa->nm_mhs }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Informasi Kasus
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Detail pengajuan konseling untuk mahasiswa yang bersangkutan.
                    </p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Mahasiswa</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $konseling->mahasiswa->nm_mhs }} ({{ $konseling->nim_mahasiswa }})</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Tanggal Pengajuan Awal</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($konseling->tgl_pengajuan)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Sumber Pengajuan</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $konseling->sumber_pengajuan == 'mahasiswa' ? 'Mahasiswa' : 'Rekomendasi Dosen PA' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-full">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Deskripsi Permasalahan Awal
                    </h2>
                    <div class="mt-4 prose dark:prose-invert max-w-none">
                        <blockquote>
                            <p>{{ $konseling->permasalahan ?: $konseling->permasalahan_segera }}</p>
                        </blockquote>
                        <h4 class="font-semibold mt-4">Harapan yang ingin dicapai:</h4>
                        <p>{{ $konseling->harapan ?: $konseling->harapan_pa }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-full">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Riwayat Sesi Konseling
                    </h2>
                    
                    <div class="mt-6 border-l-2 border-gray-200 dark:border-gray-700">
                        @forelse($konseling->jadwalKonseling as $index => $jadwal)
                            @if($jadwal->hasilKonseling)
                            <div class="relative pl-8 py-4">
                                <div class="absolute -left-[11px] top-5 h-5 w-5 bg-blue-500 rounded-full ring-8 ring-white dark:ring-gray-800"></div>
                                <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">Sesi #{{ $index + 1 }} - {{ \Carbon\Carbon::parse($jadwal->waktu_konseling)->translatedFormat('d F Y, H:i') }}</span>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg prose dark:prose-invert max-w-none">
                                    <h4 class="font-semibold">Catatan Sesi:</h4>
                                    <div>{!! nl2br(e($jadwal->hasilKonseling->catatan_sesi)) !!}</div>
                                    
                                    @if($jadwal->hasilKonseling->rekomendasi)
                                    <h4 class="font-semibold mt-4">Rekomendasi:</h4>
                                    <div>{!! nl2br(e($jadwal->hasilKonseling->rekomendasi)) !!}</div>
                                    @endif

                                    <p class="mt-4 font-semibold">Status Akhir Sesi: <span class="px-2 py-1 text-xs rounded-full {{ $jadwal->hasilKonseling->status_akhir == 'tuntas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($jadwal->hasilKonseling->status_akhir) }}</span></p>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="relative pl-8 py-4">
                                <p class="text-gray-500">Tidak ada riwayat sesi yang tercatat untuk kasus ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>