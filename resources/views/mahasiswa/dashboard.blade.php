<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Selamat Datang Kembali, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-sm text-gray-600">Ini adalah ringkasan aktivitas bimbingan konseling Anda.</p>

                    {{-- ================== KARTU STATUS KONSULTASI ================== --}}
                    <div class="mt-6 border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-800 mb-4">Status Pengajuan Terakhir Anda</h4>

                        @if ($konselingTerakhir)
                            @php
                                $status = $konselingTerakhir->status_konseling;
                                $statusInfo = match($status) {
                                    'Menunggu Verifikasi' => [
                                        'bgColor' => 'bg-gray-50', 'borderColor' => 'border-gray-400',
                                        'textColor' => 'text-gray-800', 'titleColor' => 'text-gray-700',
                                        'title' => 'Pengajuan Terkirim',
                                        'message' => 'Pengajuan Anda telah kami terima pada tanggal ' . $konselingTerakhir->tgl_pengajuan->format('d F Y') . ' dan sedang menunggu verifikasi oleh Dosen Konseling.'
                                    ],
                                    'Disetujui' => [
                                        'bgColor' => 'bg-blue-50', 'borderColor' => 'border-blue-400',
                                        'textColor' => 'text-blue-900', 'titleColor' => 'text-blue-700',
                                        'title' => 'Pengajuan Disetujui!',
                                        'message' => 'Kabar baik! Pengajuan Anda telah disetujui. Mohon tunggu informasi jadwal konseling dari Dosen Konseling.'
                                    ],
                                    'Terjadwal' => [
                                        'bgColor' => 'bg-green-50', 'borderColor' => 'border-green-400',
                                        'textColor' => 'text-green-900', 'titleColor' => 'text-green-700',
                                        'title' => 'Jadwal Ditetapkan!',
                                        'message' => 'Sesi konseling Anda telah dijadwalkan. Silakan periksa detailnya di menu Riwayat Konseling.'
                                    ],
                                    'Selesai' => [
                                        'bgColor' => 'bg-purple-50', 'borderColor' => 'border-purple-400',
                                        'textColor' => 'text-purple-900', 'titleColor' => 'text-purple-700',
                                        'title' => 'Proses Konseling Selesai',
                                        'message' => 'Siklus konseling untuk pengajuan ini telah selesai. Anda dapat melihat hasilnya di halaman riwayat.'
                                    ],
                                    'Ditolak' => [
                                        'bgColor' => 'bg-red-50', 'borderColor' => 'border-red-400',
                                        'textColor' => 'text-red-900', 'titleColor' => 'text-red-700',
                                        'title' => 'Pengajuan Ditolak',
                                        'message' => 'Mohon maaf, pengajuan Anda ditolak. Silakan cek halaman riwayat untuk melihat alasannya.'
                                    ],
                                    'Perlu Revisi' => [
                                        'bgColor' => 'bg-yellow-50', 'borderColor' => 'border-yellow-400',
                                        'textColor' => 'text-yellow-900', 'titleColor' => 'text-yellow-700',
                                        'title' => 'Pengajuan Perlu Revisi',
                                        'message' => 'Ada beberapa data yang perlu Anda perbaiki. Silakan periksa detailnya di menu Riwayat Konseling dan ajukan kembali.'
                                    ],
                                    default => [
                                        'bgColor' => 'bg-gray-50', 'borderColor' => 'border-gray-400',
                                        'textColor' => 'text-gray-800', 'titleColor' => 'text-gray-700',
                                        'title' => 'Status Tidak Dikenal',
                                        'message' => 'Terjadi kesalahan dalam membaca status.'
                                    ],
                                };
                            @endphp
                            
                            <div class="p-4 {{ $statusInfo['bgColor'] }} border-l-4 {{ $statusInfo['borderColor'] }}">
                                <h5 class="font-bold {{ $statusInfo['titleColor'] }}">{{ $statusInfo['title'] }}</h5>
                                <p class="text-sm {{ $statusInfo['textColor'] }}">{{ $statusInfo['message'] }}</p>
                            </div>

                            <div class="mt-4 flex gap-4">
                                <a href="{{ route('mahasiswa.riwayat.show', $konselingTerakhir->id_konseling) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Lihat Detail Pengajuan
                                </a>
                                <a href="{{ route('mahasiswa.riwayat.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Lihat Semua Riwayat
                                </a>
                            </div>

                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 mb-4">Anda belum pernah mengajukan konseling. <br> Jangan ragu untuk memulai jika Anda membutuhkan bantuan.</p>
                                <a href="{{ route('mahasiswa.pengajuan.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Mulai Ajukan Konseling
                                </a>
                            </div>
                        @endif
                    </div>
                     {{-- =============================================================== --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>