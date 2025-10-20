<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sesi Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            Sesi dengan: {{ $jadwal->konseling->mahasiswa->user->name }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            Jadwal: {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('l, d F Y, H:i') }}
                        </p>
                        <p class="text-sm text-gray-500 italic mt-2">
                           Permasalahan Awal: "{{ $jadwal->konseling->permasalahan }}"
                        </p>
                    </div>

                    <h4 class="text-md font-semibold text-gray-800 mb-4">Form Hasil Sesi Konseling</h4>

                    <form action="{{ route('dosen-konseling.jadwal.simpanSesi', $jadwal->id_jadwal) }}" method="POST">
                        @csrf
                        
                        <div class="mt-4">
                            <x-input-label for="diagnosis" :value="__('Diagnosis (Analisis Masalah)')" />
                            <textarea id="diagnosis" name="diagnosis" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('diagnosis') }}</textarea>
                            <x-input-error :messages="$errors->get('diagnosis')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="prognosis" :value="__('Prognosis (Potensi Perkembangan)')" />
                            <textarea id="prognosis" name="prognosis" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('prognosis') }}</textarea>
                            <x-input-error :messages="$errors->get('prognosis')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="rekomendasi" :value="__('Rekomendasi Tindak Lanjut')" />
                            <textarea id="rekomendasi" name="rekomendasi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('rekomendasi') }}</textarea>
                            <x-input-error :messages="$errors->get('rekomendasi')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="evaluasi" :value="__('Evaluasi & Catatan Tambahan (Opsional)')" />
                            <textarea id="evaluasi" name="evaluasi" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('evaluasi') }}</textarea>
                            <x-input-error :messages="$errors->get('evaluasi')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="status_akhir" :value="__('Tetapkan Status Akhir Konseling')" />
                            <select id="status_akhir" name="status_akhir" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Selesai">Selesai (Kasus Tuntas)</option>
                                <option value="Butuh Sesi Lanjutan">Butuh Sesi Lanjutan</option>
                            </select>
                            <x-input-error :messages="$errors->get('status_akhir')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                             <a href="{{ route('dosen-konseling.jadwal.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Hasil & Selesaikan Sesi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>