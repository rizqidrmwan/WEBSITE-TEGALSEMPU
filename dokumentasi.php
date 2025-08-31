<?php 
session_start();
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Dokumentasi Kegiatan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }
  </script>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">

 <!-- Navbar -->
  <nav class="bg-green-700 p-4 text-white flex justify-between items-center sticky top-0 z-50 shadow-md">
    <a href="index.html" class="flex items-center space-x-2">
      <span class="font-bold text-lg tracking-wide" id="nav-title">PADUKUHAN TEGALSEMPU</span>
    </a>
    <div class="space-x-6 flex items-center flex-wrap font-medium">
      <a href="index.html" class="hover:text-yellow-300 transition" id="nav-home">Beranda</a>
      <a href="Profil.html" class="hover:text-yellow-300 transition" id="nav-profile">Profil</a>
      <a href="Sensus.html" class="hover:text-yellow-300 transition" id="nav-census">Sensus</a>
      <a href="dokumentasi.php" class="hover:text-yellow-300 transition" id="nav-docs">Dokumentasi</a>

      <!-- Tombol + / Dropdown -->
      <?php if (isset($_SESSION["login"])): ?>
        <div class="relative">
          <button id="menuButton" class="bg-green-600 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-green-700 transition">+</button>
          <div id="menuDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg">
            <a href="upload.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" id="menu-add">➕ Tambah</a>
            <a href="dokumentasi.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" id="menu-manage">🗑 Kelola/Hapus</a>
            <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" id="menu-logout">🚪 keluar</a>
          </div>
        </div>
        <script>
          const menuButton = document.getElementById('menuButton');
          const menuDropdown = document.getElementById('menuDropdown');
          menuButton.addEventListener('click', () => menuDropdown.classList.toggle('hidden'));
          document.addEventListener('click', (e) => {
            if (!menuButton.contains(e.target) && !menuDropdown.contains(e.target)) {
              menuDropdown.classList.add('hidden');
            }
          });
        </script>
      <?php else: ?>
        <a href="login.php" class="bg-green-600 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-green-700 transition">+</a>
      <?php endif; ?>

      <!-- Tombol Bahasa & Mode -->
      <button id="langToggle" class="px-3 py-1 bg-yellow-400 text-black rounded-md hover:bg-yellow-500 transition">EN</button>
      <button id="modeToggle" class="px-3 py-1 bg-gray-800 text-white rounded-md hover:bg-gray-600 transition">🌙</button>
    </div>
  </nav>

  <!-- Konten utama -->
  <main class="flex-1 p-6">
    <h1 class="text-2xl font-bold mb-6" id="docs-title">Dokumentasi Kegiatan</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php
      $result = $conn->query("SELECT * FROM dokumentasi ORDER BY tanggal DESC");
      while($row = $result->fetch_assoc()):
      ?>
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
        <img src="upload/<?= $row['gambar']; ?>" alt="<?= $row['judul']; ?>" class="w-full h-48 object-cover">
        <div class="p-4">
          <h2 class="font-semibold text-lg mb-2"><?= $row['judul']; ?></h2>
          <p class="text-gray-600 dark:text-gray-300 text-sm"><?= date("d M Y", strtotime($row['tanggal'])); ?></p>
          <?php if (isset($_SESSION["login"])): ?>
            <a href="hapus.php?id=<?= $row['id']; ?>" 
               onclick="return confirm('Yakin ingin menghapus dokumentasi ini?')" 
               class="inline-block mt-3 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700" id="btn-delete">
               Hapus
            </a>
          <?php endif; ?>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-green-800 dark:bg-green-950 text-white py-10">
    <div class="max-w-6xl mx-auto flex flex-wrap justify-between items-start gap-6 px-6">
      <div class="flex-1 min-w-[250px] text-center md:text-left">
        <a href="https://www.youtube.com/@tegalsemputv" target="_blank">
          <img src="Assets/youtube.png" alt="YouTube" class="w-14 mx-auto md:mx-0 mb-4">
        </a>
        <h3 class="text-xl font-bold" id="footer-title">PADUKUHAN TEGALSEMPU</h3>
        <p class="mt-2 text-sm" id="footer-desc">
          Website Resmi Pemerintah Padukuhan Tegalsempu,<br>
          Desa Caturharjo, Kecamatan Pandak, Kabupaten Bantul
        </p>
      </div>
      <div class="flex-1 min-w-[250px]">
        <h3 class="font-bold text-lg mb-2" id="footer-contact">HUBUNGI KAMI</h3>
        <p class="text-sm leading-relaxed" id="footer-address">
          Jalan Tegalsempu,<br>
          Padukuhan Tegalsempu, Desa Caturharjo, Kecamatan Pandak, Kabupaten Bantul<br>
          Provinsi Daerah Istimewa Yogyakarta, Indonesia, 55761.
        </p>
      </div>
    </div>
    <div class="text-center border-t border-gray-400 mt-6 pt-4 text-sm">
      <p>&copy; 2025 Padukuhan Tegalsempu. All Rights Reserved.</p>
      <p><b>KKN Reguler 145 UAD Unit V.D.2</b></p>
    </div>
  </footer>

  <!-- Script toggle dark mode + bahasa -->
  <script>
    const modeToggle = document.getElementById("modeToggle");
    const htmlEl = document.documentElement;
    if(localStorage.getItem("theme") === "dark"){
      htmlEl.classList.add("dark"); modeToggle.textContent = "☀️";
    } else {
      htmlEl.classList.remove("dark"); modeToggle.textContent = "🌙";
    }
    modeToggle.addEventListener("click", () => {
      htmlEl.classList.toggle("dark");
      if(htmlEl.classList.contains("dark")){
        localStorage.setItem("theme", "dark"); modeToggle.textContent = "☀️";
      } else {
        localStorage.setItem("theme", "light"); modeToggle.textContent = "🌙";
      }
    });

    // === Translations ===
    const translations = {
      id: {
        "nav-home": "Beranda",
        "nav-profile": "Profil",
        "nav-census": "Sensus",
        "nav-docs": "Dokumentasi",
        "footer-title": "PADUKUHAN TEGALSEMPU",
        "menu-add": "➕ Tambah",
        "menu-manage": "🗑 Kelola/Hapus",
        "menu-logout": "🚪 keluar",
        "docs-title": "Dokumentasi Kegiatan",
        "btn-delete": "Hapus",
        "footer-contact": "HUBUNGI KAMI",
        "footer-desc": "Website Resmi Pemerintah Padukuhan Tegalsempu,<br>Desa Caturharjo, Kecamatan Pandak, Kabupaten Bantul",
        "footer-address": "Jalan tegalsempu,<br>Padukuhan Tegalsempu, Desa Caturharjo, Kecamatan Pandak, Kabupaten Bantul<br>Provinsi Daerah Istimewa Yogyakarta, Indonesia, 55761."
      },
      en: {
        "nav-home": "Home",
        "nav-profile": "Profile",
        "nav-census": "Census",
        "nav-docs": "Documentation",
        "footer-title": "TEGALSEMPU HAMLET",
        "menu-add": "➕ Add",
        "menu-manage": "🗑 Manage/Delete",
        "menu-logout": "🚪 Logout",
        "docs-title": "Activity Documentation",
        "btn-delete": "Delete",
        "footer-contact": "CONTACT US",
        "footer-desc": "Official Website of Tegalsempu Hamlet,<br>Caturharjo Village, Pandak District, Bantul Regency",
        "footer-address": "Tegalsempu Street,<br>Tegalsempu Hamlet, Caturharjo Village, Pandak District, Bantul Regency<br>Special Region of Yogyakarta, Indonesia, 55761."
      }
    };

    const langToggle = document.getElementById("langToggle");
    let currentLang = localStorage.getItem("lang") || (navigator.language.startsWith("id") ? "id" : "en");

    function translatePage(lang){
      document.querySelectorAll("[id]").forEach(el=>{
        if(translations[lang][el.id]) el.innerHTML = translations[lang][el.id];
      });
      localStorage.setItem("lang", lang);
      langToggle.textContent = lang === "id" ? "EN" : "ID";
    }
    translatePage(currentLang);

    langToggle.addEventListener("click", ()=>{
      currentLang = currentLang === "id" ? "en" : "id";
      translatePage(currentLang);
    });
  </script>
</body>
</html>
