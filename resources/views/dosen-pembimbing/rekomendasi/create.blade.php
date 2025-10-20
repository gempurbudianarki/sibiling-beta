<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Rekomendasi Konseling (Sesuai SOP)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="border-b pb-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            Rekomendasi untuk Mahasiswa:
                        </h3>
                        <p class="text-md font-semibold text-indigo-600">
                            {{ $mahasiswa->user->name ?? $mahasiswa->nama_mhs }} (NIM: {{ $mahasiswa->nim }})
                        </p>
                    </div>

                    <form action="{{ route('dosen-pembimbing.rekomendasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nim_mahasiswa" value="{{ $mahasiswa->nim }}">

                        <div>
                            <x-input-label :value="__('1. Aspek Permasalahan yang Ditemukan (Pilih satu atau lebih)')" class="font-bold"/>
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @php
                                    $aspekList = ['Pribadi', 'Sosial', 'Belajar', 'Karier', 'Keluarga', 'Lainnya'];
                                @endphp
                                @foreach ($aspekList as $aspek)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="aspek_permasalahan[]" value="{{ $aspek }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span>{{ $aspek }}</span>
                                </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('aspek_permasalahan')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="permasalahan_segera" :value="__('2. Deskripsikan Permasalahan yang Perlu Segera Ditangani')" class="font-bold"/>
                            <textarea id="permasalahan_segera" name="permasalahan_segera" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('permasalahan_segera') }}</textarea>
                            <x-input-error :messages="$errors->get('permasalahan_segera')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="upaya_dilakukan" :value="__('3. Upaya-upaya yang Telah Anda Lakukan untuk Membantu')" class="font-bold"/>
                            <textarea id="upaya_dilakukan" name="upaya_dilakukan" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('upaya_dilakukan') }}</textarea>
                            <x-input-error :messages="$errors->get('upaya_dilakukan')" class="mt-2" />
                        </div>
                        
                        <div class="mt-6">
                            <x-input-label for="harapan_pa" :value="__('4. Harapan Anda Setelah Mahasiswa Mengikuti Konseling')" class="font-bold"/>
                            <textarea id="harapan_pa" name="harapan_pa" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('harapan_pa') }}</textarea>
                            <x-input-error :messages="$errors->get('harapan_pa')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
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