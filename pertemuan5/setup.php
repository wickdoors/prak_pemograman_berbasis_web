<?php
require_once 'koneksi.php';

// 1. Buat database jika belum ada
$sql = "CREATE DATABASE IF NOT EXISTS akademik1";

if (mysqli_query($koneksi, $sql)) {
    echo "Database 'akademik1' berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Error membuat database: " . mysqli_error($koneksi) . "<br>";
}

mysqli_set_charset($koneksi, "utf8");

// 2. Pilih database
mysqli_select_db($koneksi, "akademik1");

// 3. Query pembuatan tabel (Koma berlebih & tipe data FK sudah diperbaiki)
$sqlcreateTable = [
    "mahasiswa" => "CREATE TABLE IF NOT EXISTS mahasiswa (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        nim VARCHAR(15) NOT NULL UNIQUE,
        prodi VARCHAR(80) NOT NULL,
        email VARCHAR(120) NOT NULL UNIQUE,
        angkatan YEAR NOT NULL,
        ipk DECIMAL(3,2) DEFAULT 0.00
    ) ENGINE=InnoDB",

    "dosen" => "CREATE TABLE IF NOT EXISTS dosen (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        nidn VARCHAR(20) NOT NULL UNIQUE,
        email VARCHAR(120) NOT NULL UNIQUE
    ) ENGINE=InnoDB",

    "matakuliah" => "CREATE TABLE IF NOT EXISTS matakuliah (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        kode_mk VARCHAR(12) NOT NULL UNIQUE,
        sks TINYINT UNSIGNED NOT NULL,
        dosen_id BIGINT NULL,
        FOREIGN KEY (dosen_id) REFERENCES dosen(id) ON DELETE CASCADE
    ) ENGINE=InnoDB"
];

// 4. Eksekusi Pembuatan Tabel
foreach ($sqlcreateTable as $namaTabel => $query) {
    if (mysqli_query($koneksi, $query)) {
        echo "Tabel '$namaTabel' berhasil dibuat atau sudah ada.<br>";
    } else {
        echo "Error membuat tabel '$namaTabel': " . mysqli_error($koneksi) . "<br>";
    }
}

mysqli_close($koneksi);
?>