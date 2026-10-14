<?php
$host     = '127.0.0.1';
$user     = "root";
$password = "";
$db_name  = "akademik1"; // Ubah sesuai nama database yang kamu buat di phpMyAdmin
$port     = 3306;

$koneksi = mysqli_connect($host, $user, $password, $db_name, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
echo "Koneksi berhasil!";
?>