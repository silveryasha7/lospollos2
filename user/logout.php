<?php
// Mulai session
session_start();

// Hapus semua data dalam session
session_unset();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman login
header("Location: login.php");
exit;
?>
