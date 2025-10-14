<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Menampilkan error validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Pengajuan</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Silakan isi formulir di bawah ini dengan sejujur-jujurnya. Kerahasiaan data Anda terjamin.
                                </p>
                            </div>

                            <div>
                                <x-input-label for="bidang_layanan" :value="__('Bidang Layanan Konseling*')" />
                                <select id="bidang_layanan" name="bidang_layanan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Bidang Layanan --</option>
                                    <option value="pribadi" {{ old('bidang_layanan') == 'pribadi' ? 'selected' : '' }}>Pribadi</option>
                                    <option value="sosial" {{ old('bidang_layanan') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                    <option value="belajar" {{ old('bidang_layanan') == 'belajar' ? 'selected' : '' }}>Belajar</option>
                                    <option value="karir" {{ old('bidang_layanan') == 'karir' ? 'selected' : '' }}>Karir</option>
                                </select>
                                <x-input-error :messages="$errors->get('bidang_layanan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label :value="__('Apakah Anda pernah melakukan konseling di UPBK UBBG sebelumnya?*')" />
                                <div class="mt-2 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="jenis_konseli" value="baru" {{ old('jenis_konseli', 'baru') == 'baru' ? 'checked' : '' }}>
                                        <span class="ml-2">Belum Pernah (Konseli Baru)</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="jenis_konseli" value="lama" {{ old('jenis_konseli') == 'lama' ? 'checked' : '' }}>
                                        <span class="ml-2">Sudah Pernah (Konseli Lama)</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('jenis_konseli')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tujuan_konseling" :value="__('Jelaskan secara singkat tujuan Anda membutuhkan layanan bimbingan konseling*')" />
                                <textarea id="tujuan_konseling" name="tujuan_konseling" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('tujuan_konseling') }}</textarea>
                                <x-input-error :messages="$errors->get('tujuan_konseling')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi_masalah" :value="__('Jelaskan secara singkat kondisi Anda saat ini (keluhan/permasalahan)*')" />
                                <textarea id="deskripsi_masalah" name="deskripsi_masalah" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('deskripsi_masalah') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi_masalah')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10">
                             <h3 class="text-lg font-medium leading-6 text-gray-900">Asesmen Singkat</h3>
                             <p class="mt-1 text-sm text-gray-600">
                                Pertanyaan berikut menanyakan bagaimana perasaan Anda dalam sebulan terakhir. Pilih jawaban yang paling sesuai dengan kondisi Anda.
                            </p>

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

                            <div class="mt-6 space-y-6">
                                @foreach ($questions as $index => $question)
                                <fieldset>
                                    <legend class="text-sm font-medium text-gray-900">{{ $index }}. {{ $question }}</legend>
                                    <div class="mt-2 flex flex-col sm:flex-row sm:flex-wrap sm:space-x-4 space-y-2 sm:space-y-0">
                                        @foreach ($answers as $answer)
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="assessment[{{ $index - 1 }}]" value="{{ $answer }}" {{ old('assessment.' . ($index - 1)) == $answer ? 'checked' : '' }} required>
                                            <span class="ml-2 text-sm">{{ $answer }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    <x-input-error :messages="$errors->get('assessment.' . ($index - 1))" class="mt-2" />
                                </fieldset>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Kirim Pengajuan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>