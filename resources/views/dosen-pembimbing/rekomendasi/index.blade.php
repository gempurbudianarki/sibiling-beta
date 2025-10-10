<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Rekomendasi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl. Rekomendasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($rekomendasiDibuat as $konseling)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $konseling->mahasiswa->nm_mhs ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $konseling->nim_mahasiswa }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($konseling->tgl_pengajuan)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($konseling->status_konseling == 'menunggu_verifikasi') bg-yellow-100 text-yellow-800 @endif
                                                @if(in_array($konseling->status_konseling, ['disetujui', 'terjadwal'])) bg-blue-100 text-blue-800 @endif
                                                @if($konseling->status_konseling == 'selesai') bg-green-100 text-green-800 @endif
                                                @if($konseling->status_konseling == 'ditolak') bg-red-100 text-red-800 @endif
                                            ">
                                                {{ str_replace('_', ' ', $konseling->status_konseling) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Anda belum pernah membuat rekomendasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $rekomendasiDibuat->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>