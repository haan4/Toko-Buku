<?php
session_start();
include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LibNet - Toko Buku Online</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 30px;
      padding: 10px 20px;
      background-color: #f9f5f1;
      border-radius: 8px;
    }

    .top-left {
      font-weight: bold;
      color: #5a3e2b;
      font-size: 16px;
    }

    .top-right a {
      margin-left: 10px;
      text-decoration: none;
      padding: 6px 12px;
      background-color: #7c5c46;
      color: #fff;
      border-radius: 6px;
      font-size: 14px;
    }

    .buku-item .btn {
      display: block;
      width: 100%;
      text-align: center;
      margin-top: 8px;
      background-color: #7c5c46;
      color: #fff;
      padding: 8px 0;
      border-radius: 6px;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="header">
    <h2>Selamat datang di <strong>LibNet</strong> 📚</h2>
  </div>

  <!-- TOP BAR -->
  <?php if (isset($_SESSION['id_user'])): ?>
    <div class="top-bar">
      <div class="top-left">
        👋 Hai, <strong><?php echo $_SESSION['nama']; ?></strong>
      </div>
      <div class="top-right">
        <a href="keranjang.php">🛒 Keranjang</a>
        <a href="logout.php">🔓 Logout</a>
        <?php if ($_SESSION['role'] == 'admin'): ?>
          <a href="admin/dashboard.php">⚙️ Dashboard Admin</a>
        <?php endif; ?>
      </div>
    </div>
  <?php else: ?>
    <div class="top-bar">
      <div class="top-left">
        👋 Hai, pengunjung!
      </div>
      <div class="top-right">
        <a href="login.php">🔐 Login</a>
        <a href="register.php">📝 Daftar</a>
      </div>
    </div>
  <?php endif; ?>

  <!-- DAFTAR BUKU -->
  <h3>📖 Daftar Buku</h3>
  <div class="buku-list">
    <?php
    $query = mysqli_query($conn, "SELECT * FROM buku");
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<div class='buku-item'>";
        echo "<img src='img/" . $row['gambar'] . "' alt='" . $row['judul'] . "'>";
        echo "<h4>" . $row['judul'] . "</h4>";
        echo "<p>Pengarang: " . $row['pengarang'] . "</p>";
        echo "<p>Harga: Rp" . number_format($row['harga'], 0, ',', '.') . "</p>";
        echo "<a href='keranjang.php?id_buku=" . $row['id_buku'] . "' class='btn'>Tambah ke Keranjang</a>";
        echo "</div>";
    }
    ?>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <p>&copy; <?php echo date('Y'); ?> LibNet - Toko Buku Online</p>
  </div>

</body>
</html>
