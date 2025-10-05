<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengguna & Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <p class="mb-4 text-gray-600">
                        Gunakan kotak di bawah untuk mencari nama dosen secara *real-time*.
                    </p>

                    {{-- FORM PENCARIAN (TANPA TOMBOL SUBMIT) --}}
                    <div class="mb-4">
                        <input type="text" id="searchInput" placeholder="Ketik nama dosen untuk mencari..."
                               class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Dosen</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran Saat Ini</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            {{-- Beri ID agar mudah dimanipulasi oleh JavaScript --}}
                            <tbody id="dosen-table-body" class="bg-white divide-y divide-gray-200">
                                {{-- Muat data awal menggunakan view parsial --}}
                                @include('admin.roles._dosen_table_rows', ['dosens' => $dosens])
                            </tbody>
                        </table>
                    </div>

                    {{-- Link pagination, akan disembunyikan saat live search aktif --}}
                    <div id="pagination-links" class="mt-4">
                        {{ $dosens->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- ==== KODE JAVASCRIPT UNTUK LIVE SEARCH ==== --}}
    {{-- ====================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('dosen-table-body');
            const paginationLinks = document.getElementById('pagination-links');
            let typingTimer;
            const doneTypingInterval = 300; // Jeda 0.3 detik setelah ketikan terakhir

            searchInput.addEventListener('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(performSearch, doneTypingInterval);
            });

            function performSearch() {
                const query = searchInput.value;

                // Tampilkan loading
                tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4">Mencari...</td></tr>';

                // Sembunyikan pagination saat mencari
                if (query.length > 0) {
                    paginationLinks.style.display = 'none';
                } else {
                    paginationLinks.style.display = 'block';
                }

                // Kirim request ke server
                fetch(`{{ route('admin.roles.search') }}?search=${query}`)
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-red-500">Terjadi kesalahan.</td></tr>';
                    });
            }
        });
    </script>
</x-app-layout>