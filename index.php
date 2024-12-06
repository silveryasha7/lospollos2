<?php
// Memulai session dan memeriksa apakah pengguna sudah login dan memiliki role admin
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Jika tidak login atau bukan admin, redirect ke halaman login
    header("Location: login.php");
    exit;
}

// Termasuk header utama
include "mainheader.php";  // Perbaiki path jika diperlukan

// Bagian Home
?>

<html>
<head>
    <title>Dashboard Admin - Los Pollos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Bagian Home -->
    <div id="home" style="padding: 20px; text-align: center;">
        <h1>Selamat Datang, Admin di Los Pollos!</h1>
        <p>Ini adalah dashboard admin restoran kami. Anda dapat mengelola menu makanan, pesanan, dan lainnya di sini.</p>
        <p>Kami berharap Anda menikmati pengalaman mengelola restoran kami!</p>
    </div>

    <!-- Menampilkan Menu Makanan -->
    <div id="menu" style="padding: 20px; text-align: center;">
        <h2>Menu Makanan</h2>
        <?php
        // Perbaiki path untuk file menu makanan
        require_once "menumakanan.php";  // Perbaiki path jika diperlukan
        ?>
    </div>

</body>
</html>

<?php
// Termasuk footer utama
include "mainfooter.php";  // Perbaiki path jika diperlukan
?>
