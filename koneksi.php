<?php
$servername = "localhost";
$username   = "root";   // default XAMPP user
$password   = "";       // default XAMPP password kosong
$database   = "tegalsempu"; // ganti dengan nama database kamu

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
