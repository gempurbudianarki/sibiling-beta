@forelse ($dosens as $dosen)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $dosen->nm_dos }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dosen->email_dos }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            @if ($dosen->user && $dosen->user->roles->isNotEmpty())
                @foreach ($dosen->user->roles as $role)
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $role->nama_role }}
                    </span>
                @endforeach
            @else
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                    Belum ada peran
                </span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <a href="{{ route('admin.roles.edit', ['dosen' => $dosen->email_dos]) }}" class="text-indigo-600 hover:text-indigo-900">
                Atur Peran
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
            Data dosen tidak ditemukan.
        </td>
    </tr>
@endforelse