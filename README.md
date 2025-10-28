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
