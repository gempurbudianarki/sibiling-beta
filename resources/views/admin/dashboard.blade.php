<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-500">Total Dosen</h3>
                        <p class="text-4xl font-bold mt-2">{{ number_format($totalDosen) }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-500">Total Mahasiswa</h3>
                        <p class="text-4xl font-bold mt-2">{{ number_format($totalMahasiswa) }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-500">Total Pengguna</h3>
                        <p class="text-4xl font-bold mt-2">{{ number_format($totalUsers) }}</p>
                    </div>
                </div>

            </div>

            {{-- Placeholder untuk konten/widget lain di masa depan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    Selamat datang, Admin!
                </div>
            </div>

        </div>
    </div>
</x-app-layout>