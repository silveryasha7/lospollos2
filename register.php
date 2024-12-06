<?php
// register.php
include "dbconfig.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'user'; // default role is user

    if ($password == $confirm_password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (username, password, role) VALUES ('$username', '$password_hash', '$role')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Register berhasil! Silakan login.";
        } else {
            echo "Register gagal. Silakan coba lagi.";
        }
    } else {
        echo "Password tidak sama. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Link ke file CSS -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #c8c8c8; /* Ganti dengan warna latar belakang yang diinginkan */
            position: relative; /* Tambahkan ini untuk posisi relatif */
        }
        .register-container {
            background: rgba(0, 77, 77, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 12px 15px rgba(0, 0, 0, 0.24);
            color: white;
            text-align: center; /* Menempatkan teks di tengah */
        }
        h1 {
            margin-bottom: 20px; /* Jarak antara judul dan form */
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
        }
        input[type="submit"] {
            background-color: #1161ee;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0e4da4;
        }
        .back-link {
            position: absolute; /* Mengatur posisi absolut */
            top: 20px; /* Jarak dari atas */
            right: 20px; /* Jarak dari kanan */
            color: black; /* Warna teks */
            text-decoration: none; /* Menghilangkan garis bawah */
        }
    </style>
</head>
<body>

<a href="index.php" class="back-link">Kembali</a> <!-- Tautan Kembali -->

<div class="register-container">
    <h1>Register</h1> <!-- Judul Register -->
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <input type="submit" name="register" value="Register">
    </form>

    <!-- Link ke halaman login -->
    <p>Sudah punya akun? <a href="login.php" style="color: #fff;">Login di sini</a></p>
</div>

</body>
</html>