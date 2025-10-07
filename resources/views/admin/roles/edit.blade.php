<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.roles.index') }}" class="text-blue-500 hover:underline">&larr; Kembali</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
            Edit Peran untuk: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 border-b pb-4">
                        <p class="text-sm text-gray-500">NIDN: {{ $user->dosen->nidn ?? 'Tidak tersedia' }}</p>
                        <p class="text-sm text-gray-500">Email: {{ $user->email }}</p>
                    </div>

                    <form method="POST" action="{{ route('admin.roles.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <h3 class="font-medium text-gray-900">Tetapkan Peran</h3>
                            <p class="text-sm text-gray-600 mt-1">Pilih satu atau lebih peran untuk pengguna ini.</p>
                            
                            <div class="mt-4 space-y-2">
                                @foreach ($roles as $role)
                                    @if($role->nama_role === 'admin' && !in_array($role->id_role, $userRoles))
                                        @continue
                                    @endif
                                    
                                    <label class="flex items-center">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id_role }}" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               {{-- INI PERBAIKANNYA: Cek apakah ID role ada di dalam array $userRoles --}}
                                               @if(in_array($role->id_role, $userRoles)) checked @endif
                                               @if($role->nama_role === 'admin') disabled @endif>
                                        
                                        <span class="ms-2 text-sm text-gray-600">{{ str_replace('_', ' ', Str::title($role->nama_role)) }}</span>

                                        @if($role->nama_role === 'admin')
                                            <span class="ms-2 text-xs text-red-500">(Tidak dapat diubah)</span>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>