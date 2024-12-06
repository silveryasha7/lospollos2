<?php
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Menghubungkan ke database
include('../db.php');

// Mendapatkan id menu yang akan diedit
$id = $_GET['id'] ?? null;
if ($id) {
    // Mengambil data menu berdasarkan id
    $query = "SELECT * FROM menu WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $menu_item = mysqli_fetch_assoc($result);

    // Jika menu tidak ditemukan, redirect
    if (!$menu_item) {
        header("Location: menu.php");
        exit;
    }

    // Update menu jika form disubmit
    if (isset($_POST['update_menu'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image_url = $_POST['image_url'];

        $query = "UPDATE menu SET name='$name', description='$description', price='$price', image_url='$image_url' WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            header("Location: menu.php");
        } else {
            echo "<p>Gagal memperbarui menu.</p>";
        }
    }
} else {
    header("Location: menu.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1 class="text-center">Edit Menu</h1>

    <!-- Form Edit Menu -->
    <form action="edit.php?id=<?= $menu_item['id']; ?>" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($menu_item['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($menu_item['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= $menu_item['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="image_url" class="form-label">URL Gambar</label>
            <input type="text" class="form-control" id="image_url" name="image_url" value="<?= htmlspecialchars($menu_item['image_url']); ?>">
        </div>
        <button type="submit" name="update_menu" class="btn btn-primary">Update Menu</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
