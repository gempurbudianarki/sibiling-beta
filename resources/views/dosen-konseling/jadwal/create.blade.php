<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Jadwal Konseling untuk: {{ $konseling->mahasiswa->nm_mhs }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('dosen-konseling.jadwal.store', $konseling->id_konseling) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tgl_sesi" :value="__('Tanggal Sesi')" />
                                <x-text-input id="tgl_sesi" class="block mt-1 w-full" type="date" name="tgl_sesi" :value="old('tgl_sesi')" required />
                                <x-input-error :messages="$errors->get('tgl_sesi')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="waktu_mulai" :value="__('Waktu Mulai')" />
                                <x-text-input id="waktu_mulai" class="block mt-1 w-full" type="time" name="waktu_mulai" :value="old('waktu_mulai')" required />
                                <x-input-error :messages="$errors->get('waktu_mulai')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="waktu_selesai" :value="__('Waktu Selesai')" />
                                <x-text-input id="waktu_selesai" class="block mt-1 w-full" type="time" name="waktu_selesai" :value="old('waktu_selesai')" required />
                                <x-input-error :messages="$errors->get('waktu_selesai')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="jenis_sesi" :value="__('Jenis Sesi')" />
                                <select id="jenis_sesi" name="jenis_sesi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="offline">Offline (Tatap Muka)</option>
                                    <option value="online">Online (Video Call)</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_sesi')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-input-label for="lokasi" :value="__('Lokasi / Link Pertemuan')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required placeholder="Contoh: Ruang Konseling UBBG / https://meet.google.com/xyz" />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Simpan Jadwal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>