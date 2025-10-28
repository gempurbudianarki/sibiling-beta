<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Menampilkan notifikasi sukses/error jika ada --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-300 dark:border-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-300 dark:border-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-end mb-4">
                        <x-primary-button as="a" :href="route('mahasiswa.pengajuan.create')">
                            Buat Pengajuan Baru
                        </x-primary-button>
                    </div>

                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal Pengajuan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sumber Pengajuan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Permasalahan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayat as $konseling)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $konseling->tgl_pengajuan->format('d M Y') }}
                                    </td>
                                    
                                    {{-- KOLOM BARU: SUMBER PENGAJUAN --}}
                                    <td class="px-6 py-4">
                                        @if ($konseling->sumber_pengajuan == 'dosen_pa')
                                            <span class="px-2 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full dark:bg-purple-900 dark:text-purple-300">
                                                Diajukan Dosen Wali
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                                Mandiri
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        {{-- Menampilkan deskripsi masalah dari mahasiswa, atau 'permasalahan' (dari Dosen Wali) jika deskripsi masih kosong --}}
                                        {{ Str::limit($konseling->deskripsi_masalah ?? $konseling->permasalahan, 50) }}
                                    </td>
                                    
                                    {{-- KOLOM STATUS (DENGAN LOGIKA BARU) --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $status = $konseling->status_konseling;
                                            $badgeColor = 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'; // Default
                                            
                                            if ($status == 'Menunggu Verifikasi') {
                                                $badgeColor = 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300';
                                            } elseif ($status == 'Menunggu Kelengkapan Mahasiswa') {
                                                $badgeColor = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                                            } elseif ($status == 'Perlu Revisi') {
                                                $badgeColor = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                            } elseif ($status == 'Disetujui') {
                                                $badgeColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                                            } elseif ($status == 'Selesai') {
                                                $badgeColor = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                            }
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColor }}">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    {{-- KOLOM AKSI (DENGAN LOGIKA BARU) --}}
                                    <td class="px-6 py-4">
                                        @if ($konseling->status_konseling == 'Menunggu Kelengkapan Mahasiswa')
                                            {{-- Tombol untuk alur baru (Dosen Wali) --}}
                                            <a href="{{ route('mahasiswa.pengajuan.lengkapi', $konseling) }}" class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline">
                                                Lengkapi
                                            </a>
                                        @elseif ($konseling->status_konseling == 'Perlu Revisi')
                                            {{-- Tombol untuk alur lama (Revisi) --}}
                                            <a href="{{ route('mahasiswa.pengajuan.edit', $konseling) }}" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline">
                                                Revisi
                                            </a>
                                        @else
                                            {{-- Tombol default --}}
                                            <a href="{{ route('mahasiswa.riwayat.show', $konseling) }}" class="font-medium text-gray-600 dark:text-gray-400 hover:underline">
                                                Lihat Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Anda belum memiliki riwayat pengajuan konseling.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>