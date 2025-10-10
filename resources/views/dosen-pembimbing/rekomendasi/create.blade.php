<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Rekomendasi Konseling
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('dosen-pembimbing.rekomendasi.store') }}">
                    @csrf
                    <input type="hidden" name="nim_mahasiswa" value="{{ $mahasiswa->nim }}">

                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Data Mahasiswa</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <div><dt class="font-medium text-gray-500">Nama Lengkap</dt><dd class="text-gray-900">{{ $mahasiswa->nm_mhs }}</dd></div>
                                <div><dt class="font-medium text-gray-500">NIM</dt><dd class="text-gray-900">{{ $mahasiswa->nim }}</dd></div>
                                <div><dt class="font-medium text-gray-500">Program Studi</dt><dd class="text-gray-900">{{ $mahasiswa->prodi->nm_prodi ?? 'N/A' }}</dd></div>
                                <div><dt class="font-medium text-gray-500">Angkatan</dt><dd class="text-gray-900">{{ $mahasiswa->angkatan }}</dd></div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Formulir Rekomendasi</h3>
                            
                            <div class="mb-4">
                                <x-input-label :value="__('Aspek Permasalahan yang Dialami (bisa pilih lebih dari satu)')" />
                                <div class="mt-2 space-y-2">
                                    @foreach(['Akademik', 'Pribadi', 'Sosial', 'Karir', 'Lainnya'] as $aspek)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="aspek_permasalahan[]" value="{{ strtolower($aspek) }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ms-2 text-sm text-gray-600">{{ $aspek }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('aspek_permasalahan')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="permasalahan_segera" :value="__('Permasalahan yang Perlu Segera Diatasi')" />
                                <textarea id="permasalahan_segera" name="permasalahan_segera" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('permasalahan_segera') }}</textarea>
                                <x-input-error :messages="$errors->get('permasalahan_segera')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="upaya_dilakukan" :value="__('Upaya yang Sudah Dilakukan oleh Dosen PA')" />
                                <textarea id="upaya_dilakukan" name="upaya_dilakukan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('upaya_dilakukan') }}</textarea>
                                <x-input-error :messages="$errors->get('upaya_dilakukan')" class="mt-2" />
                            </div>

                             <div>
                                <x-input-label for="harapan_pa" :value="__('Harapan Dosen PA Setelah Mahasiswa Mengikuti Konseling')" />
                                <textarea id="harapan_pa" name="harapan_pa" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('harapan_pa') }}</textarea>
                                <x-input-error :messages="$errors->get('harapan_pa')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end p-6 bg-gray-50">
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
</x-app-layout>