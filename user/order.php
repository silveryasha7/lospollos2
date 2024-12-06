<?php
// Mulai session
session_start();

// Cek apakah user sudah login, jika belum arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Koneksi ke database
include "dbconfig.php";

// Cek apakah ada menu_id yang dikirimkan dari halaman index.php
if (isset($_GET['menu_id'])) {
    $menu_id = $_GET['menu_id'];

    // Query untuk mengambil detail menu berdasarkan menu_id
    $query = "SELECT * FROM menu WHERE id = $menu_id";
    $result = mysqli_query($conn, $query);
    $menu = mysqli_fetch_assoc($result);

    // Jika menu tidak ditemukan
    if (!$menu) {
        echo "Menu tidak ditemukan.";
        exit;
    }
} else {
    echo "Menu tidak tersedia.";
    exit;
}

// Proses pemesanan
if (isset($_POST['order'])) {
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session
    $quantity = $_POST['quantity'];
    $total_price = $menu['harga'] * $quantity;

    // Query untuk memasukkan pesanan ke tabel orders
    $order_query = "INSERT INTO orders (user_id, menu_id, quantity, total_price) 
                    VALUES ('$user_id', '$menu_id', '$quantity', '$total_price')";

    if (mysqli_query($conn, $order_query)) {
        echo "Pemesanan berhasil! Total harga: Rp. " . number_format($total_price, 0, ',', '.');
    } else {
        echo "Gagal memesan. Coba lagi.";
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Makanan - Los Pollos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Los Pollos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Form Pemesanan Makanan -->
    <div class="container mt-5">
        <h2>Pesan Makanan</h2>

        <div class="card" style="width: 18rem;">
            <img src="images/food.jpg" class="card-img-top" alt="Food Image"> <!-- Ganti dengan gambar menu -->
            <div class="card-body">
                <h5 class="card-title"><?php echo $menu['nama']; ?></h5>
                <p class="card-text"><?php echo $menu['deskripsi']; ?></p>
                <p class="card-text">Harga: Rp. <?php echo number_format($menu['harga'], 0, ',', '.'); ?></p>

                <form method="POST" action="order.php?menu_id=<?php echo $menu['id']; ?>">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                    </div>
                    <button type="submit" name="order" class="btn btn-primary">Pesan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
