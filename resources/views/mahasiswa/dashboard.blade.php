<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Menampilkan notifikasi sukses atau error --}}
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
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="mt-2">
                        Ini adalah halaman dashboard Anda. Di sini Anda dapat melihat status pengajuan konseling dan riwayat Anda.
                    </p>
                </div>
            </div>

            {{-- Widget status konseling --}}
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="font-semibold">Status Konseling Anda</h4>
                    
                    @if ($konseling)
                        @php
                            $status = $konseling->status_konseling;
                            $statusClass = '';
                            if ($status == 'Menunggu Verifikasi') $statusClass = 'bg-yellow-100 text-yellow-800';
                            elseif ($status == 'Terverifikasi' || $status == 'Terjadwal') $statusClass = 'bg-blue-100 text-blue-800';
                            elseif ($status == 'Selesai') $statusClass = 'bg-green-100 text-green-800';
                            elseif ($status == 'Ditolak' || $status == 'Revisi Diperlukan') $statusClass = 'bg-red-100 text-red-800';
                        @endphp
                        <p class="mt-2 text-gray-700">
                            Pengajuan terakhir Anda pada tanggal <strong>{{ \Carbon\Carbon::parse($konseling->tgl_pengajuan)->translatedFormat('d F Y') }}</strong> memiliki status:
                        </p>
                        <div class="mt-2">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $status }}
                            </span>
                        </div>
                        @if ($status == 'Revisi Diperlukan' && $konseling->alasan_penolakan)
                            <div class="mt-3 border-l-4 border-yellow-400 bg-yellow-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.21 3.03-1.742 3.03H4.42c-1.532 0-2.492-1.696-1.742-3.03l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            <strong>Catatan dari Konselor:</strong> {{ $konseling->alasan_penolakan }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @else
                        <p class="mt-2 text-gray-600">
                           Anda belum memiliki riwayat pengajuan konseling.
                        </p>
                    @endif
                    
                    <div class="mt-6 border-t pt-4">
                        @php
                            $hasActiveCounseling = $konseling && !in_array($konseling->status_konseling, ['Selesai', 'Ditolak']);
                        @endphp

                        @if (!$hasActiveCounseling)
                            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Ajukan Konseling Baru
                            </a>
                        @else
                            <p class="text-sm text-gray-500 italic">Anda tidak dapat mengajukan sesi baru karena masih ada sesi konseling yang aktif.</p>
                        @endif

                        <a href="{{ route('mahasiswa.riwayat.index') }}" class="ml-4 text-sm text-blue-500 hover:underline">Lihat Semua Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>