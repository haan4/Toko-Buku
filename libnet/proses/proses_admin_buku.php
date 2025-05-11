<?php
session_start();
include '../config/koneksi.php';

// Cek login admin
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

// Proses tambah buku
if (isset($_POST['tambah_buku'])) {
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $harga     = intval($_POST['harga']);
    $stok      = intval($_POST['stok']);
    
    // Cek apakah ada gambar yang diupload
    if ($_FILES['gambar']['error'] == 0) {
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
                echo "Gagal menambah buku.";
            }
        } else {
            echo "Gagal upload gambar.";
        }
    } else {
        echo "Pilih gambar untuk buku.";
    }
}

// Proses hapus buku
if (isset($_GET['hapus'])) {
    $id_buku = $_GET['id_buku'];
    
    // Ambil nama gambar untuk dihapus
    $query = "SELECT gambar FROM buku WHERE id_buku = $id_buku";
    $result = mysqli_query($conn, $query);
    $buku = mysqli_fetch_assoc($result);

    // Hapus gambar dari folder
    unlink("../img/" . $buku['gambar']);
    
    // Hapus data buku dari database
    $query = "DELETE FROM buku WHERE id_buku = $id_buku";
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal menghapus buku.";
    }
}
?>
