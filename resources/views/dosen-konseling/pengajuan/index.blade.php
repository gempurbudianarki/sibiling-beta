<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Tugas Pengajuan') }}
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
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Kasus Aktif yang Memerlukan Tindakan</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Masuk
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Mahasiswa
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sumber
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status Saat Ini
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tindakan Berikutnya
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($daftarTugas as $konseling)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $konseling->tgl_pengajuan->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $konseling->mahasiswa->user->name ?? $konseling->mahasiswa->nama_mhs }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($konseling->sumber_pengajuan == 'dosen_pa')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Rekomendasi Dosen PA
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Pengajuan Mandiri
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                             @php
                                                $statusColor = $konseling->status_konseling == 'Disetujui' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                                {{ $konseling->status_konseling }}
                                            </span>
                                        </td>
                                        {{-- ================== TOMBOL AKSI KONDISIONAL ================== --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if ($konseling->status_konseling == 'Menunggu Verifikasi')
                                                <a href="{{ route('dosen-konseling.pengajuan.show', $konseling->id_konseling) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    Lihat Detail & Verifikasi
                                                </a>
                                            @elseif ($konseling->status_konseling == 'Disetujui')
                                                <a href="{{ route('dosen-konseling.jadwal.create', $konseling->id_konseling) }}" class="font-bold text-green-600 hover:text-green-900">
                                                    Buat Jadwal &rarr;
                                                </a>
                                            @endif
                                        </td>
                                        {{-- ================================================================ --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Tidak ada tugas atau pengajuan aktif yang memerlukan tindakan Anda.
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