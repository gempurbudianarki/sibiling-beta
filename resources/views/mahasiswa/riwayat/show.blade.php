<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Riwayat Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Tombol Kembali --}}
                    <div class="mb-6">
                        <a href="{{ route('mahasiswa.riwayat.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Kembali ke Riwayat
                        </a>
                    </div>

                    {{-- Informasi Utama --}}
                    <div class="border-b border-gray-200 pb-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Pengajuan tanggal {{ \Carbon\Carbon::parse($konseling->tgl_pengajuan)->translatedFormat('d F Y') }}
                        </h3>
                        <div class="mt-2">
                             @php
                                $statusClass = '';
                                switch ($konseling->status_konseling) {
                                    case 'Selesai': $statusClass = 'bg-green-100 text-green-800'; break;
                                    case 'Ditolak': $statusClass = 'bg-red-100 text-red-800'; break;
                                    case 'Menunggu Verifikasi': $statusClass = 'bg-yellow-100 text-yellow-800'; break;
                                    case 'Verifikasi Diterima': case 'Dijadwalkan': $statusClass = 'bg-blue-100 text-blue-800'; break;
                                    default: $statusClass = 'bg-gray-100 text-gray-800';
                                }
                            @endphp
                            <p class="text-sm">Status:
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $konseling->status_konseling }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Detail Pengajuan --}}
                    <div class="mt-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Bidang Layanan</dt>
                                <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $konseling->bidang_layanan }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Jenis Konseli</dt>
                                <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $konseling->jenis_konseli }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Tujuan Konseling</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $konseling->tujuan_konseling }}</dd>
                            </div>
                             <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Deskripsi Masalah</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $konseling->deskripsi_masalah }}</dd>
                            </div>
                             @if($konseling->status_konseling == 'Ditolak' && $konseling->alasan_penolakan)
                                <div class="sm:col-span-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                    <dt class="text-sm font-medium text-red-700">Alasan Penolakan</dt>
                                    <dd class="mt-1 text-sm text-red-900">{{ $konseling->alasan_penolakan }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    {{-- Detail Jadwal Jika Ada --}}
                    @if ($konseling->jadwal)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                             <h4 class="text-md font-medium leading-6 text-gray-900">
                                Informasi Jadwal Konseling
                            </h4>
                            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($konseling->jadwal->tgl_konseling)->translatedFormat('l, d F Y') }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Waktu</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                         {{ \Carbon\Carbon::parse($konseling->jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($konseling->jadwal->waktu_selesai)->format('H:i') }} WIB
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Dosen Konselor</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->jadwal->dosenKonseling->nama ?? 'N/A' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Ruangan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->jadwal->ruangan ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>