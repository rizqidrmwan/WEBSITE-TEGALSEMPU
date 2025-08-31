<?php
session_start();
include "koneksi.php";

// Pastikan user sudah login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Pastikan ada parameter id
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Ambil nama file dulu biar bisa dihapus dari folder
    $stmt = $conn->prepare("SELECT gambar FROM dokumentasi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if ($data) {
        $file = "upload/" . $data["gambar"];

        // Hapus dari database
        $stmt = $conn->prepare("DELETE FROM dokumentasi WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Hapus file dari folder jika ada
        if (file_exists($file)) {
            unlink($file);
        }
    }

    header("Location: dokumentasi.php");
    exit;
} else {
    // Jika id tidak ada
    header("Location: dokumentasi.php");
    exit;
}
