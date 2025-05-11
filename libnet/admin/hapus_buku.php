<?php
session_start();
include '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

// Cek apakah ada id_buku yang ingin dihapus
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];

    // Ambil data buku untuk menghapus gambar
    $query = "SELECT * FROM buku WHERE id_buku = $id_buku";
    $result = mysqli_query($conn, $query);
    $buku = mysqli_fetch_assoc($result);

    // Hapus gambar buku jika ada
    if ($buku && file_exists("../img/" . $buku['gambar'])) {
        unlink("../img/" . $buku['gambar']);
    }

    // Hapus data buku dari database
    $query = "DELETE FROM buku WHERE id_buku = $id_buku";
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal menghapus buku.";
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
