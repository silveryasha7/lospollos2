<?php
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] == 'admin' && isset($_POST['btnSimpan'])) {
    // Simpan data makanan ke database
}