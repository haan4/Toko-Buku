<?php
include 'config/koneksi.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        session_start();
        $_SESSION['reset_id'] = $user['id_user'];
        header("Location: reset_password.php");
        exit;
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - LibNet</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #fdf6f0, #f3e9dd);
            margin: 0;
            padding: 0;
        }

        .auth-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4b3621;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(to right, #6b8f71, #8b6f5e);
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            transform: scale(1.05); /* Zoom sedikit saat hover */
        }


        .error-msg {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .back-link {
            margin-top: 15px;
            display: block;
            text-align: center;
            font-size: 0.9rem;
        }

        .back-link a {
            color: #4f684e;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <h2>Lupa Password</h2>

        <?php if (isset($error)) echo "<p class='error-msg'>$error</p>"; ?>

        <form method="POST">
            <div class="form-group">
                <label>Masukkan Email Anda:</label>
                <input type="email" name="email" required>
            </div>
            <input type="submit" name="submit" value="Cari Akun" class="btn">
        </form>

        <div class="back-link">
            <a href="login.php">← Kembali ke Login</a>
        </div>
    </div>

</body>
</html>
