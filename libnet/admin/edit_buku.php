<?php
session_start();
include '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

// Cek apakah parameter id_buku ada di URL
if (!isset($_GET['id_buku']) || empty($_GET['id_buku'])) {
    header("Location: dashboard.php");
    exit;
}

// Ambil data buku berdasarkan ID
$id_buku = $_GET['id_buku'];
$query = "SELECT * FROM buku WHERE id_buku = $id_buku";
$result = mysqli_query($conn, $query);
$buku = mysqli_fetch_assoc($result);

// Cek apakah buku ada di database
if (!$buku) {
    header("Location: dashboard.php");
    exit;
}

// Proses update data buku
if (isset($_POST['submit'])) {
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $harga     = intval($_POST['harga']);
    $stok      = intval($_POST['stok']);

    // Cek apakah ada gambar baru yang diupload
    if ($_FILES['gambar']['error'] == 0) {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_file  = $_FILES['gambar']['tmp_name'];
        $path      = "../img/" . $nama_file;

        if (move_uploaded_file($tmp_file, $path)) {
            // Hapus gambar lama jika ada
            if (file_exists("../img/" . $buku['gambar'])) {
                unlink("../img/" . $buku['gambar']);
            }
            // Update query dengan gambar baru
            $query = "UPDATE buku SET judul='$judul', pengarang='$pengarang', harga='$harga', stok='$stok', gambar='$nama_file' WHERE id_buku = $id_buku";
        } else {
            echo "Gagal upload gambar.";
        }
    } else {
        // Jika tidak ada gambar baru
        $query = "UPDATE buku SET judul='$judul', pengarang='$pengarang', harga='$harga', stok='$stok' WHERE id_buku = $id_buku";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal mengupdate buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Edit Buku</h2>

    <form action="edit_buku.php?id_buku=<?php echo $id_buku; ?>" method="POST" enctype="multipart/form-data">
        <label>Judul:</label><br>
        <input type="text" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required><br><br>

        <label>Pengarang:</label><br>
        <input type="text" name="pengarang" value="<?php echo htmlspecialchars($buku['pengarang']); ?>" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" value="<?php echo htmlspecialchars($buku['harga']); ?>" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" value="<?php echo htmlspecialchars($buku['stok']); ?>" required><br><br>

        <label>Gambar Buku:</label><br>
        <input type="file" name="gambar" accept="image/*"><br><br>
        <img src="../img/<?php echo $buku['gambar']; ?>" alt="Gambar Buku" width="100"><br><br>

        <button type="submit" name="submit">Update</button>
    </form>
</body>
</html>
