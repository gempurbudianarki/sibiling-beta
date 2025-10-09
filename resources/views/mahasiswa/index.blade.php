<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="mahasiswaPage()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <input type="text" x-model="search" @input.debounce.500ms="searchMahasiswa" placeholder="Cari nama atau NIM mahasiswa..." class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">NIM</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Prodi</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Angkatan</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700" x-show="!isLoading">
                                <template x-for="mhs in mahasiswaList" :key="mhs.nim">
                                    <tr>
                                        <td class="py-3 px-4" x-text="mhs.nim"></td>
                                        <td class="py-3 px-4" x-text="mhs.nm_mhs"></td>
                                        <td class="py-3 px-4" x-text="mhs.prodi ? mhs.prodi.nm_prodi : 'Tidak ada prodi'"></td>
                                        <td class="py-3 px-4 text-center" x-text="mhs.angkatan"></td>
                                        <td class="py-3 px-4 text-center">
                                            <button @click="viewDetails(mhs.nim)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="mahasiswaList.length === 0">
                                    <td colspan="5" class="text-center py-4">Data tidak ditemukan.</td>
                                </tr>
                            </tbody>
                        </table>
                        <div x-show="isLoading" class="text-center py-4">
                            <p>Loading...</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        {!! $mahasiswa->links() !!}
                    </div>
                </div>
            </div>
        </div>

        <div x-show="isModalOpen" @click.away="isModalOpen = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col" @click.stop>
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-xl font-semibold" x-text="`Detail Mahasiswa: ${selectedMhs.nm_mhs || ''}`"></h3>
                    <button @click="isModalOpen = false" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
                </div>
                
                <div x-show="isDetailLoading" class="text-center py-10">Loading...</div>

                <div x-show="!isDetailLoading && selectedMhs.nim" class="flex-grow overflow-y-auto" x-data="{ activeTab: 'akademik' }">
                    <div class="border-b">
                        <nav class="flex space-x-4 px-4">
                            <button @click="activeTab = 'akademik'" :class="{'border-blue-500 text-blue-600': activeTab === 'akademik', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'akademik'}" class="py-4 px-1 border-b-2 font-medium text-sm">Data Akademik</button>
                            <button @click="activeTab = 'pribadi'" :class="{'border-blue-500 text-blue-600': activeTab === 'pribadi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'pribadi'}" class="py-4 px-1 border-b-2 font-medium text-sm">Data Pribadi</button>
                            <button @click="activeTab = 'ortu'" :class="{'border-blue-500 text-blue-600': activeTab === 'ortu', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'ortu'}" class="py-4 px-1 border-b-2 font-medium text-sm">Data Orang Tua</button>
                        </nav>
                    </div>

                    <div class="p-6">
                        <div x-show="activeTab === 'akademik'">
                            <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">NIM</dt><dd x-text="selectedMhs.nim"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Prodi</dt><dd x-text="selectedMhs.prodi ? selectedMhs.prodi.nm_prodi : 'N/A'"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Angkatan</dt><dd x-text="selectedMhs.angkatan"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Semester Masuk</dt><dd x-text="selectedMhs.smt_masuk"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Dosen Wali</dt><dd x-text="selectedMhs.id_dosen_wali"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Status Mahasiswa</dt><dd x-text="selectedMhs.stat_mhs"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Tanggal Masuk</dt><dd x-text="selectedMhs.tgl_masuk_kuliah"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">IPK</dt><dd x-text="selectedMhs.ipk"></dd></div>
                            </dl>
                        </div>
                        <div x-show="activeTab === 'pribadi'">
                           <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Nama Lengkap</dt><dd x-text="selectedMhs.nm_mhs"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Tempat & Tanggal Lahir</dt><dd x-text="`${selectedMhs.tmpt_lahir}, ${selectedMhs.tgl_lahir}`"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Jenis Kelamin</dt><dd x-text="selectedMhs.jk === 'L' ? 'Laki-laki' : 'Perempuan'"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Agama</dt><dd x-text="selectedMhs.id_agama"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">No. KTP</dt><dd x-text="selectedMhs.no_ktp"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">Email</dt><dd x-text="selectedMhs.email"></dd></div>
                                <div class="border-b pb-2"><dt class="font-bold text-gray-600">No. HP</dt><dd x-text="selectedMhs.no_hp"></dd></div>
                                <div class="border-b pb-2 col-span-full"><dt class="font-bold text-gray-600">Alamat</dt><dd x-text="`${selectedMhs.jln}, ${selectedMhs.nama_desa}`"></dd></div>
                           </dl>
                        </div>
                        <div x-show="activeTab === 'ortu'">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold mb-2">Data Ayah</h4>
                                    <dl class="text-sm space-y-2">
                                        <div><dt class="font-bold text-gray-600">Nama Ayah</dt><dd x-text="selectedMhs.nama_ayah"></dd></div>
                                        <div><dt class="font-bold text-gray-600">No. KTP Ayah</dt><dd x-text="selectedMhs.no_ktp_ayah"></dd></div>
                                        <div><dt class="font-bold text-gray-600">Pendidikan Ayah</dt><dd x-text="selectedMhs.id_jenjang_pendidikan_ayah"></dd></div>
                                        <div><dt class="font-bold text-gray-600">Pekerjaan Ayah</dt><dd x-text="selectedMhs.id_pekerjaan_ayah"></dd></div>
                                    </dl>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2">Data Ibu</h4>
                                    <dl class="text-sm space-y-2">
                                        <div><dt class="font-bold text-gray-600">Nama Ibu</dt><dd x-text="selectedMhs.nama_ibu_kandung"></dd></div>
                                        <div><dt class="font-bold text-gray-600">No. KTP Ibu</dt><dd x-text="selectedMhs.no_ktp_ibu"></dd></div>
                                        <div><dt class="font-bold text-gray-600">Pendidikan Ibu</dt><dd x-text="selectedMhs.id_jenjang_pendidikan_ibu"></dd></div>
                                        <div><dt class="font-bold text-gray-600">Pekerjaan Ibu</dt><dd x-text="selectedMhs.id_pekerjaan_ibu"></dd></div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t text-right">
                    <button @click="isModalOpen = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mahasiswaPage() {
            return {
                mahasiswaList: @json($mahasiswa->items()),
                isLoading: false,
                isDetailLoading: false,
                search: '',
                isModalOpen: false,
                selectedMhs: {},
                viewDetails(nim) {
                    this.isModalOpen = true;
                    this.isDetailLoading = true;
                    this.selectedMhs = {}; 
                    fetch(`/admin/mahasiswa/${nim}`)
                        .then(res => res.json())
                        .then(data => {
                            this.selectedMhs = data;
                            this.isDetailLoading = false;
                        });
                },
                searchMahasiswa() {
                    // Fitur search bisa kita kembangkan lebih lanjut jika diperlukan
                }
            }
        }
    </script>
</x-app-layout>