<?php
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Arahkan ke login jika bukan admin
    exit;
}

// Menghubungkan ke database
include('../db.php');

// Menangani aksi CRUD

// Create - Menambah menu
if (isset($_POST['add_menu'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    $query = "INSERT INTO menu (name, description, price, image_url) VALUES ('$name', '$description', '$price', '$image_url')";
    if (mysqli_query($conn, $query)) {
        echo "<p>Menu berhasil ditambahkan!</p>";
    } else {
        echo "<p>Gagal menambahkan menu. Coba lagi.</p>";
    }
}

// Update - Mengubah menu
if (isset($_POST['update_menu'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    $query = "UPDATE menu SET name='$name', description='$description', price='$price', image_url='$image_url' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "<p>Menu berhasil diperbarui!</p>";
    } else {
        echo "<p>Gagal memperbarui menu. Coba lagi.</p>";
    }
}

// Delete - Menghapus menu
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $query = "DELETE FROM menu WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "<p>Menu berhasil dihapus!</p>";
    } else {
        echo "<p>Gagal menghapus menu. Coba lagi.</p>";
    }
}

// Menampilkan daftar menu
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);
$menu_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1 class="text-center">Manajemen Menu Restoran</h1>

    <!-- Form untuk Menambah Menu -->
    <h2>Tambah Menu Baru</h2>
    <form action="menu.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="image_url" class="form-label">URL Gambar</label>
            <input type="text" class="form-control" id="image_url" name="image_url">
        </div>
        <button type="submit" name="add_menu" class="btn btn-primary">Tambah Menu</button>
    </form>

    <!-- Daftar Menu -->
    <h2 class="mt-4">Daftar Menu</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menu_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= htmlspecialchars($item['description']); ?></td>
                    <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                    <td><img src="<?= htmlspecialchars($item['image_url']); ?>" alt="Gambar Menu" width="50"></td>
                    <td>
                        <a href="edit.php?id=<?= $item['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="menu.php?delete_id=<?= $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
