<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['reset_id'])) {
    header("Location: forgot_password.php");
    exit;
}

if (isset($_POST['submit'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id_user = $_SESSION['reset_id'];

    $query = mysqli_query($conn, "UPDATE user SET password = '$password' WHERE id_user = $id_user");

    if ($query) {
        unset($_SESSION['reset_id']);
        header("Location: login.php?reset=success");
        exit;
    } else {
        $error = "Gagal mengubah password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - LibNet</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* CSS untuk Tombol */
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

        /* Form Container */
        .auth-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            opacity: 0;
            animation: fadeIn 0.8s ease-in forwards;
        }

        /* Animasi Fade-in */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Styling Input Form */
        .auth-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        /* Styling Header */
        .auth-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4b3621;
        }

        /* Pesan error */
        .error-msg {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Reset Password</h2>

        <?php if (isset($error)) echo "<p class='error-msg'>$error</p>"; ?>

        <form method="POST">
            <div class="form-group">
                <label>Password Baru:</label><br>
                <input type="password" name="password" required><br><br>
            </div>
            <input type="submit" name="submit" value="Ubah Password" class="btn">
        </form>
    </div>
</body>
</html>
