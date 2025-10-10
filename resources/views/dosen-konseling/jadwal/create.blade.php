<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Jadwal Konseling
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                            <strong class="block mb-2">Terjadi kesalahan:</strong>
                            <ul class="list-disc pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6 border-b pb-4">
                        <h3 class="text-lg font-semibold">Pengajuan dari:</h3>
                        <p class="text-gray-700">
                            {{ $pengajuan->mahasiswa->nm_mhs ?? 'N/A' }}
                            ({{ $pengajuan->mahasiswa->nim ?? $pengajuan->nim_mahasiswa ?? 'N/A' }})
                        </p>
                    </div>

                    <form method="POST" action="{{ route('dosen-konseling.jadwal.store') }}">
                        @csrf
                        <input type="hidden" name="id_konseling" value="{{ $pengajuan->id_konseling }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tgl_sesi" :value="__('Tanggal')" />
                                <x-text-input
                                    id="tgl_sesi" type="date" name="tgl_sesi"
                                    :value="old('tgl_sesi')"
                                    min="{{ now()->toDateString() }}"
                                    class="block mt-1 w-full" required
                                />
                                <x-input-error :messages="$errors->get('tgl_sesi')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jenis_sesi" :value="__('Jenis Konseling')" />
                                <select
                                    name="jenis_sesi" id="jenis_sesi" required
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="online"  {{ old('jenis_sesi')==='online'  ? 'selected' : '' }}>Online</option>
                                    <option value="offline" {{ old('jenis_sesi')==='offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_sesi')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="waktu_mulai" :value="__('Jam Mulai')" />
                                <x-text-input
                                    id="waktu_mulai" type="time" name="waktu_mulai"
                                    :value="old('waktu_mulai')"
                                    class="block mt-1 w-full" required
                                />
                                <x-input-error :messages="$errors->get('waktu_mulai')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="waktu_selesai" :value="__('Jam Selesai')" />
                                <x-text-input
                                    id="waktu_selesai" type="time" name="waktu_selesai"
                                    :value="old('waktu_selesai')"
                                    class="block mt-1 w-full" required
                                />
                                <x-input-error :messages="$errors->get('waktu_selesai')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="lokasi" :value="__('Lokasi / Link Pertemuan')" />
                                <x-text-input
                                    id="lokasi" type="text" name="lokasi"
                                    :value="old('lokasi')"
                                    placeholder="Contoh: Ruang Konseling / https://meet.google.com/xxx"
                                    class="block mt-1 w-full" required
                                />
                                <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-3">
                            <a href="{{ route('dosen-konseling.jadwal.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
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
