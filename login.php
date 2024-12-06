<?php
// login.php
session_start();
include "dbconfig.php";

// Cek apakah form login disubmit
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Sanitasi input
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username
    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Memeriksa password menggunakan password_verify
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            // Redirect ke halaman yang sesuai berdasarkan role
            if ($row['role'] == 'admin') {
                header("Location: admin/index.php"); // Admin ke dashboard admin
            } else {
                header("Location: user/index.php");  // User ke dashboard user
            }
            exit;
        } else {
            $_SESSION['login_error'] = "Password salah.";
        }
    } else {
        $_SESSION['login_error'] = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Link ke file CSS -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #c8c8c8;
            position: relative;
        }
        .login-container {
            background: rgba(0, 77, 77, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 12px 15px rgba(0, 0, 0, 0.24);
            color: white;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
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
            position: absolute;
            top: 20px;
            right: 20px;
            color: black;
            text-decoration: none;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<a href="index.php" class="back-link">Kembali</a>

<div class="login-container">
    <h1>Login</h1>
    
    <!-- Menampilkan pesan error jika ada -->
    <?php
    if (isset($_SESSION['login_error'])) {
        echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
        unset($_SESSION['login_error']);
    }
    ?>

    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <input type="submit" name="login" value="Login">
    </form>

    <p>Belum punya akun? <a href="register.php" style="color: #fff;">Daftar di sini</a></p>
</div>

</body>
</html>
