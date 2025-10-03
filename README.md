# SIBILING UBBG - Sistem Informasi Bimbingan Konseling

SIBILING adalah sebuah aplikasi web yang dirancang untuk mendigitalisasi dan mengelola alur layanan bimbingan konseling di Universitas Bina Bangsa Getsempena (UBBG). Aplikasi ini dibangun untuk memfasilitasi mahasiswa dalam mengajukan permohonan konseling, serta membantu para Dosen Konselor dan Dosen Pembimbing dalam mengelola dan memantau proses konseling secara efisien dan terstruktur.

## Tech Stack (Teknologi yang Digunakan)

-   **Backend Framework**: Laravel 11
-   **Frontend**: Blade Engine dengan Tailwind CSS & Alpine.js
-   **Database**: MySQL
-   **Lingkungan Development Lokal**: Laragon
-   **Code Editor**: Visual Studio Code

---

## Algoritma & Alur Kerja Utama

Sistem ini dirancang dengan beberapa peran (aktor) utama, masing-masing dengan alur kerjanya sendiri.

### 1. Aktor Sistem

-   **🧑‍🎓 Mahasiswa**: Pengguna utama yang membutuhkan layanan konseling.
-   **👩‍⚕️ Dosen Konseling**: Konselor profesional yang bertugas memverifikasi, menjadwalkan, dan melaksanakan sesi konseling.
-   **👨‍🏫 Dosen Pembimbing**: Dosen Pembimbing Akademik (PA) yang dapat memantau status konseling mahasiswa bimbingannya dan merekomendasikan mereka untuk konseling.
-   **🛠️ Admin**: Super user yang mengelola data master, memantau seluruh aktivitas, dan memiliki hak akses penuh ke sistem.

### 2. Alur Pengajuan Konseling

1.  **Inisiasi**: Mahasiswa atau Dosen Pembimbing memulai pengajuan konseling.
2.  **Verifikasi**: Dosen Konseling memeriksa kelengkapan data pengajuan.
3.  **Penjadwalan**: Dosen Konseling mengatur jadwal sesi pertemuan.
4.  **Pelaksanaan**: Sesi konseling berlangsung.
5.  **Pelaporan**: Dosen Konseling mengisi catatan hasil konseling.
6.  **Selesai/Lanjutan**: Kasus ditutup atau dijadwalkan untuk sesi berikutnya.

---

## Setup & Instalasi Proyek

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan development lokal.

### 1. Persiapan Awal

-   Pastikan **Laragon** (atau environment sejenis seperti XAMPP) sudah terinstal dan berjalan.
-   Pastikan **Composer** dan **Node.js/NPM** sudah terinstal.
-   Clone repositori ini ke dalam folder `www` Laragon-mu.
    ```bash
    git clone [URL_REPOSITORI_ANDA]
    ```
-   Masuk ke direktori proyek.
    ```bash
    cd nama-proyek
    ```

### 2. Instalasi Backend (PHP)

-   Salin file environment.
    ```bash
    copy .env.example .env
    ```
-   Buka file `.env` dan sesuaikan konfigurasi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
-   Install semua dependency PHP.
    ```bash
    composer install
    ```
-   Generate application key.
    ```bash
    php artisan key:generate
    ```

### 3. Setup Database (Struktur & Data)

Proyek ini menggunakan data warisan (*legacy*) dari kampus. Proses setup database dilakukan dengan dua perintah utama.

1.  **Membangun Struktur Tabel (Migrations):**
    Perintah ini akan membangun semua tabel yang dibutuhkan (Laravel & Kampus) dalam keadaan kosong.
    ```bash
    php artisan migrate:fresh
    ```

2.  **Mengisi Data dari Kampus (Import SQL):**
    Perintah ini akan mengeksekusi file SQL yang berisi puluhan ribu data dosen dan mahasiswa. Pastikan file `data_final.sql` ada di folder `database/sql/`.
    ```bash
    mysql -u [username_db] -p[password_db] [nama_db] < database/sql/data_final.sql
    ```
    *Contoh untuk Laragon:*
    ```bash
    mysql -u root sibiling_bbg < database/sql/data_final.sql
    ```

3.  **Membuat User Admin Awal:**
    Untuk membuat user admin pertama kali agar bisa login.
    ```bash
    php artisan tinker
    ```
    Lalu paste skrip berikut di dalam `tinker`:
    ```php
    $adminRole = App\Models\Role::firstOrCreate(['nama_role' => 'admin']);
    $adminUser = App\Models\User::firstOrCreate(['username' => 'admin'], ['name' => 'Admin', 'email' => 'admin@sibiling.test', 'password' => Illuminate\Support\Facades\Hash::make('password')]);
    $adminUser->roles()->syncWithoutDetaching([$adminRole->id_role]);
    exit;
    ```

### 4. Instalasi Frontend (JS & CSS)

-   Install semua dependency JavaScript.
    ```bash
    npm install
    ```

### 5. Menjalankan Proyek

1.  Jalankan server development untuk frontend (biarkan terminal ini tetap berjalan).
    ```bash
    npm run dev
    ```
2.  Buka terminal baru, dan jalankan server development untuk backend.
    ```bash
    php artisan serve
    ```
-   Aplikasi akan berjalan di `http://127.0.0.1:8000`.

---

## Struktur Menu & Fitur (Rencana Final)

### 🛠️ Menu Admin

-   **Dashboard**: Tampilan statistik global.
-   **Manajemen Dosen**: Melihat daftar semua dosen dengan fitur "Lihat Detail".
-   **Manajemen Mahasiswa**: Melihat daftar semua mahasiswa dengan fitur "Lihat Detail".
-   **Manajemen Konseling**: (Fitur Selanjutnya).
```eof

### **Caranya:**

1.  Di VS Code, buka file `README.md` yang ada di folder root proyekmu.
2.  Hapus semua isinya.
3.  **Copy-paste seluruh kode** di atas ke dalam file `README.md` tersebut.
4.  Simpan filenya.

Setelah itu, saat kamu *push* ke GitHub, halaman depan repositorimu akan menampilkan dokumentasi yang rapi dan profesional ini. Gitu maksudnya kan, bro?