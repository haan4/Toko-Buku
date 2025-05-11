<?php
session_start();
include '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

// Proses jika form disubmit
if (isset($_POST['submit'])) {
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $harga     = intval($_POST['harga']);
    $stok      = intval($_POST['stok']);

    // Upload gambar
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file  = $_FILES['gambar']['tmp_name'];
    $path      = "../img/" . $nama_file;

    if (move_uploaded_file($tmp_file, $path)) {
        $query = "INSERT INTO buku (judul, pengarang, harga, stok, gambar) 
                  VALUES ('$judul', '$pengarang', '$harga', '$stok', '$nama_file')";
        if (mysqli_query($conn, $query)) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Gagal menambahkan buku.";
        }
    } else {
        echo "Gagal upload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Tambah Buku</h2>

    <form action="tambah_buku.php" method="POST" enctype="multipart/form-data">
        <label>Judul:</label><br>
        <input type="text" name="judul" required><br><br>

        <label>Pengarang:</label><br>
        <input type="text" name="pengarang" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" required><br><br>

        <label>Gambar Buku:</label><br>
        <input type="file" name="gambar" accept="image/*" required><br><br>

        <button type="submit" name="submit">Simpan</button>
    </form>
</body>
</html>
