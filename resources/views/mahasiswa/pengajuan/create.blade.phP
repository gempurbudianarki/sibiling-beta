<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="ml-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Form Pengajuan Konseling') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Layanan Bimbingan dan Konseling</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi Error --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm" role="alert">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Oops! Terjadi kesalahan</h3>
                            <div class="mt-1 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Gagal!</h3>
                            <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Progress Steps --}}
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-semibold">1</span>
                        </div>
                        <div class="ml-3 text-sm font-medium text-indigo-600">Informasi Pengajuan</div>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 text-sm font-semibold">2</span>
                        </div>
                        <div class="ml-3 text-sm font-medium text-gray-500">Asesmen Singkat</div>
                    </div>
                </div>
            </div>

            <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf
                
                {{-- BAGIAN 1: INFORMASI PENGAJUAN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Informasi Pengajuan</h3>
                        <p class="text-indigo-100 text-sm mt-1">
                            Silakan isi formulir di bawah ini dengan sejujur-jujurnya. Kerahasiaan data Anda terjamin.
                        </p>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Bidang Layanan --}}
                        <div class="space-y-3">
                            <label for="bidang_layanan" class="block text-sm font-semibold text-gray-900">
                                Bidang Layanan Konseling <span class="text-red-500">*</span>
                            </label>
                            <select id="bidang_layanan" name="bidang_layanan" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white shadow-sm" required>
                                <option value="" disabled {{ old('bidang_layanan') ? '' : 'selected' }}>-- Pilih Bidang Layanan --</option>
                                <option value="pribadi" {{ old('bidang_layanan') == 'pribadi' ? 'selected' : '' }} class="py-2">Pribadi</option>
                                <option value="sosial" {{ old('bidang_layanan') == 'sosial' ? 'selected' : '' }} class="py-2">Sosial</option>
                                <option value="belajar" {{ old('bidang_layanan') == 'belajar' ? 'selected' : '' }} class="py-2">Belajar</option>
                                <option value="karir" {{ old('bidang_layanan') == 'karir' ? 'selected' : '' }} class="py-2">Karir</option>
                            </select>
                        </div>

                        {{-- Jenis Konseli --}}
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-900">
                                Apakah Anda pernah melakukan konseling di UPBK UBBG sebelumnya? <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" class="sr-only peer" name="jenis_konseli" value="baru" {{ old('jenis_konseli', 'baru') == 'baru' ? 'checked' : '' }}>
                                    <div class="w-full p-4 border-2 border-gray-200 rounded-xl peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all duration-200">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:border-indigo-500 peer-checked:bg-indigo-500 transition-all duration-200 mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900">Belum Pernah (Konseli Baru)</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" class="sr-only peer" name="jenis_konseli" value="lama" {{ old('jenis_konseli') == 'lama' ? 'checked' : '' }}>
                                    <div class="w-full p-4 border-2 border-gray-200 rounded-xl peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all duration-200">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:border-indigo-500 peer-checked:bg-indigo-500 transition-all duration-200 mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900">Sudah Pernah (Konseli Lama)</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Tujuan Konseling --}}
                        <div class="space-y-3">
                            <label for="tujuan_konseling" class="block text-sm font-semibold text-gray-900">
                                Jelaskan secara singkat tujuan Anda membutuhkan layanan bimbingan konseling <span class="text-red-500">*</span>
                            </label>
                            <textarea id="tujuan_konseling" name="tujuan_konseling" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none shadow-sm" placeholder="Contoh: Saya ingin mendapatkan bantuan dalam mengelola stres akademik..." required>{{ old('tujuan_konseling') }}</textarea>
                        </div>

                        {{-- Deskripsi Masalah --}}
                        <div class="space-y-3">
                            <label for="deskripsi_masalah" class="block text-sm font-semibold text-gray-900">
                                Jelaskan secara singkat kondisi Anda saat ini (keluhan/permasalahan) <span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi_masalah" name="deskripsi_masalah" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none shadow-sm" placeholder="Ceritakan secara detail apa yang sedang Anda alami..." required>{{ old('deskripsi_masalah') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 2: ASESMEN SINGKAT --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Asesmen Singkat</h3>
                        <p class="text-indigo-100 text-sm mt-1">
                            Pertanyaan berikut menanyakan bagaimana perasaan Anda dalam sebulan terakhir. Pilih jawaban yang paling sesuai.
                        </p>
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
                        <div class="bg-gray-50 rounded-xl p-6 transition-all duration-200 hover:bg-gray-100">
                            <fieldset>
                                <legend class="text-sm font-semibold text-gray-900 mb-4 flex items-start">
                                    <span class="flex-shrink-0 w-6 h-6 bg-indigo-100 text-indigo-600 rounded-full text-xs flex items-center justify-center mr-3 mt-0.5">{{ $index }}</span>
                                    {{ $question }}
                                </legend>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                                    @foreach ($answers as $answer)
                                    <label class="relative flex cursor-pointer">
                                        <input type="radio" class="sr-only peer" name="assessment[{{ $index - 1 }}]" value="{{ $answer }}" {{ old('assessment.' . ($index - 1)) == $answer ? 'checked' : '' }} required>
                                        <div class="w-full p-3 text-center border-2 border-gray-200 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white transition-all duration-200 hover:border-gray-300">
                                            <span class="text-sm font-medium">{{ $answer }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- BAGIAN 3: TOMBOL AKSI --}}
                <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 rounded-xl font-semibold text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-semibold text-white uppercase tracking-widest shadow-sm hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-200 text-sm" ::disabled="submitting">
                        <span x-show="!submitting" class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kirim Pengajuan
                        </span>
                        <span x-show="submitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengirim...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        select:focus, textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .peer:checked ~ div {
            border-color: #4f46e5;
            background-color: #eef2ff;
        }
        
        .peer:checked ~ div > div > div {
            border-color: #4f46e5;
            background-color: #4f46e5;
        }
    </style>
</x-app-layout>