# Laporan Tugas Praktikum Individu - Pertemuan 3

**Mata Kuliah:** Pemrograman Berbasis Web  
**Mahasiswa:** Muhammad Fariz Fahreza (4524210062)  
**Praktikum:** PRAK-PBW-B (Kelas B)  
**Database:** `akademik1`  
**Tools DBMS:** XAMPP / phpMyAdmin / MariaDB  

---

## 1. Eksekusi Program
Seluruh contoh program, query SQL, dan script dari Pertemuan 3 telah berhasil dijalankan menggunakan environment **XAMPP (Apache & MySQL/MariaDB)** tanpa menghasilkan error kritis. Database `akademik1` beserta tabel `dosen`, `mahasiswa`, `mata_kuliah`, dan `krs` telah di-import dan berjalan dengan normal[cite: 2, 3, 5].

---

## 2. Modifikasi Program
Dua modifikasi bermakna yang telah diterapkan pada database `akademik1` (khususnya pada tabel `mahasiswa`)[cite: 1, 2, 3, 5]:

1. **Modifikasi 1 (Penambahan Field/Kolom Baru):**  
   Menambahkan kolom `status_aktif` pada tabel `mahasiswa` bertipe `ENUM('aktif', 'cuti', 'lulus')` dengan nilai default `'aktif'` untuk mencatat status keaktifan mahasiswa.
2. **Modifikasi 2 (Validasi Data & Constraint Baru):**  
   Menambahkan constraint `CHECK` pada kolom `ipk` tabel `mahasiswa` untuk memvalidasi agar nilai IPK yang di-input wajib berada pada rentang `0.00` hingga `4.00`.

---

## 3. Penjelasan 5 Bagian Kode Paling Penting

Berikut adalah 5 bagian kode/query SQL utama yang krusial dari file `akademik1.sql` beserta fungsinya[cite: 1, 3, 5]:

### 1. Pembuatan Tabel `mahasiswa` dengan Kolom Modifikasi
```sql
CREATE TABLE `mahasiswa` (
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` year NOT NULL DEFAULT '0000',
  `ipk` decimal(3,2) DEFAULT NULL,
  `status_aktif` enum('aktif','cuti','lulus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`nim`),
  UNIQUE KEY `email` (`email`),
  CONSTRAINT `chk_ipk_range` CHECK (`ipk` BETWEEN 0.00 AND 4.00)
);

### Integrity Foreign Key pada Tabel 
ALTER TABLE `krs`
  ADD CONSTRAINT `fk_krs_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_krs_mk` FOREIGN KEY (`kode_mk`) REFERENCES `mata_kuliah` (`kode_mk`) ON UPDATE CASCADE;

###  Relasi Foreign Key Mata Kuliah dan Dosen
ALTER TABLE `mata_kuliah`
  ADD CONSTRAINT `fk_mk_dosen` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`) ON DELETE SET NULL ON UPDATE CASCADE;

### Kombinasi Unique Key pada Tabel krs
ALTER TABLE `krs`
  ADD UNIQUE KEY `uq_krs` (`nim`,`kode_mk`,`semester`,`tahun_ajaran`);

###  Input Data Mahasiswa
INSERT INTO `mahasiswa` (`nim`, `nama`, `email`, `prodi`, `angkatan`, `ipk`, `status_aktif`) VALUES
('2026001', 'Andi Pratama', 'andi@kampus.ac.id', 'Teknik Informatika', '2026', 3.75, 'aktif'),
('2026002', 'Siti Rahma', 'siti@kampus.ac.id', 'Sistem Informasi', '2026', 3.82, 'aktif'),
('4524210062', 'Fariz Fahreza', 'fariz@kampus.ac.id', 'Teknik Informatika', '2026', 3.90, 'aktif'),
('4524210072', 'krisna kopit', 'krisna@kampus.ac.id', 'Teknik Informatika', '2026', 4.00, 'aktif');


## 4. Screenshot Sebelum dan Sesudah Modifikasi

### A. Tampilan Sebelum Modifikasi
Struktur tabel `mahasiswa` awal sebelum ditambahkan kolom/fungsi baru:
![Sebelum Modifikasi] (pertemuan3/SS/Cuplikan layar 2026-10-04 202513.png)

### B. Tampilan Sesudah Modifikasi
Struktur tabel `mahasiswa` setelah ditambahkan kolom status_aktif dan constraint validasi IPK:
![Sesudah Modifikasi] (pertemuan3/SS/Cuplikan layar 2026-10-04 204412.png)


5. Analisis dan Langkah Perbaikan Error
Detail Kendala / Error yang Pernah Muncul
Saat melakukan perancangan dan import skema tabel mahasiswa, eksekusi query sempat gagal dan menampilkan pesan error.   
JPEG
+ 2

Pesan Error:

Plaintext
#1050 - Table 'mahasiswa' already exists
Analisis Penyebab Error:
Terjadi konflik pembuatan tabel karena tabel bernama mahasiswa sudah ada sebelumnya di dalam database akademik1. MariaDB/MySQL menolak membuat tabel baru dengan nama yang sama.   
SQL
+ 3

Langkah Perbaikan (Solusi):

Menghapus tabel berelasi (krs) dan tabel induk (mahasiswa) terlebih dahulu menggunakan perintah DROP TABLE IF EXISTS sebelum meng-import skema baru.   
SQL
+ 1

Alternatif perbaikan tanpa menghapus tabel lama adalah menggunakan perintah ALTER TABLE:

SQL
ALTER TABLE `mahasiswa` 
ADD COLUMN `status_aktif` ENUM('aktif', 'cuti', 'lulus') NOT NULL DEFAULT 'aktif' AFTER `ipk`;

ALTER TABLE `mahasiswa` 
ADD CONSTRAINT `chk_ipk_range` CHECK (`ipk` BETWEEN 0.00 AND 4.00);
Mengulang eksekusi query. Struktur tabel dan data berhasil dimasukkan tanpa error[cite: 1, 3, 5].