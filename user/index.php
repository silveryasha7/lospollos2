<?php
// Mulai session
session_start();

// Cek apakah user sudah login, jika belum arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Koneksi ke database (pastikan dbconfig.php ada di tempat yang benar)
include "../dbconfig.php";  // Ganti path sesuai dengan letak file dbconfig.php Anda

// Proses pemesanan jika ada data yang dikirimkan
if (isset($_POST['order'])) {
    $menu_id = $_POST['menu_id'];
    $jumlah = $_POST['jumlah'];
    $username = $_SESSION['username'];

    // Query untuk mendapatkan detail menu berdasarkan ID
    $query = "SELECT * FROM menu WHERE id = '$menu_id'";
    $result = mysqli_query($conn, $query);
    $menu = mysqli_fetch_assoc($result);

    // Hitung total harga
    $total_harga = $menu['harga'] * $jumlah;

    // Query untuk menyimpan pesanan ke database
    $order_query = "INSERT INTO pesanan (username, menu_id, jumlah, total_harga, status) 
                    VALUES ('$username', '$menu_id', '$jumlah', '$total_harga', 'Menunggu')";

    if (mysqli_query($conn, $order_query)) {
        echo "<div class='alert alert-success'>Pesanan Anda telah diterima!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memesan. Coba lagi.</div>";
    }
}

// Query untuk menampilkan semua menu makanan
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);

// Tutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Makanan - Los Pollos</title>
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
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Daftar Menu Makanan -->
    <div class="container mt-5">
        <h2>Menu Makanan</h2>

        <div class="row">
            <?php while ($menu = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card" style="width: 18rem;">
                        <img src="images/food.jpg" class="card-img-top" alt="Food Image"> <!-- Ganti dengan gambar menu -->
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $menu['nama']; ?></h5>
                            <p class="card-text"><?php echo $menu['deskripsi']; ?></p>
                            <p class="card-text">Harga: Rp. <?php echo number_format($menu['harga'], 0, ',', '.'); ?></p>

                            <!-- Form Pemesanan -->
                            <form action="index.php" method="post">
                                <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">
                                <div class="mb-3">
                                    <label for="jumlah_<?php echo $menu['id']; ?>" class="form-label">Jumlah:</label>
                                    <input type="number" class="form-control" id="jumlah_<?php echo $menu['id']; ?>" name="jumlah" min="1" required>
                                </div>
                                <button type="submit" name="order" class="btn btn-primary">Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
