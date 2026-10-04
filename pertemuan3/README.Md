# Tugas Praktikum - Pertemuan 3

## 1. Modifikasi Program
Pada tugas ini dilakukan 2 modifikasi bermakna pada database `akademik1` (khususnya tabel `mahasiswa`)[cite: 1, 2, 3, 5, 6]:
1. **Penambahan Field Baru (`status_aktif`)**: Menambahkan kolom `status_aktif` bertipe `ENUM('aktif', 'cuti', 'lulus')` dengan nilai default `'aktif'` untuk mencatat status keaktifan mahasiswa[cite: 1, 3, 5, 6].
2. **Validasi Data IPK (`CHECK Constraint`)**: Menambahkan constraint `CHECK` pada kolom `ipk` untuk memvalidasi rentang nilai IPK (0.00 - 4.00)[cite: 1, 3, 5, 6].

---

## 2. Penjelasan 5 Bagian Kode Paling Penting
1. **`CREATE TABLE mahasiswa`**: Mengatur `nim` sebagai *Primary Key* untuk mencegah duplikasi data[cite: 2, 5], serta menerapkan atribut `status_aktif` dan constraint `CHECK` untuk menjaga rentang IPK (0.00 - 4.00)[cite: 1, 3, 5, 6].
2. **`ALTER TABLE krs` (Relasi Foreign Key Mahasiswa)**: Mengaitkan tabel `krs` ke tabel `mahasiswa`[cite: 2, 5]. Aturan `ON DELETE CASCADE` dan `ON UPDATE CASCADE` memastikan jika data mahasiswa dihapus/diubah, data KRS terkait akan diperbarui otomatis demi menjaga integritas data[cite: 2, 5, 6].
3. **`ALTER TABLE mata_kuliah` (Relasi Foreign Key Dosen)**: Menghubungkan tabel `mata_kuliah` ke `dosen`[cite: 2, 5]. Opsi `ON DELETE SET NULL` memastikan jika data dosen dihapus, data mata kuliah tetap ada dengan kolom `nidn` diubah menjadi `NULL`[cite: 2, 5, 6].
4. **`UNIQUE KEY uq_krs` pada Tabel `krs`**: Memastikan tidak ada pengulangan pengisian KRS sehingga seorang mahasiswa tidak dapat mengambil mata kuliah yang sama lebih dari satu kali dalam semester dan tahun ajaran yang sama[cite: 2, 5, 6].
5. **`INSERT INTO mahasiswa`**: Query DML untuk mengisikan data master awal mahasiswa sebagai bahan pengujian awal sebelum tabel transaksi KRS diisi[cite: 2, 5, 6].

---

## 3. Screenshot Sebelum dan Sesudah Modifikasi

### Kodingan/Struktur Sebelum Modifikasi
Struktur tabel `mahasiswa` awal sebelum ditambahkan kolom/fungsi baru[cite: 1, 3, 6]:
![Sebelum Modifikasi](pertemuan3/SS/Cuplikan layar 2026-10-04 202513.png)

### Output/Hasil Sesudah Modifikasi
Struktur tabel `mahasiswa` setelah ditambahkan kolom `status_aktif` dan constraint validasi IPK[cite: 1, 3, 6]:
![Sesudah Modifikasi](pertemuan3/SS/Cuplikan layar 2026-10-04 204412.png)

---

## 4. Error yang Pernah Muncul
* **Error**: `#1050 - Table 'mahasiswa' already exists`[cite: 4, 6]
* **Penyebab**: Terjadi konflik saat pembuatan tabel baru karena tabel bernama `mahasiswa` sudah ada sebelumnya di dalam database `akademik1`[cite: 2, 4, 5, 6].
* **Langkah Perbaikan**: Menghapus tabel berelasi (`krs`) dan tabel induk (`mahasiswa`) terlebih dahulu menggunakan perintah `DROP TABLE IF EXISTS` sebelum meng-import skema baru[cite: 2, 5, 6], atau memperbarui struktur tabel menggunakan perintah `ALTER TABLE`[cite: 6]:
  ```sql
  ALTER TABLE `mahasiswa` 
  ADD COLUMN `status_aktif` ENUM('aktif', 'cuti', 'lulus') NOT NULL DEFAULT 'aktif' AFTER `ipk`;

  ALTER TABLE `mahasiswa` 
  ADD CONSTRAINT `chk_ipk_range` CHECK (`ipk` BETWEEN 0.00 AND 4.00);