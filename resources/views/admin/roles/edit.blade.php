<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Role untuk: ') }} <span class="font-bold">{{ $user->dosen->nm_dosen ?? $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.roles.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Roles Tersedia</h3>
                            <p class="mt-1 text-sm text-gray-600">Pilih satu atau lebih role untuk dosen ini.</p>
                        </div>
                        
                        <div class="space-y-2">
                            @foreach ($roles as $role)
                                <div class="flex items-center">
                                    <input id="role_{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->name }}" 
                                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                           {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                    <label for="role_{{ $role->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.roles.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            
                            <x-primary-button>
                                {{ __('Update Role') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>