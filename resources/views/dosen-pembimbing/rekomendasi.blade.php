<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pendaftaran Konseling (Rekomendasi Dosen PA)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    <form action="{{ route('dosen-pembimbing.rekomendasi.store') }}" method="POST">
                        @csrf

                        <div class="mb-8 text-center border-b pb-4">
                            <h3 class="text-xl font-bold text-gray-900">
                                FORMULIR PENDAFTARAN KONSELING
                            </h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Diisi oleh Dosen PA untuk merekomendasikan mahasiswa bimbingan.
                            </p>
                        </div>
                        
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <div class="font-bold">Terjadi Kesalahan!</div>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status') === 'rekomendasi-sent')
                            <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                                <span class="font-medium">Sukses!</span> Rekomendasi konseling telah berhasil dikirim.
                            </div>
                        @endif

                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Identitas Mahasiswa</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 border rounded-lg">
                                <div class="md:col-span-2">
                                    <label for="nim" class="block mb-2 text-sm font-medium text-gray-900">Pilih Mahasiswa <span class="text-red-500">*</span></label>
                                    <select id="nim" name="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                        <option value="" disabled selected>-- Cari dan Pilih Mahasiswa Bimbingan --</option>
                                        @foreach ($mahasiswaBimbingan as $mahasiswa)
                                            <option value="{{ $mahasiswa->nim }}" 
                                                data-prodi="{{ $mahasiswa->prodi->nm_prodi ?? 'N/A' }}" 
                                                data-email="{{ $mahasiswa->email ?? 'N/A' }}"
                                                data-nohp="{{ $mahasiswa->no_hp ?? 'N/A' }}"
                                                data-alamat="{{ $mahasiswa->jln ?? 'N/A' }}"
                                                data-agama="{{ $mahasiswa->id_agama ?? 'N/A' }}"
                                                data-ttl="{{ ($mahasiswa->tmpt_lahir ?? '') . ', ' . (isset($mahasiswa->tgl_lahir) ? \Carbon\Carbon::parse($mahasiswa->tgl_lahir)->format('d F Y') : '') }}"
                                                {{ old('nim') == $mahasiswa->nim ? 'selected' : '' }}>
                                                {{ $mahasiswa->nm_mhs }} ({{ $mahasiswa->nim }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="prodi" class="block mb-2 text-sm font-medium text-gray-900">Program Studi</label>
                                    <input type="text" id="prodi" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" readonly>
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                    <input type="text" id="email" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" readonly>
                                </div>
                                <div>
                                    <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900">No. Telp/WA</label>
                                    <input type="text" id="no_hp" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" readonly>
                                </div>
                                 <div>
                                    <label for="ttl" class="block mb-2 text-sm font-medium text-gray-900">Tempat/Tgl Lahir</label>
                                    <input type="text" id="ttl" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" readonly>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                                    <input type="text" id="alamat" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Detail Permasalahan</h4>
                            <div class="space-y-6 p-6 border rounded-lg">
                                <div>
                                    <label for="permasalahan" class="block mb-2 text-sm font-medium text-gray-900">Jelaskan permasalahan yang sedang dihadapi <span class="text-red-500">*</span></label>
                                    <textarea id="permasalahan" name="permasalahan_segera" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan secara objektif dari sudut pandang Anda sebagai Dosen PA mengenai masalah yang dihadapi mahasiswa..." required>{{ old('permasalahan_segera') }}</textarea>
                                </div>
                                <div>
                                    <label for="harapan" class="block mb-2 text-sm font-medium text-gray-900">Jelaskan harapan yang ingin dicapai setelah mengikuti konseling <span class="text-red-500">*</span></label>
                                    <textarea id="harapan" name="harapan_konseling" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan harapan Anda sebagai Dosen PA terhadap hasil dari proses konseling ini..." required>{{ old('harapan_konseling') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3">
                                Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk memicu pengisian data otomatis
        function populateStudentData() {
            const select = document.getElementById('nim');
            // Pastikan ada opsi yang terpilih
            if (select.selectedIndex <= 0) return;

            const selectedOption = select.options[select.selectedIndex];
            document.getElementById('prodi').value = selectedOption.getAttribute('data-prodi');
            document.getElementById('email').value = selectedOption.getAttribute('data-email');
            document.getElementById('no_hp').value = selectedOption.getAttribute('data-nohp');
            document.getElementById('ttl').value = selectedOption.getAttribute('data-ttl');
            document.getElementById('alamat').value = selectedOption.getAttribute('data-alamat');
        }

        // Event listener saat pilihan berubah
        document.getElementById('nim').addEventListener('change', populateStudentData);
        
        // Panggil fungsi saat halaman dimuat untuk mengisi data jika ada 'old' input
        document.addEventListener('DOMContentLoaded', populateStudentData);
    </script>
</x-app-layout>