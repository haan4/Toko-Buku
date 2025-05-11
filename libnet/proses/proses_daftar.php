<?php
include '../config/koneksi.php';

$nama     = $_POST['nama'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Cek apakah email sudah terdaftar
$cek = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah terdaftar!');window.location='../register.php';</script>";
} else {
    $query = mysqli_query($conn, "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$password')");
    if ($query) {
        echo "<script>alert('Pendaftaran berhasil!');window.location='../login.php';</script>";
    } else {
        echo "Gagal daftar: " . mysqli_error($conn);
    }
}
?>
