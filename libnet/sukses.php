<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Berhasil - LibNet</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="sukses-container" style="background-color: #fff; padding: 40px; border-radius: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); max-width: 600px; margin: 80px auto; border: 1px solid #e0dcd5; text-align: center;">
    <div style="font-size: 50px; color: #6aaf7c; margin-bottom: 10px;">✔️</div>
    <h1>Checkout Berhasil!</h1>
    <p>Terima kasih telah berbelanja di <strong>LibNet</strong>.</p>
    <p>Transaksimu sudah tercatat dan sedang kami proses.</p>
    <a href="index.php" class="btn" style="margin-top: 30px; display: inline-block;">← Kembali ke Beranda</a>
</div>

<div class="footer">
    &copy; <?= date("Y") ?> LibNet - Sistem Informasi Perpustakaan
</div>

</body>
</html>
