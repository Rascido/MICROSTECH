<?php
require 'koneksi.php';
$pesan = "";
$tipe_pesan = ""; // Untuk menentukan warna notifikasi (sukses/gagal)

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Username sudah terdaftar! Silakan gunakan yang lain.";
        $tipe_pesan = "error";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        $pesan = "Registrasi berhasil! Silakan Login.";
        $tipe_pesan = "success";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Smart Farming</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px 30px;
            width: 320px;
            text-align: center;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }

        .glass-card h2 {
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group input {
            width: 85%;
            padding: 12px 15px 12px 40px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: 0.3s;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #2ecc71;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #27ae60;
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
        }

        .link-text {
            margin-top: 20px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .link-text a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .link-text a:hover {
            color: #2980b9;
        }

        .alert {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid #2ecc71;
            color: #2ecc71;
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid #e74c3c;
            color: #ff7675;
        }
    </style>
</head>

<body>
    <div class="glass-card">
        <h2>Buat Akun</h2>

        <?php if ($pesan != ""): ?>
            <div class="alert <?= $tipe_pesan == 'success' ? 'alert-success' : 'alert-error' ?>">
                <?= $pesan ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Masukkan Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <button type="submit" name="register" class="btn-submit">Daftar Sekarang</button>
        </form>
        <div class="link-text">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>
    </div>
</body>

</html>