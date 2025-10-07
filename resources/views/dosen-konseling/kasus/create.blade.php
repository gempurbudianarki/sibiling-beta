<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Hasil Sesi Konseling
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="border-b pb-4 mb-6">
                        <h3 class="text-lg font-bold">Detail Sesi</h3>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Mahasiswa</p>
                                <p>{{ $jadwal->konseling->mahasiswa->nm_mhs ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jadwal</p>
                                <p>{{ \Carbon\Carbon::parse($jadwal->tgl_sesi)->isoFormat('dddd, D MMM YYYY') }}, {{ $jadwal->waktu_mulai }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('dosen-konseling.kasus.hasil.store', $jadwal->id_jadwal) }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="ringkasan_sesi" value="Ringkasan Sesi" />
                                <textarea id="ringkasan_sesi" name="ringkasan_sesi" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan apa saja yang dibahas selama sesi konseling...">{{ old('ringkasan_sesi') }}</textarea>
                                <x-input-error :messages="$errors->get('ringkasan_sesi')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="observasi_konselor" value="Observasi & Analisis Konselor" />
                                <textarea id="observasi_konselor" name="observasi_konselor" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tuliskan pengamatan, analisis, atau diagnosis awal Anda sebagai konselor...">{{ old('observasi_konselor') }}</textarea>
                                <x-input-error :messages="$errors->get('observasi_konselor')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status_akhir_sesi" value="Status Akhir Kasus" />
                                <select id="status_akhir_sesi" name="status_akhir_sesi" x-data="{ selected: '{{ old('status_akhir_sesi', 'lanjut') }}' }" x-model="selected" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="lanjut">Perlu Sesi Lanjutan</option>
                                    <option value="selesai">Kasus Selesai</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_akhir_sesi')" class="mt-2" />
                            </div>
                            <div x-show="selected === 'lanjut'">
                                <x-input-label for="tindak_lanjut" value="Rencana Tindak Lanjut (Jika perlu sesi lanjutan)" />
                                <textarea id="tindak_lanjut" name="tindak_lanjut" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Contoh: Menjadwalkan sesi berikutnya minggu depan untuk membahas strategi coping...">{{ old('tindak_lanjut') }}</textarea>
                                <x-input-error :messages="$errors->get('tindak_lanjut')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button>
                                {{ __('Simpan Hasil Konseling') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>