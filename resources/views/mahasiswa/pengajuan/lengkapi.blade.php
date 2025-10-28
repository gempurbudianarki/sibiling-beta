<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lengkapi Pengajuan Rekomendasi Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Form untuk 'updateLengkapan' --}}
                    <form method="POST" action="{{ route('mahasiswa.pengajuan.updateLengkapan', $konseling->id_konseling) }}">
                        @csrf
                        @method('PUT')

                        {{-- ========================================================== --}}
                        {{-- BAGIAN A: REKOMENDASI DOSEN WALI (TERKUNCI) --}}
                        {{-- ========================================================== --}}
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">
                            Bagian A: Rekomendasi dari Dosen Wali
                        </h3>
                        <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                            Bagian ini diisi oleh Dosen Wali Anda dan tidak dapat diubah. Harap baca dengan seksama sebagai panduan untuk melengkapi pengajuan Anda.
                        </p>

                        <div class="mb-4">
                            <x-input-label :value="__('Aspek Permasalahan (dari Dosen Wali)')" class="font-semibold"/>
                            @if(is_array($konseling->aspek_permasalahan))
                                <div class="mt-2 space-y-1">
                                    @foreach($konseling->aspek_permasalahan as $aspek)
                                    <p class="text-sm text-gray-700 dark:text-gray-300">- {{ $aspek }}</p>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada data.</p>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-input-label for="permasalahan_segera" :value="__('Permasalahan yang Dianggap Segera (dari Dosen Wali)')" class="font-semibold"/>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 p-3 bg-gray-100 dark:bg-gray-700 rounded-md whitespace-pre-wrap">{{ $konseling->permasalahan_segera ?? '-' }}</p>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="upaya_dilakukan_dosen" :value="__('Upaya yang Telah Dilakukan (dari Dosen Wali)')" class="font-semibold"/>
                             <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 p-3 bg-gray-100 dark:bg-gray-700 rounded-md whitespace-pre-wrap">{{ $konseling->upaya_dilakukan ?? '-' }}</p>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="harapan_pa" :value="__('Harapan Dosen PA (dari Dosen Wali)')" class="font-semibold"/>
                             <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 p-3 bg-gray-100 dark:bg-gray-700 rounded-md whitespace-pre-wrap">{{ $konseling->harapan_pa ?? '-' }}</p>
                        </div>

                        {{-- Divider --}}
                        <hr class="my-8 border-gray-300 dark:border-gray-700">

                        {{-- ========================================================== --}}
                        {{-- BAGIAN B: DATA DIRI MAHASISWA --}}
                        {{-- ========================================================== --}}
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">
                            Bagian B: Data Diri Mahasiswa
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama_mahasiswa" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama_mahasiswa" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" value="{{ $mahasiswa->user->name }}" readonly />
                            </div>

                            <div>
                                <x-input-label for="nim_mahasiswa" :value="__('NIM')" />
                                <x-text-input id="nim_mahasiswa" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" value="{{ $mahasiswa->nim }}" readonly />
                            </div>

                            <div>
                                <x-input-label for="prodi_mahasiswa" :value="__('Program Studi')" />
                                <x-text-input id="prodi_mahasiswa" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" value="{{ $mahasiswa->prodi->nama_prodi ?? 'Prodi Tidak Ditemukan' }}" readonly />
                            </div>

                            <div>
                                <x-input-label for="email_mahasiswa" :value="__('Email')" />
                                <x-text-input id="email_mahasiswa" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="email" value="{{ $mahasiswa->email }}" readonly />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="no_hp_mahasiswa" :value="__('No. HP/WA (Aktif)')" />
                            <x-text-input id="no_hp_mahasiswa" class="block mt-1 w-full" type="text" name="no_hp_mahasiswa" :value="old('no_hp_mahasiswa', $mahasiswa->no_hp)" placeholder="Contoh: 081234567890" />
                            <x-input-error :messages="$errors->get('no_hp_mahasiswa')" class="mt-2" />
                        </div>
                        
                        {{-- Divider --}}
                        <hr class="my-8 border-gray-300 dark:border-gray-700">

                        {{-- ========================================================== --}}
                        {{-- BAGIAN C: STATUS & JENIS PERMASALAHAN --}}
                        {{-- ========================================================== --}}
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">
                            Bagian C: Status & Jenis Permasalahan
                        </h3>

                        <div class="mt-4">
                            <x-input-label :value="__('Status Konseli/Klien')" class="mb-2" />
                            <div class="flex flex-col sm:flex-row sm:space-x-4">
                                <label class="inline-flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-md mb-2 sm:mb-0">
                                    <input type="radio" name="tipe_konseli" value="Konseli Baru (belum pernah)" 
                                        class="text-indigo-600 border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500"
                                        {{ old('tipe_konseli') == 'Konseli Baru (belum pernah)' ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Konseli Baru (belum pernah)</span>
                                </label>
                                <label class="inline-flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-md">
                                    <input type="radio" name="tipe_konseli" value="Konseli Lama (sudah pernah)" 
                                        class="text-indigo-600 border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500"
                                        {{ old('tipe_konseli') == 'Konseli Lama (sudah pernah)' ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Konseli Lama (sudah pernah)</span>
                                </label>
                            </div>
                             <x-input-error :messages="$errors->get('tipe_konseli')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                             <x-input-label :value="__('Jenis Permasalahan (Pilih satu atau lebih)')" class="mb-2"/>
                             @php $old_jenis = old('jenis_permasalahan', []); @endphp
                             <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @foreach(['Sosial', 'Belajar', 'Karir', 'Pribadi'] as $jenis)
                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-md">
                                    <input type="checkbox" name="jenis_permasalahan[]" value="{{ $jenis }}"
                                           class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                           {{ in_array($jenis, $old_jenis) ? 'checked' : '' }}>
                                    <span class="ms-3 text-sm text-gray-600 dark:text-gray-400">{{ $jenis }}</span>
                                </label>
                                @endforeach
                             </div>
                             <x-input-error :messages="$errors->get('jenis_permasalahan')" class="mt-2" />
                        </div>

                        {{-- Divider --}}
                        <hr class="my-8 border-gray-300 dark:border-gray-700">

                        {{-- ========================================================== --}}
                        {{-- BAGIAN D: DETAIL PERMASALAHAN (DUA TEXTAREA) --}}
                        {{-- ========================================================== --}}
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">
                            Bagian D: Detail Permasalahan
                        </h3>

                        <div class="mt-4">
                            <x-input-label for="deskripsi_masalah" :value="__('Jelaskan secara singkat kondisi Anda saat ini (keluhan/permasalahan)')" />
                            <textarea name="deskripsi_masalah" id="deskripsi_masalah" rows="6" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi_masalah') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_masalah')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="tujuan_konseling" :value="__('Jelaskan secara singkat tujuan Anda membutuhkan layanan bimbingan konseling')" />
                            <textarea name="tujuan_konseling" id="tujuan_konseling" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('tujuan_konseling') }}</textarea>
                            <x-input-error :messages="$errors->get('tujuan_konseling')" class="mt-2" />
                        </div>

                         {{-- Divider --}}
                        <hr class="my-8 border-gray-300 dark:border-gray-700">

                        {{-- ========================================================== --}}
                        {{-- BAGIAN E: ASESMEN K10 (SESUAI PERMINTAAN) --}}
                        {{-- ========================================================== --}}
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">
                            Bagian E: Asesmen Kondisi Psikologis (K10 Modifikasi)
                        </h3>
                         <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                            Pilih jawaban yang paling sesuai dengan kondisi Anda dalam **satu bulan terakhir**.
                        </p>

                        @php
                            $old_k10 = old('asesmen_k10', []);
                            $k10_questions = [
                                1 => 'Seberapa sering Anda merasa lelah tanpa sebab yang jelas?',
                                2 => 'Seberapa sering Anda merasa cemas atau khawatir?',
                                3 => 'Seberapa sering Anda merasa sangat gugup sehingga tidak ada yang dapat menenangkan Anda?',
                                4 => 'Seberapa sering Anda merasa putus asa?',
                                5 => 'Seberapa sering Anda merasa gelisah atau tidak tenang?',
                                6 => 'Seberapa sering Anda merasa sangat gelisah sehingga tidak dapat duduk tenang?',
                                7 => 'Seberapa sering Anda merasa tertekan?',
                                8 => 'Seberapa sering Anda merasa perlu berusaha keras untuk melakukan segala hal?',
                                9 => 'Seberapa sering Anda merasa sangat sedih sehingga tidak ada yang dapat menghibur Anda?',
                                10 => 'Seberapa sering Anda merasa tidak berharga atau tidak berarti?',
                            ];
                            $k10_options = [
                                'Tidak pernah',
                                'Jarang',
                                'Kadang-kadang',
                                'Hampir Sepanjang waktu',
                                'Sepanjang waktu',
                            ];
                        @endphp
                        
                        <div class="space-y-6">
                            @foreach ($k10_questions as $index => $question)
                            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-md">
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-3">
                                    {{ $index }}. {{ $question }}
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-x-4 gap-y-2">
                                     @foreach ($k10_options as $option)
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="asesmen_k10[{{ $index - 1 }}]" value="{{ $option }}" 
                                                class="text-indigo-600 border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500"
                                                {{ (isset($old_k10[$index - 1]) && $old_k10[$index - 1] == $option) ? 'checked' : '' }}>
                                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $option }}</span>
                                        </label>
                                     @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('asesmen_k10.' . ($index - 1))" class="mt-2" />
                            </div>
                            @endforeach
                        </div>
                         <x-input-error :messages="$errors->get('asesmen_k10')" class="mt-2" />

                        {{-- ================================================== --}}
                        {{-- BAGIAN F: PERSETUJUAN (SESUAI SOP) --}}
                        {{-- ================================================== --}}
                        <hr class="my-8 border-gray-300 dark:border-gray-700">

                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">
                            Bagian F: Persetujuan / Informed Consent
                        </h3>
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-md space-y-4 text-sm text-gray-700 dark:text-gray-300">
                            <p>Saya yang bertanda tangan di atas menyatakan <strong>SETUJU</strong> dan <strong>BERSEDIA</strong> untuk terlibat dan berpartisipasi aktif dalam proses layanan bimbingan konseling yang diselenggarakan oleh unit perlayanan bimbingan konseling.</p>
                            <p>Dalam kegiatan ini, setelah saya mengetahui tujuan, manfaat dari kegiatan layanan bimbingan konseling, maka saya telah menyadari, memahami, dan menerima bahwa:</p>
                            <ol class="list-decimal list-inside space-y-2">
                                <li>Saya terlibat penuh dan aktif selama proses layanan bimbingan konseling berlangsung.</li>
                                <li>Saya bersedia untuk memberikan segala informasi mengenai permasalahan yang sedang saya alami dengan sejujur-jujurnya.</li>
                                <li>Identitas dan informasi yang saya berikan bersifat <strong>DIRAHASIAKAN</strong> dan tidak akan disampaikan secara terbuka kepada umum.</li>
                                <li>Saya bersedia apabila dibutuhkan untuk perekaman percakapan selama proses layanan bimbingan konseling, guna memperoleh dokumen dan rekapan tersebut bersifat <strong>DIRAHASIAKAN</strong>.</li>
                                <li>Guna menunjang kelancaran proses layanan bimbingan konseling, maka segala hal yang terkait dengan waktu dan tempat akan disepakati bersama.</li>
                            </ol>
                            <p>Dalam menandatangani lembar ini, saya <strong>TIDAK ADA PAKSAAN</strong> dari pihak manapun sehingga saya bersedia untuk mengikuti proses layanan bimbingan konseling ini dari awal kegiatan sampai berakhirnya kegiatan dan menerima segala hal yang terkait dengan pelaksaan kegiatan ini.</p>
                        </div>
                        
                        <div class="block mt-4">
                            <label for="persetujuan" class="inline-flex items-center">
                                <input id="persetujuan" type="checkbox" name="persetujuan" value="1" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Saya telah membaca dan menyetujui pernyataan di atas.') }}</span>
                            </label>
                            {{-- Tampilkan error validasi jika checkbox tidak dicentang --}}
                            <x-input-error :messages="$errors->get('persetujuan')" class="mt-2" />
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('mahasiswa.riwayat.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Batalkan
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Kirim Pengajuan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>