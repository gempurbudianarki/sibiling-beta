<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Revisi Formulir Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('mahasiswa.pengajuan.update', $konseling->id_konseling) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- BAGIAN 1: INFORMASI PENGAJUAN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="bg-yellow-50 border-b border-yellow-200 px-6 py-4">
                        <h3 class="text-lg font-semibold text-yellow-800">Revisi Pengajuan</h3>
                        <p class="text-yellow-700 text-sm mt-1">
                            Harap periksa kembali dan perbaiki isian formulir Anda sesuai arahan dari Dosen Konseling.
                        </p>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Bidang Layanan --}}
                        <div class="space-y-3">
                            <label for="bidang_layanan" class="block text-sm font-semibold text-gray-900">Bidang Layanan Konseling <span class="text-red-500">*</span></label>
                            <select id="bidang_layanan" name="bidang_layanan" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500" required>
                                <option value="pribadi" {{ old('bidang_layanan', $konseling->bidang_layanan) == 'pribadi' ? 'selected' : '' }}>Pribadi</option>
                                <option value="sosial" {{ old('bidang_layanan', $konseling->bidang_layanan) == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="belajar" {{ old('bidang_layanan', $konseling->bidang_layanan) == 'belajar' ? 'selected' : '' }}>Belajar</option>
                                <option value="karir" {{ old('bidang_layanan', $konseling->bidang_layanan) == 'karir' ? 'selected' : '' }}>Karir</option>
                            </select>
                        </div>

                        {{-- Jenis Konseli --}}
                        <div class="space-y-3">
                             <label class="block text-sm font-semibold text-gray-900">Apakah Anda pernah melakukan konseling di UPBK UBBG sebelumnya? <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                               <label class="relative flex cursor-pointer">
                                    <input type="radio" class="sr-only peer" name="jenis_konseli" value="baru" {{ old('jenis_konseli', $konseling->jenis_konseli) == 'baru' ? 'checked' : '' }}>
                                    <div class="w-full p-4 border-2 border-gray-200 rounded-xl peer-checked:border-indigo-500">
                                        <span class="text-sm font-medium text-gray-900">Belum Pernah (Konseli Baru)</span>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" class="sr-only peer" name="jenis_konseli" value="lama" {{ old('jenis_konseli', $konseling->jenis_konseli) == 'lama' ? 'checked' : '' }}>
                                     <div class="w-full p-4 border-2 border-gray-200 rounded-xl peer-checked:border-indigo-500">
                                        <span class="text-sm font-medium text-gray-900">Sudah Pernah (Konseli Lama)</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Tujuan & Deskripsi --}}
                        <div class="space-y-3">
                            <label for="tujuan_konseling" class="block text-sm font-semibold text-gray-900">Tujuan Anda membutuhkan layanan <span class="text-red-500">*</span></label>
                            <textarea id="tujuan_konseling" name="tujuan_konseling" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl" required>{{ old('tujuan_konseling', $konseling->tujuan_konseling) }}</textarea>
                        </div>
                        <div class="space-y-3">
                            <label for="deskripsi_masalah" class="block text-sm font-semibold text-gray-900">Kondisi Anda saat ini <span class="text-red-500">*</span></label>
                            <textarea id="deskripsi_masalah" name="deskripsi_masalah" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-xl" required>{{ old('deskripsi_masalah', $konseling->deskripsi_masalah) }}</textarea>
                        </div>
                    </div>
                </div>
                
                {{-- BAGIAN 2: ASESMEN SINGKAT --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                     <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Asesmen Singkat</h3>
                    </div>
                    @php
                        $questions = [
                            1 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa lelah tanpa sebab yang jelas?',
                            2 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa cemas atau khawatir?',
                            3 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa sangat gugup sehingga tidak ada yang dapat menenangkan Anda?',
                            4 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa putus asa?',
                            5 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa gelisah atau tidak tenang?',
                            6 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa sangat gelisah sehingga tidak dapat duduk tenang?',
                            7 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa tertekan?',
                            8 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa perlu berusaha keras untuk melakukan segala hal?',
                            9 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa sangat sedih sehingga tidak ada yang dapat menghibur Anda?',
                            10 => 'Dalam sebulan terakhir ini, seberapa sering Anda merasa tidak berharga atau tidak berarti?',
                        ];
                        $answers = ['Tidak Pernah', 'Jarang', 'Kadang-kadang', 'Hampir Sepanjang Waktu', 'Sepanjang Waktu'];
                    @endphp
                     <div class="p-6 space-y-8">
                        @foreach ($questions as $index => $question)
                        <fieldset>
                             <legend class="text-sm font-semibold text-gray-900 mb-4">{{ $index }}. {{ $question }}</legend>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                                @foreach ($answers as $answer)
                                <label class="relative flex cursor-pointer">
                                     <input type="radio" class="sr-only peer" name="assessment[{{ $index }}]" value="{{ $answer }}" {{ (old('assessment.'.$index, $konseling->hasil_asesmen[$index-1] ?? '')) == $answer ? 'checked' : '' }} required>
                                     <div class="w-full p-3 text-center border-2 border-gray-200 rounded-lg peer-checked:border-indigo-500">{{ $answer }}</div>
                                 </label>
                                @endforeach
                            </div>
                         </fieldset>
                        @endforeach
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="mt-8 flex justify-end items-center gap-4">
                    <a href="{{ route('mahasiswa.riwayat.show', $konseling->id_konseling) }}" class="text-sm font-medium text-gray-600">Batal</a>
                    <x-primary-button>Kirim Ulang Revisi</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>