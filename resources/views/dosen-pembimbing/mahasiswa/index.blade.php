<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mahasiswa Bimbingan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Mahasiswa
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Angkatan / Prodi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status Konseling Terakhir
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($mahasiswaBimbingan as $mahasiswa)
                                    @php
                                        // Cari konseling terakhir yang diajukan oleh Dosen PA ini
                                        $konselingTerakhir = $mahasiswa->konseling
                                            ->where('rekomendation_dari', Auth::user()->dosen->email_dos)
                                            ->sortByDesc('tgl_pengajuan')
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $mahasiswa->nm_mhs }}</div>
                                            <div class="text-sm text-gray-500">{{ $mahasiswa->nim }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $mahasiswa->angkatan }}</div>
                                            <div class="text-sm text-gray-500">{{ $mahasiswa->prodi->nm_prodi ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($konselingTerakhir)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($konselingTerakhir->status_konseling == 'menunggu_verifikasi') bg-yellow-100 text-yellow-800 @endif
                                                    @if($konselingTerakhir->status_konseling == 'disetujui' || $konselingTerakhir->status_konseling == 'terjadwal') bg-blue-100 text-blue-800 @endif
                                                    @if($konselingTerakhir->status_konseling == 'selesai') bg-green-100 text-green-800 @endif
                                                    @if($konselingTerakhir->status_konseling == 'ditolak' || $konselingTerakhir->status_konseling == 'revisi') bg-red-100 text-red-800 @endif
                                                ">
                                                    {{ str_replace('_', ' ', $konselingTerakhir->status_konseling) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">Belum ada riwayat</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if ($konselingTerakhir && $konselingTerakhir->status_konseling == 'revisi')
                                                <a href="{{ route('dosen-pembimbing.rekomendasi.edit', $konselingTerakhir->id_konseling) }}" class="text-red-600 hover:text-red-900 font-bold">
                                                    Edit Rekomendasi (Revisi)
                                                </a>
                                            @elseif (!$konselingTerakhir || in_array($konselingTerakhir->status_konseling, ['selesai', 'ditolak']))
                                                <a href="{{ route('dosen-pembimbing.rekomendasi.create', ['mahasiswa' => $mahasiswa->nim]) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    Rekomendasikan
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Proses berjalan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            Anda belum memiliki mahasiswa bimbingan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $mahasiswaBimbingan->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>