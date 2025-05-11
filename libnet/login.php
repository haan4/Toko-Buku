<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' AND role = '$role'");
    $data = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        header("Location: " . ($role == 'admin' ? "admin/dashboard.php" : "index.php"));
        exit;
    } else {
        $error = "Email atau password salah atau role tidak sesuai!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - LibNet</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #f8f5f2, #f0f0e8);
      animation: fadeInBody 1s ease-out;
    }

    @keyframes fadeInBody {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .auth-container {
      max-width: 420px;
      margin: 80px auto;
      background: linear-gradient(to bottom right, #fffdfb, #f4f3f0);
      padding: 35px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      border: 1px solid #e1ded9;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInCard 0.8s ease forwards;
    }

    @keyframes fadeInCard {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .auth-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #4b3621;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 15px;
      position: relative;
    }

    .form-group label {
      display: block;
      font-weight: 500;
      margin-bottom: 5px;
      color: #3d3d3d;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background: #fdfcfb;
      transition: border 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
      border-color: #6b8f71;
      outline: none;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 37px;
      cursor: pointer;
      color: #777;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: linear-gradient(to right, #6b8f71, #8b6f5e);
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .btn:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.12);
      transform: translateY(-1px);
    }

    .auth-footer {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
      font-size: 0.9rem;
    }

    .auth-footer a {
      color: #4f684e;
      text-decoration: none;
      transition: color 0.3s;
    }

    .auth-footer a:hover {
      color: #6b8f71;
      text-decoration: underline;
    }

    .error-msg {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }

    .success-msg {
      color: green;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <h2>Login ke LibNet</h2>

    <?php if (isset($_GET['reset']) && $_GET['reset'] == 'success'): ?>
      <p class="success-msg">Password berhasil direset. Silakan login kembali.</p>
    <?php endif; ?>

    <?php if (isset($error)) echo "<p class='error-msg'>$error</p>"; ?>

    <form method="POST">
      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required>
      </div>

      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" id="loginPassword" required>
        <span class="toggle-password" onclick="togglePassword('loginPassword')">👁️</span>
      </div>

      <div class="form-group">
        <label>Login sebagai:</label>
        <select name="role" required>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <input type="submit" name="submit" value="Login" class="btn">
    </form>

    <div class="auth-footer">
      <a href="forgot_password.php">Lupa Password?</a>
      <a href="register.php">Daftar Akun</a>
    </div>
  </div>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>
