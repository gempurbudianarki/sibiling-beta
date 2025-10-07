<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('status') === 'verifikasi-success')
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            Status pengajuan berhasil diperbarui.
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($konselingTersedia as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->mahasiswa->nm_mhs ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->nim_mahasiswa }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->tgl_pengajuan)->isoFormat('D MMMM YYYY') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->status_konseling == 'Diajukan')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                            @elseif($item->status_konseling == 'Terverifikasi')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Siap Dijadwalkan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($item->status_konseling == 'Diajukan')
                                                <a href="{{ route('dosen-konseling.pengajuan.show', $item->id_konseling) }}" class="text-indigo-600 hover:text-indigo-900">Verifikasi</a>
                                            @elseif($item->status_konseling == 'Terverifikasi' && $item->jadwal->isEmpty())
                                                <a href="{{ route('dosen-konseling.jadwal.create', $item->id_konseling) }}" class="text-green-600 hover:text-green-900 font-bold">Buat Jadwal</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada pengajuan yang perlu diverifikasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $konselingTersedia->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>