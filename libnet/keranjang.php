<?php
session_start();
include 'config/koneksi.php';

// Cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Tambah buku ke keranjang via GET
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];
    if (isset($_SESSION['keranjang'][$id_buku])) {
        $_SESSION['keranjang'][$id_buku]++;
    } else {
        $_SESSION['keranjang'][$id_buku] = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja - LibNet</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<?php include 'header.php'; ?>
<body>
  <div style="max-width: 800px; margin: 0 auto;">
    <a href="index.php" class="btn" style="margin-bottom: 20px; display: inline-block;">⬅️ Kembali Belanja</a>

    <h2>Keranjang Belanja</h2>

    <?php if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0): ?>
      <table>
        <tr>
          <th>Judul Buku</th>
          <th>Penulis</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
          <th>Aksi</th>
        </tr>

        <?php
        $total = 0;
        foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
            $query = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = $id_buku");
            $buku = mysqli_fetch_assoc($query);
            $subtotal = $buku['harga'] * $jumlah;
            $total += $subtotal;
        ?>
            <tr>
              <td><?= $buku['judul'] ?></td>
              <td><?= $buku['pengarang'] ?></td>
              <td>Rp<?= number_format($buku['harga'], 0, ',', '.') ?></td>
              <td>
                <form action="proses/proses_keranjang.php" method="POST" style="display: inline-flex; gap: 4px;">
                  <input type="hidden" name="id_buku" value="<?= $id_buku ?>">
                  <input type="number" name="jumlah" value="<?= $jumlah ?>" min="1" style="width: 50px;">
                  <button type="submit" name="update">Ubah</button>
                </form>
              </td>
              <td>Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
              <td>
                <form action="proses/proses_keranjang.php" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                  <input type="hidden" name="id_buku" value="<?= $id_buku ?>">
                  <button type="submit" name="hapus">Hapus</button>
                </form>
              </td>
            </tr>
        <?php } ?>
      </table>

      <h3>Total Belanja: Rp<?= number_format($total, 0, ',', '.') ?></h3>
      <a href="checkout.php" class="btn" style="margin-top: 15px;">Checkout</a>
    <?php else: ?>
      <p>Keranjang Anda kosong.</p>
    <?php endif; ?>
  </div>
  <?php include 'footer.php'; ?>
</body>
</html>
