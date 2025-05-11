<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ubah jumlah
    if (isset($_POST['update'])) {
        $id_buku = $_POST['id_buku'];
        $jumlah = (int) $_POST['jumlah'];

        if ($jumlah > 0) {
            $_SESSION['keranjang'][$id_buku] = $jumlah;
        } else {
            unset($_SESSION['keranjang'][$id_buku]);
        }

        header("Location: ../keranjang.php");
        exit;
    }

    // Hapus item
    if (isset($_POST['hapus'])) {
        $id_buku = $_POST['id_buku'];
        unset($_SESSION['keranjang'][$id_buku]);
        header("Location: ../keranjang.php");
        exit;
    }
}

echo "Permintaan tidak valid.";
