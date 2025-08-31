<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST["judul"];
    $tanggal = $_POST["tanggal"];
    
    $gambar = $_FILES["gambar"]["name"];
    $tmp_name = $_FILES["gambar"]["tmp_name"];
    $folder = "upload/" . $gambar;

    if (move_uploaded_file($tmp_name, $folder)) {
        $stmt = $conn->prepare("INSERT INTO dokumentasi (judul, tanggal, gambar) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $judul, $tanggal, $gambar);
        $stmt->execute();
        $stmt->close();
        header("Location: Dokumentasi.php");
        exit;
    } else {
        $error = "Gagal upload gambar!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Upload Dokumentasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-xl font-semibold mb-4 text-center">Upload Dokumentasi Baru</h2>
    <?php if(!empty($error)): ?>
      <p class="text-red-500 mb-4"><?= $error; ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Pilih Gambar:</label>
        <input type="file" name="gambar" required class="w-full border p-2 rounded-md">
      </div>
      <div>
        <label class="block text-sm font-medium">Judul:</label>
        <input type="text" name="judul" required class="w-full border p-2 rounded-md">
      </div>
      <div>
        <label class="block text-sm font-medium">Tanggal:</label>
        <input type="date" name="tanggal" required class="w-full border p-2 rounded-md">
      </div>
      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-md">Upload</button>
    </form>
  </div>
</body>
</html>