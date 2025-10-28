<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Informasi Pengajuan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-semibold">Tanggal Pengajuan:</span>
                            {{ $pengajuan->tgl_pengajuan->format('d M Y') }}
                        </div>
                        <div>
                            <span class="font-semibold">Status Saat Ini:</span>
                             @php
                                $status = $pengajuan->status_konseling;
                                $badgeColor = 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'; // Default
                                if ($status == 'Menunggu Verifikasi') $badgeColor = 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300';
                                elseif ($status == 'Disetujui') $badgeColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                                elseif ($status == 'Ditolak' || $status == 'Perlu Revisi') $badgeColor = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                elseif ($status == 'Selesai') $badgeColor = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColor }}">
                                {{ $status }}
                            </span>
                        </div>
                        <div>
                            <span class="font-semibold">Sumber Pengajuan:</span>
                             @if ($pengajuan->sumber_pengajuan == 'dosen_pa')
                                <span class="text-purple-700 dark:text-purple-300">Diajukan Dosen Wali</span>
                            @else
                                <span class="text-blue-700 dark:text-blue-300">Mandiri oleh Mahasiswa</span>
                            @endif
                        </div>
                         @if($pengajuan->persetujuan_diberikan_pada)
                        <div>
                            <span class="font-semibold">Persetujuan Diberikan:</span>
                            {{ \Carbon\Carbon::parse($pengajuan->persetujuan_diberikan_pada)->format('d M Y H:i') }}
                        </div>
                        @endif
                    </div>

                    {{-- Form Aksi (Setujui/Tolak/Revisi) --}}
                    @if ($pengajuan->status_konseling == 'Menunggu Verifikasi')
                        <hr class="my-6 border-gray-300 dark:border-gray-700">
                        <h4 class="text-md font-medium mb-4">Aksi Verifikasi</h4>
                        <form action="{{ route('dosen-konseling.pengajuan.updateStatus', $pengajuan->id_konseling) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-input-label for="status_konseling" :value="__('Ubah Status Menjadi:')" />
                                <select name="status_konseling" id="status_konseling" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="Disetujui">Disetujui (Lanjut ke Penjadwalan)</option>
                                    <option value="Ditolak">Ditolak</option>
                                    <option value="Perlu Revisi">Perlu Revisi (Kembalikan ke Mahasiswa)</option>
                                </select>
                            </div>
                            <div class="mb-4" id="alasan-penolakan-div" style="display: none;">
                                <x-input-label for="alasan_penolakan" :value="__('Alasan Penolakan / Catatan Revisi')" />
                                <textarea name="alasan_penolakan" id="alasan_penolakan" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                <x-input-error :messages="$errors->get('alasan_penolakan')" class="mt-2" />
                            </div>
                            <div class="flex justify-end">
                                <x-primary-button>
                                    {{ __('Simpan Status') }}
                                </x-primary-button>
                            </div>
                        </form>
                         <script>
                            document.getElementById('status_konseling').addEventListener('change', function () {
                                var alasanDiv = document.getElementById('alasan-penolakan-div');
                                var alasanTextarea = document.getElementById('alasan_penolakan');
                                if (this.value === 'Ditolak' || this.value === 'Perlu Revisi') {
                                    alasanDiv.style.display = 'block';
                                    alasanTextarea.setAttribute('required', 'required');
                                } else {
                                    alasanDiv.style.display = 'none';
                                    alasanTextarea.removeAttribute('required');
                                }
                            });
                             // Trigger change on page load if needed
                             document.getElementById('status_konseling').dispatchEvent(new Event('change'));
                        </script>
                    @elseif($pengajuan->status_konseling == 'Disetujui')
                         <hr class="my-6 border-gray-300 dark:border-gray-700">
                         <div class="flex justify-end">
                              <x-primary-button as="a" :href="route('dosen-konseling.jadwal.create', $pengajuan->id_konseling)">
                                Buat Jadwal Sesi
                            </x-primary-button>
                         </div>
                    @endif

                </div>
            </div>

             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Data Diri Mahasiswa</h3>
                    @if($pengajuan->mahasiswa)
                        @php $mhs = $pengajuan->mahasiswa; @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div><span class="font-semibold">Nama:</span> {{ $mhs->user->name ?? '-' }}</div>
                            <div><span class="font-semibold">NIM:</span> {{ $mhs->nim ?? '-' }}</div>
                            <div><span class="font-semibold">Prodi:</span> {{ $mhs->prodi->nama_prodi ?? '-' }}</div>
                            <div><span class="font-semibold">Email:</span> {{ $mhs->email ?? '-' }}</div>
                            <div><span class="font-semibold">No. HP/WA:</span> {{ $mhs->no_hp ?? '-' }}</div>
                        </div>
                    @else
                         <p class="text-sm text-red-600 dark:text-red-400">Data mahasiswa tidak ditemukan.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Detail Permasalahan (dari Mahasiswa)</h3>
                     <div class="space-y-4 text-sm">
                         <div>
                             <span class="font-semibold block mb-1">Status Konseli:</span>
                             <p class="p-2 bg-gray-100 dark:bg-gray-700 rounded-md">{{ $pengajuan->tipe_konseli ?? '-' }}</p>
                         </div>
                         <div>
                             <span class="font-semibold block mb-1">Jenis Permasalahan Dipilih:</span>
                              @if(!empty($pengajuan->jenis_permasalahan) && is_array($pengajuan->jenis_permasalahan))
                                <div class="flex flex-wrap gap-2">
                                    @foreach($pengajuan->jenis_permasalahan as $jenis)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            {{ $jenis }}
                                        </span>
                                    @endforeach
                                </div>
                              @else
                                <p class="text-gray-500 dark:text-gray-400">-</p>
                              @endif
                         </div>
                         <div>
                             <span class="font-semibold block mb-1">Kondisi Saat Ini (Keluhan):</span>
                             <p class="p-2 bg-gray-100 dark:bg-gray-700 rounded-md whitespace-pre-wrap">{{ $pengajuan->deskripsi_masalah ?? '-' }}</p>
                         </div>
                         <div>
                             <span class="font-semibold block mb-1">Tujuan Membutuhkan Layanan:</span>
                             <p class="p-2 bg-gray-100 dark:bg-gray-700 rounded-md whitespace-pre-wrap">{{ $pengajuan->tujuan_konseling ?? '-' }}</p>
                         </div>
                     </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Hasil Asesmen Kondisi Psikologis (K10)</h3>
                    @php
                        $k10_answers = $pengajuan->asesmen_k10 ?? [];
                        $k10_questions = [
                            1 => 'Merasa lelah tanpa sebab yang jelas?',
                            2 => 'Merasa cemas atau khawatir?',
                            3 => 'Merasa sangat gugup sehingga tidak ada yang dapat menenangkan?',
                            4 => 'Merasa putus asa?',
                            5 => 'Merasa gelisah atau tidak tenang?',
                            6 => 'Merasa sangat gelisah sehingga tidak dapat duduk tenang?',
                            7 => 'Merasa tertekan?',
                            8 => 'Merasa perlu berusaha keras untuk melakukan segala hal?',
                            9 => 'Merasa sangat sedih sehingga tidak ada yang dapat menghibur?',
                            10 => 'Merasa tidak berharga atau tidak berarti?',
                        ];
                    @endphp
                    @if (!empty($k10_answers) && count($k10_answers) == 10)
                        <div class="space-y-3 text-sm">
                            @foreach ($k10_questions as $index => $question)
                                <div>
                                    <span class="font-semibold">{{ $index }}. {{ $question }}:</span> 
                                    <span class="italic text-indigo-600 dark:text-indigo-400">{{ $k10_answers[$index - 1] ?? 'Tidak Dijawab' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                         <p class="text-sm text-gray-500 dark:text-gray-400">Data asesmen tidak lengkap atau tidak tersedia.</p>
                    @endif
                </div>
             </div>

             @if ($pengajuan->sumber_pengajuan == 'dosen_pa')
             <div class="bg-purple-50 dark:bg-purple-900 border border-purple-200 dark:border-purple-700 overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 text-purple-900 dark:text-purple-100">
                     <h3 class="text-lg font-medium mb-4 border-b border-purple-300 dark:border-purple-600 pb-2 text-purple-800 dark:text-purple-200">Rekomendasi Awal dari Dosen Wali</h3>
                     <div class="space-y-4 text-sm">
                         <div>
                             <span class="font-semibold block mb-1">Aspek Permasalahan (dari Dosen Wali):</span>
                             @if(is_array($pengajuan->aspek_permasalahan))
                                <div class="flex flex-wrap gap-2">
                                     @foreach($pengajuan->aspek_permasalahan as $aspek)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-200">
                                        {{ $aspek }}
                                    </span>
                                    @endforeach
                                </div>
                             @else
                                <p class="text-purple-700 dark:text-purple-300">-</p>
                             @endif
                         </div>
                         <div>
                             <span class="font-semibold block mb-1">Permasalahan yang Dianggap Segera (dari Dosen Wali):</span>
                             <p class="p-2 bg-purple-100 dark:bg-purple-800 rounded-md whitespace-pre-wrap">{{ $pengajuan->permasalahan_segera ?? '-' }}</p>
                         </div>
                         <div>
                             <span class="font-semibold block mb-1">Upaya yang Telah Dilakukan (dari Dosen Wali):</span>
                             <p class="p-2 bg-purple-100 dark:bg-purple-800 rounded-md whitespace-pre-wrap">{{ $pengajuan->upaya_dilakukan ?? '-' }}</p>
                         </div>
                         <div>
                             <span class="font-semibold block mb-1">Harapan Dosen PA (dari Dosen Wali):</span>
                             <p class="p-2 bg-purple-100 dark:bg-purple-800 rounded-md whitespace-pre-wrap">{{ $pengajuan->harapan_pa ?? '-' }}</p>
                         </div>
                     </div>
                 </div>
             </div>
             @endif

        </div>
    </div>
</x-app-layout>