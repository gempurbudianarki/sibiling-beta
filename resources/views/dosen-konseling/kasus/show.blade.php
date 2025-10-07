<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('dosen-konseling.kasus.index') }}" class="text-blue-500 hover:underline">&larr; Kembali ke Riwayat Kasus</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
            Detail Hasil Sesi Konseling
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 space-y-6">
                    <div class="border-b pb-4">
                        <h3 class="text-lg font-bold">Informasi Sesi</h3>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Mahasiswa</p>
                                <p class="font-semibold">{{ $hasil->jadwal->konseling->mahasiswa->nm_mhs ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jadwal Sesi</p>
                                <p class="font-semibold">{{ \Carbon\Carbon::parse($hasil->jadwal->tgl_sesi)->isoFormat('dddd, D MMM YYYY') }}, {{ $hasil->jadwal->waktu_mulai }}</p>
                            </div>
                             <div>
                                <p class="text-sm text-gray-500">Tanggal Pencatatan</p>
                                <p class="font-semibold">{{ \Carbon\Carbon::parse($hasil->tgl_pencatatan)->isoFormat('D MMMM YYYY') }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold">Catatan Hasil Konseling</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 mb-1">Ringkasan Sesi</p>
                                <p class="bg-gray-50 p-4 rounded-md whitespace-pre-wrap">{{ $hasil->ringkasan_sesi }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-600 mb-1">Observasi & Analisis Konselor</p>
                                <p class="bg-gray-50 p-4 rounded-md whitespace-pre-wrap">{{ $hasil->observasi_konselor }}</p>
                            </div>
                            @if($hasil->tindak_lanjut)
                            <div>
                                <p class="text-sm font-semibold text-gray-600 mb-1">Rencana Tindak Lanjut</p>
                                <p class="bg-gray-50 p-4 rounded-md whitespace-pre-wrap">{{ $hasil->tindak_lanjut }}</p>
                            </div>
                            @endif
                             <div>
                                <p class="text-sm font-semibold text-gray-600 mb-1">Status Akhir Kasus</p>
                                <p class="font-bold {{ $hasil->status_akhir_sesi == 'selesai' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $hasil->status_akhir_sesi == 'selesai' ? 'Kasus Selesai' : 'Perlu Sesi Lanjutan' }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>