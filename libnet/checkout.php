<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $id_user = $_SESSION['id_user'];
    $total = 0;
    $tanggal = date('Y-m-d H:i:s');

    foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
        $query = mysqli_query($conn, "SELECT harga FROM buku WHERE id_buku = $id_buku");
        $buku = mysqli_fetch_assoc($query);
        $total += $buku['harga'] * $jumlah;
    }

    $query_transaksi = "INSERT INTO transaksi (id_user, total, tanggal) VALUES ('$id_user', '$total', '$tanggal')";
    if (mysqli_query($conn, $query_transaksi)) {
        $id_transaksi = mysqli_insert_id($conn);

        foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
            $query = mysqli_query($conn, "SELECT harga FROM buku WHERE id_buku = $id_buku");
            $buku = mysqli_fetch_assoc($query);
            $subtotal = $buku['harga'] * $jumlah;

            $query_detail = "INSERT INTO detail_transaksi (id_transaksi, id_buku, jumlah, subtotal) 
                             VALUES ('$id_transaksi', '$id_buku', '$jumlah', '$subtotal')";
            mysqli_query($conn, $query_detail);

            mysqli_query($conn, "UPDATE buku SET stok = stok - $jumlah WHERE id_buku = $id_buku");
        }

        unset($_SESSION['keranjang']);
        header("Location: sukses.php");
        exit;
    } else {
        echo "Terjadi kesalahan saat menyimpan transaksi: " . mysqli_error($conn);
    }
}
?>

<!-- TAMBAHAN: TAMPILAN FORM -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - LibNet</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="checkout-container">
    <h2>Konfirmasi Checkout</h2>
    <p>Apakah kamu yakin ingin menyelesaikan pembelian?</p>
    
    <form method="post">
      <button type="submit" name="submit">Ya, Checkout Sekarang</button>
      <a href="keranjang.php">Kembali ke Keranjang</a>
    </form>
  </div>
</body>

</html>
