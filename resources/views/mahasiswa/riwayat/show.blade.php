<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Riwayat Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openDetail: false }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- HEADER --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b pb-6">
                        <div>
                            @if ($konseling->sumber_pengajuan == 'dosen_pa')
                                <h3 class="text-xl font-bold text-gray-800">Rekomendasi dari Dosen Pembimbing</h3>
                                <p class="text-sm text-gray-500 mt-1">Oleh: <span class="font-medium">{{ $konseling->dosenWali->user->name ?? 'N/A' }}</span></p>
                            @else
                                <h3 class="text-xl font-bold text-gray-800">Pengajuan Mandiri Anda</h3>
                                <p class="text-sm text-gray-500 mt-1">Diajukan pada: {{ $konseling->tgl_pengajuan->format('d F Y') }}</p>
                            @endif
                        </div>
                        <div class="flex-shrink-0">
                             @php
                                $statusColor = match($konseling->status_konseling) {
                                    'Menunggu Verifikasi' => 'bg-gray-100 text-gray-800', 'Disetujui' => 'bg-blue-100 text-blue-800',
                                    'Terjadwal' => 'bg-green-100 text-green-800', 'Selesai' => 'bg-purple-100 text-purple-800',
                                    'Ditolak' => 'bg-red-100 text-red-800', 'Perlu Revisi' => 'bg-yellow-100 text-yellow-800', 'Butuh Sesi Lanjutan' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ $konseling->status_konseling }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- INFORMASI PENGAJUAN AWAL --}}
                     <div class="mt-6">
                        <div class="flex justify-between items-center">
                             <h4 class="font-semibold text-gray-700">Informasi Pengajuan Awal</h4>
                             <button @click="openDetail = true" class="text-sm text-indigo-600 hover:underline">Lihat Selengkapnya &rarr;</button>
                        </div>
                    </div>

                    {{-- RIWAYAT JADWAL & HASIL SESI --}}
                    <div class="mt-6 border-t pt-6">
                        <h4 class="font-semibold text-gray-700 mb-4">Riwayat Sesi & Jadwal</h4>
                        <div class="space-y-4">
                            @forelse ($konseling->jadwalSesi->sortBy('waktu_mulai') as $sesi)
                                <div class="p-4 rounded-lg border {{ $sesi->hasilKonseling ? 'border-gray-200' : 'border-green-400 bg-green-50' }}">
                                    <div class="flex justify-between items-center">
                                        <h5 class="font-bold text-gray-800">Sesi #{{ $loop->iteration }}</h5>
                                        @if (!$sesi->hasilKonseling && $konseling->status_konseling == 'Terjadwal')
                                            <span class="text-xs font-semibold text-green-800">JADWAL ANDA BERIKUTNYA</span>
                                        @endif
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700 space-y-1 border-b pb-3 mb-3">
                                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('l, d F Y') }}</p>
                                        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }} WIB</p>
                                        <p><strong>Metode:</strong> {{ $sesi->metode_konseling }} @if($sesi->lokasi) ({{ $sesi->lokasi }}) @endif</p>
                                    </div>

                                    @if ($sesi->hasilKonseling)
                                        <div class="mt-3 text-sm">
                                            <p class="font-semibold text-gray-600">Catatan Hasil Sesi dari Konselor:</p>
                                            <p class="mt-1 text-gray-800 bg-gray-50 p-2 rounded-md">{{ $sesi->hasilKonseling->rekomendasi }}</p>
                                        </div>
                                         @if ($loop->last && $konseling->status_konseling != 'Terjadwal')
                                            <div class="mt-3 text-xs font-semibold p-2 rounded-md {{ $konseling->status_konseling == 'Selesai' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                Status Setelah Sesi Ini: {{ $konseling->status_konseling }}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @empty
                                 <p class="text-sm text-gray-500 italic">Belum ada jadwal yang ditetapkan untuk pengajuan ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6 flex justify-start">
                        <a href="{{ route('mahasiswa.riwayat.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                            &larr; Kembali ke Daftar Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>

         <div x-show="openDetail" @keydown.window.escape="openDetail = false" class="fixed inset-0 overflow-hidden" style="display: none;">
             <div class="absolute inset-0 overflow-hidden">
                <div x-show="openDetail" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-500 bg-opacity-75" @click="openDetail = false"></div>
                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                    <div x-show="openDetail" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md">
                        <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                            <div class="py-6 px-4 bg-indigo-700">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white">Detail Pengajuan Awal</h2>
                                    <button @click="openDetail = false" class="text-indigo-200 hover:text-white">&times;</button>
                                </div>
                            </div>
                            <div class="relative flex-1 py-6 px-4 text-sm">
                               @if ($konseling->sumber_pengajuan == 'mahasiswa')
                                    <div class="space-y-4">
                                        <div><dt class="font-medium text-gray-500">Bidang Layanan</dt><dd class="mt-1 text-gray-900 capitalize">{{ $konseling->bidang_layanan }}</dd></div>
                                        <div><dt class="font-medium text-gray-500">Deskripsi Masalah</dt><dd class="mt-1 text-gray-900">{{ $konseling->deskripsi_masalah }}</dd></div>
                                        <div><dt class="font-medium text-gray-500">Tujuan Konseling</dt><dd class="mt-1 text-gray-900">{{ $konseling->tujuan_konseling }}</dd></div>
                                        <div class="border-t pt-4">
                                            <h4 class="font-semibold text-gray-800 mb-2">Hasil Asesmen Anda</h4>
                                            @php $questions = [1 => 'Merasa lelah?', 2 => 'Merasa cemas?', 3 => 'Merasa gugup?', 4 => 'Merasa putus asa?', 5 => 'Merasa gelisah?', 6 => 'Tidak bisa duduk tenang?', 7 => 'Merasa tertekan?', 8 => 'Sulit melakukan sesuatu?', 9 => 'Merasa sangat sedih?', 10 => 'Merasa tidak berharga?']; @endphp
                                            <ul class="space-y-2">
                                                @foreach($konseling->hasil_asesmen as $index => $jawaban)
                                                    <li><p class="font-medium text-gray-600">{{ $questions[$index] ?? "Q#{$index}" }}: <span class="font-bold text-indigo-600">{{ $jawaban }}</span></p></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <p>Detail pengajuan dari Dosen Wali dapat dilihat pada halaman Dosen Konseling.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>