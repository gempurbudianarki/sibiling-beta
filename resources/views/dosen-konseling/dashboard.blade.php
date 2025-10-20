<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-sm text-gray-600">Berikut adalah ringkasan aktivitas Anda hari ini.</p>

                    {{-- ================== KARTU STATISTIK ================== --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                            <h4 class="text-3xl font-bold text-yellow-800">{{ $jumlahPengajuanBaru }}</h4>
                            <p class="text-sm font-semibold text-yellow-700 mt-1">Pengajuan Baru Menunggu Verifikasi</p>
                            <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="text-sm text-yellow-900 hover:underline mt-4 inline-block">
                                Lihat Semua Pengajuan &rarr;
                            </a>
                        </div>

                        <div class="bg-green-50 border-l-4 border-green-400 p-6 rounded-r-lg">
                            <h4 class="text-3xl font-bold text-green-800">{{ $jadwalHariIni }}</h4>
                            <p class="text-sm font-semibold text-green-700 mt-1">Jadwal Sesi Konseling Hari Ini</p>
                             <a href="{{ route('dosen-konseling.jadwal.index') }}" class="text-sm text-green-900 hover:underline mt-4 inline-block">
                                Buka Jadwal Saya &rarr;
                            </a>
                        </div>
                    </div>
                    {{-- ======================================================== --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>