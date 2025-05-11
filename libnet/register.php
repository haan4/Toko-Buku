<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar - LibNet</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .auth-container {
      max-width: 600px; /* lebih besar dari sebelumnya */
      margin: 80px auto 100px auto; /* ada jarak bawah biar gak tabrakan dengan footer */
      background: #fff;
      padding: 40px;
      border-radius: 14px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      border: 1px solid #ddd;
    }

    .auth-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #4b3621;
      font-size: 1.8rem;
    }

    .form-group {
      margin-bottom: 18px;
      position: relative;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .form-group input {
      width: 100%;
      padding: 12px 14px;
      padding-right: 40px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 38px;
      cursor: pointer;
      color: #666;
      font-size: 1.1rem;
    }

    .btn {
  width: 100%;
  padding: 12px;
  background: linear-gradient(135deg, #d6bfa3, #b89c7a);
  color: #fff;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  font-size: 1rem;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(183, 148, 108, 0.3);
}

.btn:hover {
  background: linear-gradient(135deg, #cdb190, #a1835e);
  transform: scale(1.03);
  box-shadow: 0 6px 15px rgba(145, 111, 78, 0.4);
}

.btn:active {
  background: linear-gradient(135deg, #b69978, #8e6b4b);
  transform: scale(0.98);
  box-shadow: 0 2px 6px rgba(117, 88, 62, 0.4);
}

    .auth-footer-link {
      margin-top: 20px;
      text-align: center;
      font-size: 0.95rem;
    }

    .auth-footer-link a {
      color: #4f684e;
      text-decoration: none;
      font-weight: 500;
    }

    .auth-footer-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<?php include 'header.php'; ?>
<body>
  <div class="auth-container">
    <h2>Daftar Akun Baru</h2>
    <form action="proses/proses_daftar.php" method="POST">
      <div class="form-group">
        <label>Nama Lengkap:</label>
        <input type="text" name="nama" required>
      </div>

      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required>
      </div>

      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" id="registerPassword" required>
        <span class="toggle-password" onclick="togglePassword('registerPassword')">👁️</span>
      </div>

      <button type="submit" class="btn">Daftar Sekarang</button>
    </form>

    <div class="auth-footer-link">
      Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
  </div>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === 'password' ? 'text' : 'password';
    }
  </script>

  <?php include 'footer.php'; ?>
</body>
</html>
