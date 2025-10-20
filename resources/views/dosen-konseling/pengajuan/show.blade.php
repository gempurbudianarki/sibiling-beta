<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 space-y-6">
                        
                        {{-- INFO DASAR MAHASISWA --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-4">Informasi Mahasiswa</h3>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <dt class="font-medium text-gray-500">Nama Mahasiswa</dt>
                                    <dd class="mt-1 text-gray-900">{{ $pengajuan->mahasiswa->user->name ?? $pengajuan->mahasiswa->nama_mhs }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">NIM</dt>
                                    <dd class="mt-1 text-gray-900">{{ $pengajuan->nim_mahasiswa }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Program Studi</dt>
                                    <dd class="mt-1 text-gray-900">{{ $pengajuan->mahasiswa->prodi->nama_prodi ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Tanggal Pengajuan</dt>
                                    <dd class="mt-1 text-gray-900">{{ $pengajuan->tgl_pengajuan->format('d F Y') }}</dd>
                                </div>
                            </dl>
                        </div>

                        {{-- ================== KONTEN KONDISIONAL BARU ================== --}}
                        @if ($pengajuan->sumber_pengajuan == 'mahasiswa')
                            {{-- TAMPILAN JIKA DARI PENGAJUAN MANDIRI MAHASISWA --}}
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-4">Detail Pengajuan Mahasiswa</h3>
                                <dl class="space-y-4 text-sm">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <dt class="font-medium text-gray-500">Bidang Layanan</dt>
                                            <dd class="mt-1 text-gray-900 capitalize">{{ $pengajuan->bidang_layanan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-500">Jenis Konseli</dt>
                                            <dd class="mt-1 text-gray-900 capitalize">{{ $pengajuan->jenis_konseli }}</dd>
                                        </div>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Tujuan Konseling</dt>
                                        <dd class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $pengajuan->tujuan_konseling }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Deskripsi Masalah Saat Ini</dt>
                                        <dd class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $pengajuan->deskripsi_masalah }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-4">Hasil Asesmen Singkat</h3>
                                @php
                                    $questions = [
                                        1 => 'Merasa lelah tanpa sebab yang jelas?',
                                        2 => 'Merasa cemas atau khawatir?',
                                        3 => 'Merasa sangat gugup?',
                                        4 => 'Merasa putus asa?',
                                        5 => 'Merasa gelisah atau tidak tenang?',
                                        6 => 'Merasa sangat gelisah sehingga tidak dapat duduk tenang?',
                                        7 => 'Merasa tertekan?',
                                        8 => 'Merasa perlu berusaha keras untuk melakukan segala hal?',
                                        9 => 'Merasa sangat sedih?',
                                        10 => 'Merasa tidak berharga atau tidak berarti?',
                                    ];
                                @endphp
                                <ul class="space-y-4">
                                    @foreach($pengajuan->hasil_asesmen as $index => $jawaban)
                                        <li class="text-sm flex items-start">
                                            <span class="font-semibold text-gray-500 w-2/3">{{ $questions[$index] ?? "Pertanyaan #{$index}" }}</span>
                                            <span class="font-bold text-indigo-600 w-1/3">: {{ $jawaban }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        @elseif ($pengajuan->sumber_pengajuan == 'dosen_pa')
                             {{-- TAMPILAN JIKA DARI REKOMENDASI DOSEN PA --}}
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-4">Detail Rekomendasi dari Dosen PA</h3>
                                <dl class="space-y-4 text-sm">
                                    <div>
                                        <dt class="font-medium text-gray-500">Aspek Permasalahan</dt>
                                        <dd class="mt-1">
                                            @foreach($pengajuan->aspek_permasalahan as $aspek)
                                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $aspek }}</span>
                                            @endforeach
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Permasalahan Mendesak</dt>
                                        <dd class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $pengajuan->permasalahan_segera }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Upaya yang Telah Dilakukan Dosen PA</dt>
                                        <dd class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $pengajuan->upaya_dilakukan }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Harapan Dosen PA</dt>
                                        <dd class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $pengajuan->harapan_pa }}</dd>
                                    </div>
                                </dl>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="md:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-4">Tindakan Verifikasi</h3>

                        <form action="{{ route('dosen-konseling.pengajuan.updateStatus', $pengajuan->id_konseling) }}" method="POST" x-data="{ status: '{{ $pengajuan->status_konseling }}' }">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label for="status_konseling" :value="__('Ubah Status Menjadi:')" />
                                <select id="status_konseling" name="status_konseling" x-model="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Menunggu Verifikasi" disabled>-- Pilih Status --</option>
                                    <option value="Disetujui">Disetujui (Lanjut ke Penjadwalan)</option>
                                    <option value="Perlu Revisi">Perlu Revisi (Kembalikan ke Mahasiswa)</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_konseling')" class="mt-2" />
                            </div>

                            <div x-show="status === 'Ditolak'" x-transition class="mt-4">
                                <x-input-label for="alasan_penolakan" :value="__('Alasan Penolakan (Wajib diisi)')" />
                                <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alasan_penolakan') }}</textarea>
                                <x-input-error :messages="$errors->get('alasan_penolakan')" class="mt-2" />
                            </div>
                            
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Simpan Status') }}
                                </x-primary-button>
                            </div>
                        </form>

                        @if ($pengajuan->status_konseling == 'Disetujui')
                            <div class="mt-6 pt-4 border-t">
                                <p class="text-sm text-gray-600 mb-2">Pengajuan ini telah disetujui.</p>
                                <a href="{{ route('dosen-konseling.jadwal.create', $pengajuan->id_konseling) }}" class="w-full text-center inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Buat Jadwal
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>