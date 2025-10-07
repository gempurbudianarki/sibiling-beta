<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang Kembali!") }}
                </div>
            </div>

            {{-- Bagian ini akan berisi widget-widget dinamis --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- WIDGET UNTUK DOSEN PEMBIMBING --}}
                @if (isset($pa_info))
                    <div class="md:col-span-1 lg:col-span-1 bg-white p-6 rounded-lg shadow-sm border">
                        <h3 class="font-semibold text-lg border-b pb-2 mb-4">Ringkasan Dosen Pembimbing</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Jumlah Mahasiswa Bimbingan</p>
                                <p class="text-2xl font-bold">{{ $pa_info['jumlahMahasiswa'] }}</p>
                            </div>
                            <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="text-blue-500 hover:underline text-sm">Lihat Detail Mahasiswa &rarr;</a>
                        </div>
                    </div>
                @endif
                
                {{-- WIDGET UNTUK DOSEN KONSELING --}}
                @if (isset($konselor_info))
                     <div class="md:col-span-2 lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border">
                        <h3 class="font-semibold text-lg border-b pb-2 mb-4">Ringkasan Dosen Konseling</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                <p class="text-sm text-gray-500">Pengajuan Konseling Baru</p>
                                <p class="text-2xl font-bold">{{ $konselor_info['pengajuanBaru'] }}</p>
                                <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="text-blue-500 hover:underline text-sm">Verifikasi Sekarang &rarr;</a>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jadwal Sesi Mendatang</p>
                                <p class="text-2xl font-bold">{{ $konselor_info['jadwalMendatang'] }}</p>
                                <a href="{{ route('dosen-konseling.jadwal.index') }}" class="text-blue-500 hover:underline text-sm">Lihat Jadwal Saya &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>