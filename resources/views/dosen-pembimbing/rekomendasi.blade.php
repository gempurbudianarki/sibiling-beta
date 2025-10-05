<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Rekomendasi Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-1">Form Rekomendasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Gunakan form ini untuk merekomendasikan mahasiswa bimbingan Anda kepada dosen konseling.</p>

                    {{-- Menampilkan error validasi jika ada --}}
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

                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="font-semibold text-blue-800">Template Surat Rekomendasi</h4>
                        <p class="text-sm text-blue-700 mt-1">Silakan unduh template surat di bawah ini, isi, lalu unggah kembali pada form yang telah disediakan.</p>
                        <a href="{{ asset('templates/template_surat_rekomendasi.docx') }}" download
                           class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700 transition">
                            <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                            Unduh Template
                        </a>
                    </div>

                    {{-- ==== PERBAIKI ACTION FORM DI SINI ==== --}}
                    <form action="{{ route('dosen-pembimbing.rekomendasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div>
                            <label for="mahasiswa_nim" class="block font-medium text-sm text-gray-700">Pilih Mahasiswa</label>
                            <select id="mahasiswa_nim" name="mahasiswa_nim" class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih salah satu mahasiswa --</option>
                                @foreach ($mahasiswaList as $mahasiswa)
                                    <option value="{{ $mahasiswa->nim }}" {{ old('mahasiswa_nim') == $mahasiswa->nim ? 'selected' : '' }}>{{ $mahasiswa->nm_mhs }} ({{ $mahasiswa->nim }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="alasan" class="block font-medium text-sm text-gray-700">Alasan Rekomendasi (Singkat)</label>
                            <textarea id="alasan" name="alasan" rows="4" class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan secara singkat mengapa mahasiswa ini perlu mendapatkan layanan konseling...">{{ old('alasan') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="surat_rekomendasi" class="block font-medium text-sm text-gray-700">Unggah Surat Rekomendasi (.docx)</label>
                            <input id="surat_rekomendasi" name="surat_rekomendasi" type="file" class="block w-full mt-1 text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Kirim Rekomendasi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>