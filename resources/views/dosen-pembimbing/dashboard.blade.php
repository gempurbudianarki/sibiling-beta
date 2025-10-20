<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Ringkasan Bimbingan Akademik Anda
                    </h3>
                    <p class="text-sm text-gray-600">Berikut adalah status konseling dari mahasiswa perwalian Anda.</p>

                    {{-- ================== KARTU STATISTIK ================== --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-r-lg">
                            <h4 class="text-3xl font-bold text-blue-800">{{ $mahasiswaDalamKonseling }}</h4>
                            <p class="text-sm font-semibold text-blue-700 mt-1">Mahasiswa Wali Sedang dalam Proses Konseling</p>
                        </div>

                        <div class="bg-gray-50 border-l-4 border-gray-400 p-6 rounded-r-lg">
                            <h4 class="text-3xl font-bold text-gray-800">{{ $totalMahasiswaWali }}</h4>
                            <p class="text-sm font-semibold text-gray-700 mt-1">Total Mahasiswa di Bawah Perwalian Anda</p>
                        </div>
                    </div>
                    {{-- ======================================================== --}}

                    <div class="mt-8 border-t pt-6">
                         <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Lihat Detail Mahasiswa Bimbingan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>