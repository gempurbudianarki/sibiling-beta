<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Jadwal Konseling Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">
                        Membuat Jadwal untuk Mahasiswa:
                    </h3>
                    <p class="text-md font-semibold text-indigo-600 mb-4">{{ $pengajuan->mahasiswa->user->name }} (NIM: {{ $pengajuan->nim_mahasiswa }})</p>

                    <form action="{{ route('dosen-konseling.jadwal.store') }}" method="POST" x-data="{ metode: 'Offline' }">
                        @csrf
                        {{-- Hidden input untuk mengirim ID konseling yang akan dijadwalkan --}}
                        <input type="hidden" name="id_konseling" value="{{ $pengajuan->id_konseling }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_konseling" :value="__('Tanggal Konseling')" />
                                <x-text-input id="tanggal_konseling" class="block mt-1 w-full" type="date" name="tanggal_konseling" :value="old('tanggal_konseling')" required />
                                <x-input-error :messages="$errors->get('tanggal_konseling')" class="mt-2" />
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
                                <x-input-label for="metode_konseling" :value="__('Metode Konseling')" />
                                <select id="metode_konseling" name="metode_konseling" x-model="metode" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Offline">Offline (Tatap Muka)</option>
                                    <option value="Online">Online</option>
                                </select>
                                <x-input-error :messages="$errors->get('metode_konseling')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="mt-6" x-show="metode === 'Offline'" x-transition>
                            <x-input-label for="lokasi" :value="__('Lokasi/Ruangan (Wajib diisi jika Offline)')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" placeholder="Contoh: Ruang Konseling Gedung A" />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                             <a href="{{ route('dosen-konseling.pengajuan.show', $pengajuan->id_konseling) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
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