<?php
$servername = "localhost";  // Nama server
$username = "root";         // Username MySQL
$password = "";             // Password MySQL
$dbname = "lospollos_db";      // Nama database

// Membuat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
