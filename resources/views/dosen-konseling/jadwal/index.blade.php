<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Konseling Saya') }}
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
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jadwal</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi / Tipe</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($jadwal as $item)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->konseling->mahasiswa->nm_mhs ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->konseling->mahasiswa->nim ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->tgl_sesi)->translatedFormat('l, d M Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }} WIB</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $item->lokasi }}</div>
                                            <div class="text-sm text-gray-500 capitalize">{{ $item->jenis_sesi }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColor = match($item->status_sesi) {
                                                    'dijadwalkan' => 'bg-blue-100 text-blue-800',
                                                    'selesai' => 'bg-green-100 text-green-800',
                                                    'dibatalkan' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-700',
                                                };
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">{{ ucfirst($item->status_sesi) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if ($item->status_sesi === 'dijadwalkan')
                                                <a href="{{ route('dosen-konseling.jadwal.mulaiSesi', ['jadwal' => $item->id_jadwal]) }}"
                                                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs transition">
                                                    Mulai Sesi
                                                </a>
                                            @elseif ($item->status_sesi === 'selesai')
                                                <span class="text-gray-500 italic">Selesai</span>
                                            @elseif ($item->status_sesi === 'dibatalkan')
                                                <span class="text-red-500 italic">Dibatalkan</span>
                                            @endif {{-- <-- INI PENUTUP YANG HILANG --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-8 whitespace-nowrap text-center text-sm text-gray-500">Anda belum memiliki jadwal konseling.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $jadwal->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>