<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berkas Kasus Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openDetail: false }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- BAGIAN 1: INFORMASI AWAL PENGAJUAN --}}
                    <div class="border-b pb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Ringkasan Kasus</h3>
                                <p class="text-sm text-gray-500 mt-1">Mahasiswa: <span class="font-medium text-indigo-600">{{ $konseling->mahasiswa->user->name }}</span> ({{ $konseling->nim_mahasiswa }})</p>
                            </div>
                            <button @click="openDetail = true" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Lihat Pengajuan Awal
                            </button>
                        </div>
                    </div>
                    
                    {{-- BAGIAN 2: RIWAYAT SESI KONSELING --}}
                    <div class="border-t mt-8 pt-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Riwayat Sesi</h3>
                        <div class="space-y-6">
                            @forelse ($konseling->jadwalSesi->sortBy('waktu_mulai') as $sesi)
                                <div class="bg-white border border-gray-200 rounded-lg p-4 transition-all hover:shadow-md">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-bold text-indigo-700">Sesi #{{ $loop->iteration }}</h4>
                                        <p class="text-xs text-gray-500">{{ $sesi->waktu_mulai->format('d M Y, H:i') }}</p>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-4">Metode: {{ $sesi->metode_konseling }} @if($sesi->lokasi) ({{ $sesi->lokasi }}) @endif</p>
                                    
                                    @if ($sesi->hasilKonseling)
                                        <dl class="text-sm space-y-3 mt-4 border-t pt-4">
                                            <div>
                                                <dt class="font-semibold text-gray-600">Diagnosis</dt>
                                                <dd class="pl-4 border-l-2 mt-1 text-gray-800">{{ $sesi->hasilKonseling->diagnosis }}</dd>
                                            </div>
                                            <div>
                                                <dt class="font-semibold text-gray-600">Prognosis</dt>
                                                <dd class="pl-4 border-l-2 mt-1 text-gray-800">{{ $sesi->hasilKonseling->prognosis }}</dd>
                                            </div>
                                             <div>
                                                <dt class="font-semibold text-gray-600">Rekomendasi</dt>
                                                <dd class="pl-4 border-l-2 mt-1 text-gray-800">{{ $sesi->hasilKonseling->rekomendasi }}</dd>
                                            </div>
                                        </dl>
                                        @if ($loop->last && $konseling->status_konseling == 'Butuh Sesi Lanjutan')
                                            <div class="mt-4 bg-yellow-50 text-yellow-800 text-sm font-semibold p-3 rounded-lg">Status Akhir Sesi: {{ $konseling->status_konseling }}</div>
                                        @elseif($loop->last && $konseling->status_konseling == 'Selesai')
                                             <div class="mt-4 bg-purple-50 text-purple-800 text-sm font-semibold p-3 rounded-lg">Status Akhir Sesi: {{ $konseling->status_konseling }}</div>
                                        @endif
                                    @else
                                        <p class="text-sm italic text-green-600 bg-green-50 p-2 rounded-md">Sesi ini telah dijadwalkan dan menunggu pelaksanaan.</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 italic">Belum ada sesi yang dilaksanakan untuk kasus ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6 flex justify-start">
                        <a href="{{ route('dosen-konseling.kasus.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                            &larr; Kembali ke Daftar Kasus
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openDetail" @keydown.window.escape="openDetail = false" class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="openDetail" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openDetail = false" aria-hidden="true"></div>
                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                    <div x-show="openDetail" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md">
                        <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                            <div class="py-6 px-4 bg-indigo-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white" id="slide-over-title">Detail Pengajuan Awal</h2>
                                    <div class="ml-3 h-7 flex items-center">
                                        <button @click="openDetail = false" type="button" class="bg-indigo-700 rounded-md text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex-1 py-6 px-4 sm:px-6">
                                @if ($konseling->sumber_pengajuan == 'mahasiswa')
                                    <div class="space-y-6 text-sm">
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-2">Informasi Pengajuan</h4>
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                                                <div><dt class="font-medium text-gray-500">Bidang Layanan</dt><dd class="mt-1 text-gray-900 capitalize">{{ $konseling->bidang_layanan }}</dd></div>
                                                <div><dt class="font-medium text-gray-500">Jenis Konseli</dt><dd class="mt-1 text-gray-900 capitalize">{{ $konseling->jenis_konseli }}</dd></div>
                                                <div><dt class="font-medium text-gray-500">Tujuan Konseling</dt><dd class="mt-1 text-gray-900">{{ $konseling->tujuan_konseling }}</dd></div>
                                                <div><dt class="font-medium text-gray-500">Deskripsi Masalah</dt><dd class="mt-1 text-gray-900">{{ $konseling->deskripsi_masalah }}</dd></div>
                                            </dl>
                                        </div>
                                        <div class="border-t pt-6">
                                            <h4 class="font-semibold text-gray-800 mb-4">Hasil Asesmen Singkat</h4>
                                            @php $questions = [1 => 'Merasa lelah?', 2 => 'Merasa cemas?', 3 => 'Merasa gugup?', 4 => 'Merasa putus asa?', 5 => 'Merasa gelisah?', 6 => 'Tidak bisa duduk tenang?', 7 => 'Merasa tertekan?', 8 => 'Sulit melakukan sesuatu?', 9 => 'Merasa sangat sedih?', 10 => 'Merasa tidak berharga?']; @endphp
                                            <ul class="space-y-3">
                                                @foreach($konseling->hasil_asesmen as $index => $jawaban)
                                                    <li><p class="font-medium text-gray-600">{{ $questions[$index] ?? "Pertanyaan #{$index}" }}</p><p class="text-indigo-600 font-semibold">{{ $jawaban }}</p></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="space-y-4 text-sm">
                                        <div><dt class="font-medium text-gray-500">Aspek Permasalahan</dt><dd class="mt-1">{{ implode(', ', $konseling->aspek_permasalahan) }}</dd></div>
                                        <div><dt class="font-medium text-gray-500">Permasalahan Mendesak</dt><dd class="mt-1">{{ $konseling->permasalahan_segera }}</dd></div>
                                        <div><dt class="font-medium text-gray-500">Upaya Dosen PA</dt><dd class="mt-1">{{ $konseling->upaya_dilakukan }}</dd></div>
                                        <div><dt class="font-medium text-gray-500">Harapan Dosen PA</dt><dd class="mt-1">{{ $konseling->harapan_pa }}</dd></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>