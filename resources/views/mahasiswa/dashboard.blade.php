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
                    <h3 class="text-lg font-semibold">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="mt-2">
                        Ini adalah halaman dashboard Anda. Di sini Anda dapat melihat status pengajuan konseling dan riwayat Anda.
                    </p>
                </div>
            </div>

            {{-- Placeholder untuk widget status konseling --}}
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="font-semibold">Status Konseling Terakhir</h4>
                    <p class="mt-2 text-gray-600">
                        {{-- TODO: Tampilkan data konseling terakhir di sini. Contoh: "Pengajuan Anda sedang diverifikasi." --}}
                        Saat ini belum ada data pengajuan konseling.
                    </p>
                    <div class="mt-4">
                        <a href="#" class="text-blue-500 hover:underline">Ajukan Konseling Baru</a>
                        <a href="#" class="ml-4 text-blue-500 hover:underline">Lihat Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>