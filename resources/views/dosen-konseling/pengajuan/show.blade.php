<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan Konseling
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-4">Data Mahasiswa</h3>
                    <dl class="text-sm space-y-3">
                        <div>
                            <dt class="font-medium text-gray-500">Nama</dt>
                            <dd class="text-gray-900">{{ $pengajuan->mahasiswa->nm_mhs ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">NIM</dt>
                            <dd class="text-gray-900">{{ $pengajuan->nim_mahasiswa }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Program Studi</dt>
                            <dd class="text-gray-900">{{ $pengajuan->mahasiswa->prodi->nm_prodi ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Angkatan</dt>
                            <dd class="text-gray-900">{{ $pengajuan->mahasiswa->angkatan ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Dosen Wali</dt>
                            <dd class="text-gray-900">{{ $pengajuan->mahasiswa->dosenWali->nm_dos ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="border-b pb-2 mb-4">
                        <h3 class="text-lg font-semibold">Detail Permasalahan</h3>
                        <p class="text-sm text-gray-500">
                            Diajukan oleh: 
                            <span class="font-bold">
                                {{ $pengajuan->sumber_pengajuan == 'dosen_pa' ? 'Dosen PA' : 'Mahasiswa' }}
                            </span>
                            pada {{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->translatedFormat('l, d F Y') }}
                        </p>
                    </div>

                    <div class="space-y-6 text-sm">
                        
                        {{-- Tampilkan Detail Sesuai Sumber Pengajuan --}}
                        @if ($pengajuan->sumber_pengajuan == 'dosen_pa')
                            <div>
                                <p class="font-medium text-gray-500">Aspek Permasalahan</p>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach (json_decode($pengajuan->aspek_permasalahan) ?? [] as $aspek)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">{{ ucfirst($aspek) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-500">Permasalahan yang Perlu Segera Diatasi</p>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-md whitespace-pre-wrap">{{ $pengajuan->permasalahan_segera ?? 'Tidak ada data.' }}</p>
                            </div>
                             <div>
                                <p class="font-medium text-gray-500">Upaya yang Sudah Dilakukan Dosen PA</p>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-md whitespace-pre-wrap">{{ $pengajuan->upaya_dilakukan ?? 'Tidak ada data.' }}</p>
                            </div>
                             <div>
                                <p class="font-medium text-gray-500">Harapan Dosen PA</p>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-md whitespace-pre-wrap">{{ $pengajuan->harapan_pa ?? 'Tidak ada data.' }}</p>
                            </div>
                        @else
                            {{-- Tampilan jika pengajuan dari mahasiswa --}}
                            <div>
                                <p class="font-medium text-gray-500">Keluhan yang Disampaikan Mahasiswa</p>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-md whitespace-pre-wrap">{{ $pengajuan->permasalahan ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                        @endif

                        @if ($pengajuan->status_konseling == 'menunggu_verifikasi')
                            <div class="border-t pt-4 mt-6">
                                <h4 class="font-semibold mb-2">Tindakan Verifikasi</h4>
                                <form action="{{ route('dosen-konseling.pengajuan.updateStatus', $pengajuan->id_konseling) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center space-x-4">
                                        <button type="submit" name="status" value="diterima" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                            Setujui & Jadwalkan
                                        </button>
                                        <button type="submit" name="status" value="ditolak" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                            Tolak
                                        </button>
                                    </div>
                                    <div class="mt-4">
                                        <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700">Alasan Penolakan (jika ditolak)</label>
                                        <textarea name="alasan_penolakan" id="alasan_penolakan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                    </div>
                                </form>
                            </div>
                        @else
                             <div class="border-t pt-4 mt-6">
                                <h4 class="font-semibold mb-2">Status Pengajuan</h4>
                                <p class="px-3 py-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($pengajuan->status_konseling == 'disetujui' || $pengajuan->status_konseling == 'terjadwal') bg-blue-100 text-blue-800 @endif
                                    @if($pengajuan->status_konseling == 'selesai') bg-green-100 text-green-800 @endif
                                    @if($pengajuan->status_konseling == 'ditolak') bg-red-100 text-red-800 @endif
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $pengajuan->status_konseling)) }}
                                </p>
                             </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>