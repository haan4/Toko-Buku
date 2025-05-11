<?php
session_start();
include '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil data buku
$buku = mysqli_query($conn, "SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - LibNet</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .logout {
            float: right;
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: -30px;
        }
        .logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h2>Dashboard Admin</h2>
    <a href="logout.php" class="logout">🔓 Logout</a>
    <br><br>
    <a href="tambah_buku.php">+ Tambah Buku</a>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($buku)) {
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>{$row['judul']}</td>";
            echo "<td>{$row['pengarang']}</td>";
            echo "<td>Rp" . number_format($row['harga'], 0, ',', '.') . "</td>";
            echo "<td>{$row['stok']}</td>";
            echo "<td><img src='../img/{$row['gambar']}' width='60'></td>";
            echo "<td>
                    <a href='edit_buku.php?id_buku={$row['id_buku']}'>Edit</a> |
                    <a href='hapus_buku.php?id_buku={$row['id_buku']}' onclick=\"return confirm('Yakin hapus buku ini?')\">Hapus</a>
                  </td>";
            echo "</tr>";
            $no++;
        }
        ?>
    </table>
</body>
</html>
