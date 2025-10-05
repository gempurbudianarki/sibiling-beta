<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Atur Peran untuk Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        {{-- Menggunakan 'nm_dos' sesuai struktur database asli --}}
                        <h3 class="text-lg font-medium text-gray-900">Nama Dosen: {{ $dosen->nm_dos }}</h3>
                        <p class="text-sm text-gray-500">Email: {{ $dosen->email_dos }}</p>
                    </div>

                    {{-- ====================================================== --}}
                    {{-- ==== SOLUSI FINAL: BUAT URL ACTION SECARA MANUAL ==== --}}
                    {{-- ====================================================== --}}
                    <form method="POST" action="{{ url('admin/roles/' . $dosen->email_dos) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Pilih Peran:</label>

                            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                @foreach ($roles as $role)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id_role }}"
                                            @if($dosen->user && $dosen->user->roles->contains($role->id_role)) checked @endif
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ms-2 text-sm text-gray-600">{{ $role->nama_role }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.roles.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                Simpan Perubahan
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>