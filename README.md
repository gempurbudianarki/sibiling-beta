.

-----

`README.md`

````markdown
# 🎓 SIBILING UBBG - Sistem Informasi Bimbingan Konseling

> 🌐 **SIBILING** adalah aplikasi web yang dirancang untuk mendigitalisasi dan mengelola alur layanan bimbingan konseling di **Universitas Bina Bangsa Getsempena (UBBG)**.  
> Dibuat untuk mahasiswa, dosen konselor, dosen pembimbing, dan admin agar alur konseling jadi lebih **efisien, transparan, dan modern**.

---

## 🚀 Tech Stack (Teknologi yang Digunakan)
![Laravel](https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel) {{-- Asumsi Laravel 12 dari composer.json --}}
![Blade](https://img.shields.io/badge/Frontend-Blade%20%2B%20Tailwind%20%2B%20Alpine-blue?style=for-the-badge&logo=tailwindcss)
![MySQL](https://img.shields.io/badge/Database-MySQL-orange?style=for-the-badge&logo=mysql)
![Laragon](https://img.shields.io/badge/Local-Laragon-green?style=for-the-badge)
![VSCode](https://img.shields.io/badge/Editor-VSCode-blue?style=for-the-badge&logo=visualstudiocode)

---

## 🧩 Algoritma & Alur Kerja Utama
Sistem ini dirancang dengan 4 peran (aktor) utama, masing-masing dengan alur kerjanya sendiri.

### 1. Aktor Sistem
- 🧑‍🎓 **Mahasiswa** → Pengguna utama yang membutuhkan layanan konseling.
- 👩‍⚕️ **Dosen Konseling** → Konselor profesional yang memverifikasi, menjadwalkan, dan melaksanakan sesi konseling.
- 👨‍🏫 **Dosen Pembimbing** → Dosen PA yang dapat memantau status konseling mahasiswa bimbingannya dan merekomendasikan mereka.
- 🛠️ **Admin** → Super user yang mengelola data master, memantau seluruh aktivitas, dan memiliki hak akses penuh.

### 2. Alur Pengajuan Konseling

```mermaid
flowchart TD
    subgraph "Alur Pengajuan Awal"
        A[🧑‍🎓 Mahasiswa Ajukan Mandiri] -->|Isi Form Lengkap| B(⏳ Menunggu Verifikasi);
        C[👨‍🏫 Dosen PA Rekomendasi] -->|Isi Form Awal| L(📥 Menunggu Kelengkapan Mahasiswa);
        L --> M[🧑‍🎓 Mahasiswa Buka & Lengkapi Form];
        M -->|Submit Form Lengkap| B;
    end

    subgraph "Proses Verifikasi oleh Dosen Konseling"
        B --> D{👩‍⚕️ Verifikasi Data?};
        D -- OK --> F[✅ Disetujui];
        D -- Butuh Perbaikan --> E[📝 Perlu Revisi];
        D -- Tidak Sesuai --> O[❌ Ditolak];
    end

    subgraph "Alur Revisi (jika diperlukan)"
        E -->|Kirim Notifikasi + Alasan| N[🧑‍🎓 Mahasiswa Buka & Revisi Form];
        N -->|Submit Ulang Form| B; {{-- Kembali ke Verifikasi --}}
    end
    
    subgraph "Proses Konseling (jika disetujui)"
        F --> G[📅 Dosen Konseling Buat Jadwal];
        G --> H[📌 Status Terjadwal + Notifikasi Mhs];
        H --> I[💬 Sesi Konseling (Online/Offline)];
        I --> J[📝 Dosen Konseling Isi Hasil Sesi];
        J -->|Perlu Sesi Lanjutan?| Q{Keputusan};
        Q -- Ya --> G;
        Q -- Tidak --> K[🏁 Kasus Selesai];
    end

    style L fill:#fdfd96,stroke:#333,stroke-width:2px; {{-- Kuning muda u/ Menunggu Mhs --}}
    style E fill:#ffb347,stroke:#333,stroke-width:2px; {{-- Oranye u/ Revisi --}}
    style O fill:#ff6961,stroke:#333,stroke-width:2px; {{-- Merah muda u/ Ditolak --}}
    style F fill:#b0e57c,stroke:#333,stroke-width:2px; {{-- Hijau muda u/ Disetujui --}}
    style K fill:#77dd77,stroke:#333,stroke-width:2px; {{-- Hijau u/ Selesai --}}
````

-----

## 🗄️ Struktur Database

Database proyek ini dibangun dan diisi menggunakan dua perintah utama di terminal. Proses ini memastikan bahwa struktur tabel sesuai dengan aturan dari sistem informasi kampus dan semua data warisan (legacy) berhasil diimpor.

### Perintah Setup Database

**Membangun Struktur Tabel (Migrations):**

```bash
php artisan migrate:fresh
```

**Mengisi Data dari Kampus (Import SQL):**

```bash
mysql -u root -p sibiling_bbg < database/sql/data_final.sql 
{{-- Tambahkan -p jika MySQL root ada password --}}
```

Tabel utama meliputi:

  - `users` 👤 (Tabel auth Laravel)
  - `mahasiswa` 🧑‍🎓 (Profil Mahasiswa)
  - `dosen` 👨‍🏫 (Profil Dosen)
  - `roles` & `permissions` 🛠️ (Tabel Spatie RBAC)
  - `konseling` 📑 (Data utama kasus konseling)
  - `jadwal_konseling` 📅 (Jadwal sesi per kasus)
  - `hasil_konseling` 📝 (Hasil per sesi)
  - `prodi` 🎓 (Data Program Studi)
  - `pt` 🏢 (Data Perguruan Tinggi - opsional)

-----

## 📑 Struktur Menu & Fitur (Rencana Final)

| Role | Menu | Fitur | Status |
|------|------|-------|--------|
| 🛠️ **Admin** | Dashboard | Statistik global | 🚧 |
| | Manajemen Dosen | CRUD & Detail Dosen | ✅ |
| | Manajemen Mahasiswa | CRUD & Detail Mahasiswa | ✅ |
| | Pengguna & Roles | Assign Roles (Edit) | ✅ |
| | Manajemen Konseling | Monitoring semua kasus | 🚧 |
| | Laporan | Cetak statistik | 🚧 |
| 👩‍⚕️ **Dosen Konseling** | Dashboard | Jadwal hari ini + pengajuan baru | 🚧 |
| | Daftar Pengajuan | Verifikasi / Tolak / Revisi | ✅ |
| | Jadwal Saya | Lihat Jadwal | ✅ |
| | | Buat Jadwal | ✅ |
| | Kasus Aktif | Lihat daftar kasus berjalan | ✅ |
| | | Isi Hasil Konseling | ✅ |
| 👨‍🏫 **Dosen Pembimbing** | Dashboard | Ringkasan mahasiswa bimbingan | 🚧 |
| | Mahasiswa Bimbingan | Lihat daftar & status konseling mhs | ✅ |
| | Rekomendasikan Konseling | Form rekomendasi | ✅ |
| 🧑‍🎓 **Mahasiswa** | Dashboard | Status pengajuan aktif | 🚧 |
| | Ajukan Konseling | Form pengajuan mandiri | ✅ |
| | Riwayat Konseling | Lihat status, jadwal, hasil | ✅ |
| | | Lengkapi/Revisi pengajuan | ✅ |

*(✅ = Selesai, 🚧 = Belum/Dalam Pengembangan)*

-----

✨ Dibangun dengan ❤️ oleh **Tim SIBILING - UBBG**

-----

```

**Perubahan:**
1.  **Flowchart:** Menggunakan kode Mermaid yang baru.
2.  **Tech Stack:** Mengupdate versi Laravel ke 12 berdasarkan `composer.json`.
3.  **Struktur Database:** Menambahkan tabel `users` dan `permissions`, memperbaiki perintah SQL import (menambahkan `-p` jika ada password), dan merapikan daftar tabel.
4.  **Struktur Menu:** Menambahkan kolom "Status" untuk melacak progres fitur.

Silakan *copy-paste* seluruh konten di atas ke file `README.md` lo.
```
