<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium">Pengajuan Baru</h3>
                        <p class="mt-2 text-5xl font-bold">{{ $pengajuanBaru }}</p>
                        <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">
                            Lihat Semua Pengajuan
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium">Jadwal Mendatang</h3>
                        <p class="mt-2 text-5xl font-bold">{{ $jadwalMendatang }}</p>
                        <a href="{{ route('dosen-konseling.jadwal.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">
                            Lihat Jadwal Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>