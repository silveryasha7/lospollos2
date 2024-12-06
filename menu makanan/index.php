<?php
// Koneksi ke database
include "../dbconfig.php"; 

// Query untuk mendapatkan data menu makanan
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);

// Menangani error jika query gagal
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<div class="container">
    <h2>Daftar Menu Makanan</h2>

    <!-- Tabel Daftar Menu -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Makanan</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['deskripsi']; ?></td>
                    <td><?php echo "Rp " . number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="editmenu.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="deletemenu.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Tombol untuk menambahkan menu baru -->
    <a href="addmenu.php" class="btn btn-primary">Tambah Menu Baru</a>
</div>

<?php
// Menutup koneksi ke database
mysqli_close($conn);
?>
