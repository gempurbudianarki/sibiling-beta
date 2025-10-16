<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 space-y-8">

                    {{-- Tombol Kembali --}}
                    <div>
                        <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Kembali ke Daftar Pengajuan
                        </a>
                    </div>
                    
                    {{-- Detail Pengajuan --}}
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Informasi Pengajuan</h3>
                        <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Mahasiswa</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $pengajuan->mahasiswa->nm_mhs ?? 'N/A' }}</dd></div>
                            <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIM</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $pengajuan->nim_mahasiswa }}</dd></div>
                            <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pengajuan</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->translatedFormat('d F Y') }}</dd></div>
                            <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bidang Layanan</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 capitalize">{{ $pengajuan->bidang_layanan ?: '-' }}</dd></div>
                            <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tujuan Konseling</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $pengajuan->tujuan_konseling ?: '-' }}</dd></div>
                            <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi Masalah</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $pengajuan->deskripsi_masalah ?: '-' }}</dd></div>
                        </dl>
                    </div>

                    {{-- Form Persetujuan --}}
                    <div x-data="{ showModal: false }">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Persetujuan Pengajuan</h3>
                        @if(in_array($pengajuan->status_konseling, ['Menunggu Verifikasi', 'pending']))
                        <form id="approvalForm" action="{{ route('dosen-konseling.pengajuan.updateStatus', $pengajuan->id_konseling) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput">
                            
                            {{-- Modal untuk alasan penolakan --}}
                            <div x-show="showModal" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;"></div>

                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 text-right sm:px-8 -mx-8 -mb-8 rounded-b-lg">
                                {{-- === PERBAIKAN VALUE DI SINI === --}}
                                <button type="button" @click="showModal = true" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">Tolak</button>
                                <button type="submit" onclick="document.getElementById('statusInput').value='disetujui';" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">Setujui Pengajuan</button>
                            </div>
                        </form>
                        @else
                        <div class="mt-4 p-4 bg-blue-50 border-blue-200 rounded-md"><p class="text-sm text-blue-700">Status pengajuan ini adalah <span class="font-semibold">{{ $pengajuan->status_konseling }}</span>.</p></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>