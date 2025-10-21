<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat & Manajemen Kasus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4" role="alert">
                    <p class="font-bold text-green-800">Berhasil!</p>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Semua Kasus yang Telah Ditangani</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Masuk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($riwayatKasus as $kasus)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $kasus->tgl_pengajuan->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $kasus->mahasiswa->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @php
                                                $statusColor = match($kasus->status_konseling) {
                                                    'Butuh Sesi Lanjutan' => 'bg-yellow-100 text-yellow-800',
                                                    'Selesai' => 'bg-purple-100 text-purple-800',
                                                    default => 'bg-green-100 text-green-800',
                                                };
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                                {{ $kasus->status_konseling }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            {{-- ================== TOMBOL AKSI KONDISIONAL ================== --}}
                                            @if ($kasus->status_konseling == 'Butuh Sesi Lanjutan')
                                                <a href="{{ route('dosen-konseling.jadwal.create', $kasus->id_konseling) }}" class="text-green-600 hover:text-green-900 font-bold">Atur Jadwal Baru &rarr;</a>
                                            @else
                                                <a href="{{ route('dosen-konseling.kasus.show', $kasus->id_konseling) }}" class="text-indigo-600 hover:text-indigo-900">Lihat File Kasus</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada riwayat kasus yang selesai atau sedang berjalan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $riwayatKasus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>