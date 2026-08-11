<?php
session_start();
include 'koneksi.php'; // file koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah username dan password cocok
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Login berhasil
       $_SESSION['role'] = $user['role'];
       $_SESSION['username'] = $user['username'];

       if ($user['role'] == 'admin') {
           header("Location: admin_dashboard.php");
       } else {
        header("Location: user_dashboard.php");
       }
    } else {
        // Login gagal
        echo "Login gagal!";
    }

}
?>