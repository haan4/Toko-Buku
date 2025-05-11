<?php
session_start();
include '../config/koneksi.php';

$email    = $_POST['email'];
$password = $_POST['password'];

// Cari user berdasarkan email
$query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    // Verifikasi password
    if (password_verify($password, $data['password'])) {
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama']    = $data['nama'];
        $_SESSION['role']    = $data['role'];

        // Arahkan sesuai role
        if ($data['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../index.php");
        }
    } else {
        echo "<script>alert('Password salah!');window.location='../login.php';</script>";
    }
} else {
    echo "<script>alert('Email tidak ditemukan!');window.location='../login.php';</script>";
}
?>
