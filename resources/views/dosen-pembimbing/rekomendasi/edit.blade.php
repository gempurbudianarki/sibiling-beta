<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Rekomendasi Konseling
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('dosen-pembimbing.rekomendasi.update', $rekomendasi->id_konseling) }}">
                    @csrf
                    @method('PUT')

                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                            <h3 class="text-lg font-semibold text-red-800">Perlu Revisi</h3>
                            <p class="mt-1 text-sm text-red-700">Rekomendasi Anda sebelumnya ditolak dengan alasan sebagai berikut:</p>
                            <p class="mt-2 text-sm font-medium text-black bg-red-100 p-2 rounded">{{ $rekomendasi->alasan_penolakan ?: 'Tidak ada alasan spesifik.' }}</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Data Mahasiswa</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <div><dt class="font-medium text-gray-500">Nama Lengkap</dt><dd class="text-gray-900">{{ $rekomendasi->mahasiswa->nm_mhs }}</dd></div>
                                <div><dt class="font-medium text-gray-500">NIM</dt><dd class="text-gray-900">{{ $rekomendasi->nim_mahasiswa }}</dd></div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Formulir Rekomendasi</h3>
                            @php
                                $aspek_permasalahan = json_decode($rekomendasi->aspek_permasalahan, true) ?? [];
                            @endphp
                            <div class="mb-4">
                                <x-input-label :value="__('Aspek Permasalahan')" />
                                <div class="mt-2 space-y-2">
                                    @foreach(['Akademik', 'Pribadi', 'Sosial', 'Karir', 'Lainnya'] as $aspek)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="aspek_permasalahan[]" value="{{ strtolower($aspek) }}" 
                                               class="rounded border-gray-300"
                                               {{ in_array(strtolower($aspek), $aspek_permasalahan) ? 'checked' : '' }}>
                                        <span class="ms-2 text-sm text-gray-600">{{ $aspek }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-4">
                                <x-input-label for="permasalahan_segera" :value="__('Permasalahan yang Perlu Segera Diatasi')" />
                                <textarea id="permasalahan_segera" name="permasalahan_segera" rows="3" class="block mt-1 w-full" required>{{ old('permasalahan_segera', $rekomendasi->permasalahan_segera) }}</textarea>
                            </div>
                            <div class="mb-4">
                                <x-input-label for="upaya_dilakukan" :value="__('Upaya yang Sudah Dilakukan')" />
                                <textarea id="upaya_dilakukan" name="upaya_dilakukan" rows="3" class="block mt-1 w-full" required>{{ old('upaya_dilakukan', $rekomendasi->upaya_dilakukan) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="harapan_pa" :value="__('Harapan Dosen PA')" />
                                <textarea id="harapan_pa" name="harapan_pa" rows="3" class="block mt-1 w-full" required>{{ old('harapan_pa', $rekomendasi->harapan_pa) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end p-6 bg-gray-50">
                        <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="text-sm text-gray-600 mr-4">Batal</a>
                        <x-primary-button>Kirim Ulang Rekomendasi</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>