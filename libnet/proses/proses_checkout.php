<?php
session_start();
include '../config/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Harap login terlebih dahulu!'); window.location='../login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$tanggal = date('Y-m-d H:i:s');
$total = 0;

// Hitung total belanja
foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
    $query = mysqli_query($conn, "SELECT harga FROM buku WHERE id_buku = '$id_buku'");
    $data = mysqli_fetch_assoc($query);
    $subtotal = $data['harga'] * $jumlah;
    $total += $subtotal;
}

// Simpan ke tabel transaksi
$query_transaksi = "INSERT INTO transaksi (id_user, total, tanggal) VALUES ('$user_id', '$total', '$tanggal')";
mysqli_query($conn, $query_transaksi);
$id_transaksi = mysqli_insert_id($conn);

// Simpan ke tabel detail_transaksi
foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
    $query = mysqli_query($conn, "SELECT harga FROM buku WHERE id_buku = '$id_buku'");
    $data = mysqli_fetch_assoc($query);
    $subtotal = $data['harga'] * $jumlah;

    $query_detail = "INSERT INTO detail_transaksi (id_transaksi, id_buku, jumlah, subtotal) 
                     VALUES ('$id_transaksi', '$id_buku', '$jumlah', '$subtotal')";
    mysqli_query($conn, $query_detail);

    // Kurangi stok buku
    mysqli_query($conn, "UPDATE buku SET stok = stok - $jumlah WHERE id_buku = '$id_buku'");
}

// Hapus isi keranjang
unset($_SESSION['keranjang']);

echo "<script>alert('Checkout berhasil!'); window.location='../index.php';</script>";
?>
