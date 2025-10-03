# 🎓 SIBILING UBBG - Sistem Informasi Bimbingan Konseling

SIBILING adalah sebuah aplikasi web yang dirancang untuk mendigitalisasi dan mengelola alur layanan bimbingan konseling di Universitas Bina Bangsa Getsempena (UBBG). Aplikasi ini dibangun untuk memfasilitasi mahasiswa dalam mengajukan permohonan konseling, serta membantu para Dosen Konselor dan Dosen Pembimbing dalam mengelola dan memantau proses konseling secara efisien dan terstruktur.

---

## 🚀 Tech Stack (Teknologi yang Digunakan)
- **Backend Framework**: Laravel 11
- **Frontend**: Blade Engine dengan Tailwind CSS & Alpine.js
- **Database**: MySQL
- **Lingkungan Development Lokal**: Laragon
- **Code Editor**: Visual Studio Code

---

## 🧩 Algoritma & Alur Kerja Utama
Sistem ini dirancang dengan 4 peran (aktor) utama, masing-masing dengan alur kerjanya sendiri.

### 1. Aktor Sistem
- 🧑‍🎓 **Mahasiswa**: Pengguna utama yang membutuhkan layanan konseling.
- 👩‍⚕️ **Dosen Konseling**: Konselor profesional yang bertugas memverifikasi, menjadwalkan, dan melaksanakan sesi konseling.
- 👨‍🏫 **Dosen Pembimbing**: Dosen Pembimbing Akademik (PA) yang dapat memantau status konseling mahasiswa bimbingannya dan merekomendasikan mereka untuk konseling.
- 🛠️ **Admin**: Super user yang mengelola data master, memantau seluruh aktivitas, dan memiliki hak akses penuh ke sistem.

### 2. Alur Pengajuan Konseling

**Inisiasi:**
- Jalur A (Inisiatif Mahasiswa): Mahasiswa login dan mengisi form pengajuan konseling. Sistem mencatat pengajuan dengan status *Menunggu Verifikasi*.
- Jalur B (Rekomendasi Dosen PA): Dosen Pembimbing merekomendasikan salah satu mahasiswa bimbingannya. Mahasiswa akan mendapat notifikasi untuk melengkapi data sebelum proses dilanjutkan.

**Verifikasi (oleh Dosen Konseling):**
- Dosen Konseling menerima notifikasi pengajuan baru.
- Jika data tidak lengkap → status diubah menjadi *Revisi Diperlukan* dan notifikasi dikirim ke mahasiswa.
- Jika data lengkap → pengajuan diterima dan status diubah menjadi *Terverifikasi*.

**Penjadwalan (oleh Dosen Konseling):**
- Untuk pengajuan yang sudah terverifikasi, Dosen Konseling membuat jadwal (tanggal, waktu, tempat/online).
- Status kasus diubah menjadi *Terjadwal*. Mahasiswa menerima notifikasi jadwal.

**Pelaksanaan & Pelaporan:**
- Sesi konseling berlangsung.
- Setelah selesai, Dosen Konseling mengisi `hasil_konseling` (catatan & rekomendasi).
- Jika butuh sesi lanjutan → kembali ke langkah Penjadwalan.
- Jika tuntas → status kasus diubah menjadi *Selesai ✅*.

---

## 🗄️ Struktur Database
Database proyek ini dibangun dan diisi menggunakan dua perintah utama di terminal. Proses ini memastikan bahwa struktur tabel sesuai dengan aturan dari sistem informasi kampus dan semua data warisan (legacy) berhasil diimpor.

### Perintah Setup Database
**Membangun Struktur Tabel (Migrations):**
```bash
php artisan migrate:fresh
```

**Mengisi Data dari Kampus (Import SQL):**
```bash
mysql -u root sibiling_bbg < database/sql/data_final.sql
```

---

## 📑 Struktur Menu & Fitur (Rencana Final)
Berikut adalah rencana menu yang akan tampil untuk setiap peran ketika aplikasi sudah jadi sepenuhnya.

### 🛠️ Menu Admin
- **Dashboard**: Tampilan statistik global (jumlah konseling, kasus aktif, dll).
- **Manajemen Dosen**: Melihat daftar semua dosen, dengan tombol "Lihat Detail" untuk menampilkan semua 60+ kolom data dalam jendela modal. (✅ Sudah Dibuat)
- **Manajemen Mahasiswa**: Melihat daftar semua mahasiswa, diurutkan per angkatan, dengan nama prodi yang sudah diterjemahkan dan tombol "Lihat Detail". (✅ Sudah Dibuat)
- **Manajemen Konseling**: Melihat semua kasus konseling yang sedang berjalan, menugaskan Dosen Konselor, dll. (🚧 Fitur Selanjutnya)
- **Manajemen Pengguna & Peran**: Mengelola akun login dan menetapkan peran.
- **Laporan**: Mencetak laporan statistik konseling.

### 👩‍⚕️ Menu Dosen Konseling
- **Dashboard**: Menampilkan jadwal konseling hari ini dan pengajuan baru yang masuk.
- **Daftar Pengajuan**: Memverifikasi, menerima, atau meminta revisi pengajuan dari mahasiswa.
- **Jadwal Saya**: Mengatur jadwal sesi konseling.
- **Kasus Aktif**: Melihat riwayat dan mengisi hasil untuk kasus yang sedang ditangani.

### 👨‍🏫 Menu Dosen Pembimbing
- **Dashboard**: Ringkasan aktivitas.
- **Mahasiswa Bimbingan**: Melihat daftar mahasiswa bimbingannya dan status konseling mereka (tanpa bisa melihat detail masalah).
- **Rekomendasikan Konseling**: Form untuk mendaftarkan mahasiswa bimbingannya.

### 🧑‍🎓 Menu Mahasiswa
- **Dashboard**: Tampilan utama.
- **Ajukan Konseling**: Form pengajuan konseling.
- **Riwayat Konseling Saya**: Melihat status dan riwayat semua pengajuan (pending, terjadwal, selesai), melihat jadwal, dan membaca hasil/rekomendasi dari konselor.

---

✨ Dibangun dengan ❤️ oleh **Tim SIBILING - UBBG**
