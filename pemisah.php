<?php

// ============== KONFIGURASI =================
$fileInput = 'bbg-sibiling.sql'; // Nama file sumber
$folderOutput = 'database/sql/'; // Folder tujuan
$fileOutputStruktur = $folderOutput . 'struktur_kampus.sql'; // Nama file output untuk struktur
$fileOutputData = $folderOutput . 'data_kampus.sql'; // Nama file output untuk data
// ===========================================

echo "Memulai proses pemisahan file otomatis...\n";

// Membuat folder 'database/sql/' jika belum ada
if (!is_dir($folderOutput)) {
    mkdir($folderOutput, 0777, true);
}

// Membuka semua file yang dibutuhkan
$handleInput = fopen($fileInput, "r");
$handleStruktur = fopen($fileOutputStruktur, "w");
$handleData = fopen($fileOutputData, "w");

if ($handleInput) {
    // Membaca file sumber baris per baris
    while (($line = fgets($handleInput)) !== false) {
        $trimmedLine = trim($line);

        // Cek jika baris dimulai dengan 'CREATE TABLE'
        if (str_starts_with($trimmedLine, 'CREATE TABLE')) {
            fwrite($handleStruktur, $line);
        } 
        // Cek jika baris dimulai dengan 'INSERT INTO'
        elseif (str_starts_with($trimmedLine, 'INSERT INTO')) {
            fwrite($handleData, $line);
        }
    }

    // Menutup semua file
    fclose($handleInput);
    fclose($handleStruktur);
    fclose($handleData);

    echo "SUKSES! File berhasil dipisahkan secara otomatis menjadi:\n";
    echo "- {$fileOutputStruktur}\n";
    echo "- {$fileOutputData}\n";

} else {
    echo "ERROR: Tidak dapat membuka file sumber: {$fileInput}. Pastikan filenya ada di folder yang sama dengan script ini.\n";
}