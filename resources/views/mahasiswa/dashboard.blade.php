<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Pesan Sukses atau Error dari session --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                 <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Cek apakah ada konseling yang sedang aktif --}}
                    @if ($konselingAktif)
                        {{-- KARTU STATUS KONSELING AKTIF --}}
                        <div class="border-l-4 border-indigo-500 bg-indigo-50 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-indigo-800">Anda memiliki 1 Sesi Konseling Aktif</h3>
                                    <div class="mt-2 text-sm text-indigo-700">
                                        <p>
                                            Status pengajuan Anda saat ini adalah:
                                            <span class="font-semibold">{{ $konselingAktif->status_konseling }}</span>.
                                        </p>
                                        @if ($konselingAktif->status_konseling == 'Dijadwalkan' && $konselingAktif->jadwal)
                                            <div class="mt-3 p-3 bg-indigo-100 rounded-md border border-indigo-200">
                                                <p class="font-semibold">Detail Jadwal Konseling:</p>
                                                <ul class="list-disc list-inside mt-1">
                                                    <li><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($konselingAktif->jadwal->tgl_konseling)->translatedFormat('l, d F Y') }}</li>
                                                    <li><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($konselingAktif->jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($konselingAktif->jadwal->waktu_selesai)->format('H:i') }} WIB</li>
                                                    <li><strong>Dosen Konselor:</strong> {{ $konselingAktif->jadwal->dosenKonseling->nm_dos ?? 'Belum ditentukan' }}</li>
                                                    <li><strong>Ruangan:</strong> {{ $konselingAktif->jadwal->ruangan ?? 'Informasi menyusul' }}</li>
                                                </ul>
                                            </div>
                                        @else
                                             <p class="mt-2">Silakan tunggu informasi selanjutnya dari dosen konselor.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- KARTU SELAMAT DATANG & AJAKAN PENGAJUAN --}}
                        <div class="text-center">
                             <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                             <p class="mt-2 text-gray-600">
                                Anda saat ini tidak memiliki sesi konseling yang sedang berjalan. <br>
                                Jika Anda memerlukan bantuan, jangan ragu untuk mengajukan sesi konseling.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('mahasiswa.pengajuan.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Ajukan Konseling Sekarang
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Total Pengajuan</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalKonseling }} Sesi</dd>
                            </div>
                             <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Dosen Wali</dt>
                                @if ($dosenWali)
                                    <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $dosenWali->nm_dos }}</dd>
                                    <dd class="text-sm text-gray-600">{{ $dosenWali->email_dos }}</dd>
                                @else
                                    <dd class="mt-1 text-xl font-semibold text-gray-500 italic">Belum terhubung</dd>
                                @endif
                            </div>
                        </dl>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>