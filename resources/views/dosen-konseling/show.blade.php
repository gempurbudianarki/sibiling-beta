<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Detail Pengajuan --}}
            <div class="md:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="border-b pb-4 mb-4">
                            <h3 class="text-lg font-bold">Detail Masalah</h3>
                            <p class="text-gray-500 text-sm">Diajukan pada: {{ $konseling->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold">Kategori Masalah:</h4>
                                <p>{{ $konseling->kategori_masalah ?? 'Tidak disebutkan' }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold">Deskripsi Singkat Masalah:</h4>
                                <p class="whitespace-pre-wrap">{{ $konseling->deskripsi_masalah ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                             <div>
                                <h4 class="font-semibold">Harapan Setelah Konseling:</h4>
                                <p class="whitespace-pre-wrap">{{ $konseling->harapan_konseling ?? 'Tidak disebutkan' }}</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t">
                            <h3 class="text-lg font-bold mb-4">Tindakan Verifikasi</h3>
                            <div class="flex items-center space-x-4">
                                <a href="#" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Setujui & Buat Jadwal
                                </a>
                                <a href="#" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Minta Revisi
                                </a>
                                <a href="#" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Tolak Pengajuan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Mahasiswa --}}
            <div class="md:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="border-b pb-4 mb-4">
                            <h3 class="text-lg font-bold">Informasi Mahasiswa</h3>
                        </div>
                        <div class="space-y-3 text-sm">
                            <p><strong>Nama:</strong> {{ $konseling->mahasiswa->nama ?? 'N/A' }}</p>
                            <p><strong>NIM:</strong> {{ $konseling->mahasiswa->nim ?? 'N/A' }}</p>
                            <p><strong>Program Studi:</strong> {{ $konseling->mahasiswa->prodi->nama ?? 'N/A' }}</p>
                            <p><strong>Angkatan:</strong> {{ $konseling->mahasiswa->angkatan ?? 'N/A' }}</p>
                            <p><strong>No. HP:</strong> {{ $konseling->mahasiswa->no_hp ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $konseling->mahasiswa->email ?? 'N/A' }}</p>
                            <p><strong>Dosen PA:</strong> {{ $konseling->mahasiswa->dosenPembimbing->nama ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>