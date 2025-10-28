# 🎓 SIBILING UBBG - Sistem Informasi Bimbingan Konseling

> 🌐 **SIBILING** adalah aplikasi web yang dirancang untuk mendigitalisasi dan mengelola alur layanan bimbingan konseling di **Universitas Bina Bangsa Getsempena (UBBG)**.  
> Dibuat untuk mahasiswa, dosen konselor, dosen pembimbing, dan admin agar alur konseling jadi lebih **efisien, transparan, dan modern**.

---

## 🚀 Tech Stack (Teknologi yang Digunakan)
![Laravel](https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel)
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

flowchart TD
    %% ==== Alur Pengajuan Konseling SIBILING UBBG ====

    %% --- Pengajuan Awal ---
    subgraph A1[Alur Pengajuan Awal]
        A[🧑‍🎓 Mahasiswa Ajukan Mandiri] -->|Isi Form Lengkap| B(📥 Menunggu Verifikasi Dosen Konseling)
        C[👨‍🏫 Dosen PA Rekomendasi] -->|Isi Form Rekomendasi| D(📥 Menunggu Kelengkapan Mahasiswa)
        D --> E[🧑‍🎓 Mahasiswa Lengkapi Form]
        E --> B
    end

    %% --- Verifikasi ---
    subgraph A2[Proses Verifikasi]
        B --> F{👩‍⚕️ Verifikasi oleh Dosen Konseling}
        F -- ✅ Lengkap & Valid --> G[✅ Disetujui]
        F -- ✏️ Perlu Perbaikan --> H[📝 Revisi oleh Mahasiswa]
        F -- ❌ Tidak Sesuai --> Z[⛔ Ditolak]
        H --> E
    end

    %% --- Proses Konseling ---
    subgraph A3[Proses Konseling]
        G --> I[📅 Penjadwalan Sesi Konseling]
        I --> J[📩 Notifikasi ke Mahasiswa]
        J --> K[💬 Sesi Konseling (Online/Offline)]
        K --> L[📝 Pengisian Hasil Konseling]
        L --> M{Perlu Sesi Lanjutan?}
        M -- Ya --> I
        M -- Tidak --> N[🏁 Kasus Selesai]
    end

    %% --- Style Warna ---
    style D fill:#fff3b0,stroke:#333,stroke-width:2px
    style H fill:#ffd59e,stroke:#333,stroke-width:2px
    style Z fill:#ffadad,stroke:#333,stroke-width:2px
    style G fill:#b7e4c7,stroke:#333,stroke-width:2px
    style N fill:#95d5b2,stroke:#333,stroke-width:2px


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

Tabel utama meliputi:  
- `mahasiswa` 🧑‍🎓  
- `dosen` 👨‍🏫  
- `roles` 🛠️  
- `konseling` 📑  
- `jadwal_konseling` 📅  
- `hasil_konseling` 📝  
- `prodi` 🎓  

---

## 📑 Struktur Menu & Fitur (Rencana Final)

| Role | Menu | Fitur |
|------|------|-------|
| 🛠️ **Admin** | Dashboard | Statistik global |
| | Manajemen Dosen | Detail lengkap (60+ kolom) ✅ |
| | Manajemen Mahasiswa | Per angkatan, detail prodi ✅ |
| | Manajemen Konseling | Monitoring kasus 🚧 |
| | Pengguna & Roles | Role-based access |
| | Laporan | Cetak statistik |
| 👩‍⚕️ **Dosen Konseling** | Dashboard | Jadwal + pengajuan baru |
| | Daftar Pengajuan | Verifikasi / revisi |
| | Jadwal Saya | Kelola jadwal |
| | Kasus Aktif | Isi hasil konseling |
| 👨‍🏫 **Dosen Pembimbing** | Dashboard | Ringkasan |
| | Mahasiswa Bimbingan | Status konseling |
| | Rekomendasikan Konseling | Form rekomendasi |
| 🧑‍🎓 **Mahasiswa** | Dashboard | Status konseling |
| | Ajukan Konseling | Form pengajuan |
| | Riwayat Konseling | Status, jadwal, hasil |

---

✨ Dibangun dengan ❤️ oleh **Tim SIBILING - UBBG**

---
