<?php
session_start();

// contoh user login (nanti bisa ganti sesuai kebutuhan)
$username = "admin";
$password = "12345";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUser = $_POST["username"];
    $inputPass = $_POST["password"];

    if ($inputUser === $username && $inputPass === $password) {
        $_SESSION["login"] = true;
        header("Location: dokumentasi.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Login Admin</h2>
    <?php if(!empty($error)): ?>
      <p class="text-red-500 mb-4"><?= $error; ?></p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-1">Username</label>
        <input type="text" name="username" required class="w-full border p-2 rounded-md">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" required class="w-full border p-2 rounded-md">
      </div>
      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-md">Login</button>
    </form>
  </div>
</body>
</html>
