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
                    
                    {{-- HEADER --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div>
                            @if ($konseling->sumber_pengajuan == 'dosen_pa')
                                <h3 class="text-xl font-bold text-gray-800">
                                    Rekomendasi dari Dosen Pembimbing
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Direkomendasikan oleh: <span class="font-medium">{{ $konseling->dosenWali->user->name ?? 'N/A' }}</span> pada {{ $konseling->tgl_pengajuan->format('d F Y') }}
                                </p>
                            @else
                                <h3 class="text-xl font-bold text-gray-800">
                                    Detail Pengajuan Mandiri Anda
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Diajukan pada tanggal: {{ $konseling->tgl_pengajuan->format('d F Y') }}
                                </p>
                            @endif
                        </div>
                        <div class="flex-shrink-0">
                            @php
                                $statusColor = match($konseling->status_konseling) {
                                    'Menunggu Verifikasi' => 'bg-gray-100 text-gray-800',
                                    'Disetujui' => 'bg-blue-100 text-blue-800',
                                    'Terjadwal' => 'bg-green-100 text-green-800',
                                    'Selesai' => 'bg-purple-100 text-purple-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                    'Perlu Revisi' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ $konseling->status_konseling }}
                            </span>
                        </div>
                    </div>

                    {{-- KONTEN DETAIL --}}
                    <div class="border-t border-gray-200 mt-6 pt-6">
                        
                        {{-- ================== KONTEN KONDISIONAL BARU ================== --}}
                        @if ($konseling->sumber_pengajuan == 'mahasiswa')
                            {{-- TAMPILAN JIKA INI ADALAH PENGAJUAN MANDIRI (FORM BARU) --}}
                            <div class="space-y-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-800 mb-2">Informasi Pengajuan</h4>
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                                        <div>
                                            <dt class="font-medium text-gray-500">Bidang Layanan</dt>
                                            <dd class="mt-1 text-gray-900 capitalize">{{ $konseling->bidang_layanan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-500">Jenis Konseli</dt>
                                            <dd class="mt-1 text-gray-900 capitalize">{{ $konseling->jenis_konseli }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="font-medium text-gray-500">Tujuan Konseling</dt>
                                            <dd class="mt-1 text-gray-900">{{ $konseling->tujuan_konseling }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="font-medium text-gray-500">Deskripsi Masalah Saat Ini</dt>
                                            <dd class="mt-1 text-gray-900">{{ $konseling->deskripsi_masalah }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-800 mb-4">Hasil Asesmen Singkat Anda</h4>
                                    @php
                                        $questions = [
                                            1 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa lelah tanpa sebab yang jelas?',
                                            2 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa cemas atau khawatir?',
                                            3 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa sangat gugup sehingga tidak ada yang dapat menenangkan Anda?',
                                            4 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa putus asa?',
                                            5 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa gelisah atau tidak tenang?',
                                            6 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa sangat gelisah sehingga tidak dapat duduk tenang?',
                                            7 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa tertekan?',
                                            8 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa perlu berusaha keras untuk melakukan segala hal?',
                                            9 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa sangat sedih sehingga tidak ada yang dapat menghibur Anda?',
                                            10 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa tidak berharga atau tidak berarti?',
                                        ];
                                    @endphp
                                    <ul class="space-y-4">
                                        @foreach($konseling->hasil_asesmen as $index => $jawaban)
                                            <li class="text-sm">
                                                <p class="font-medium text-gray-600">{{ $questions[$index] ?? "Pertanyaan #{$index}" }}</p>
                                                <p class="text-indigo-600 font-semibold mt-1 pl-4 border-l-2 border-indigo-200">{{ $jawaban }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        @elseif ($konseling->sumber_pengajuan == 'dosen_pa')
                            {{-- TAMPILAN JIKA INI ADALAH REKOMENDASI DARI DOSEN PA --}}
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Aspek Permasalahan (temuan Dosen PA)</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @foreach($konseling->aspek_permasalahan as $aspek)
                                            <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $aspek }}</span>
                                        @endforeach
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Permasalahan Mendesak (menurut Dosen PA)</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->permasalahan_segera }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Upaya yang Telah Dilakukan Dosen PA</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->upaya_dilakukan }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Harapan Dosen PA</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->harapan_pa }}</dd>
                                </div>
                            </dl>
                        @endif
                        
                        {{-- BAGIAN NOTIFIKASI TAMBAHAN (SAMA UNTUK SEMUA) --}}
                        <div class="space-y-4 mt-6">
                            @if ($konseling->status_konseling == 'Ditolak' && !empty($konseling->alasan_penolakan))
                                <div class="p-4 bg-red-50 border-l-4 border-red-400">
                                    <h4 class="text-sm font-bold text-red-700">Pengajuan Ditolak</h4>
                                    <p class="mt-1 text-sm text-red-900">{{ $konseling->alasan_penolakan }}</p>
                                </div>
                            @endif

                            @if ($konseling->jadwal)
                                <div class="p-4 bg-green-50 border-l-4 border-green-400">
                                    <h4 class="text-sm font-bold text-green-800">Jadwal Telah Ditetapkan</h4>
                                    <div class="mt-2 text-sm text-green-900 space-y-1">
                                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($konseling->jadwal->waktu_mulai)->format('l, d F Y') }}</p>
                                        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($konseling->jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($konseling->jadwal->waktu_selesai)->format('H:i') }} WIB</p>
                                        <p><strong>Metode:</strong> {{ $konseling->jadwal->metode_konseling }}</p>
                                        @if ($konseling->jadwal->lokasi)
                                            <p><strong>Lokasi:</strong> {{ $konseling->jadwal->lokasi }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6 flex justify-start">
                        <a href="{{ route('mahasiswa.riwayat.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            Kembali ke Daftar Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>