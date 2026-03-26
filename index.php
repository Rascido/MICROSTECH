<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Ambil data terbaru
$result = mysqli_query($conn, "SELECT * FROM devices WHERE id=1");
$device = mysqli_fetch_assoc($result) ?? ['lampu' => 0, 'buzzer' => 0];

// Handle POST request via AJAX/Form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $type = $_POST['type']; // lampu atau buzzer
    $val = $_POST['current_val'] == 1 ? 0 : 1;
    mysqli_query($conn, "UPDATE devices SET $type=$val WHERE id=1");
    header("Location: index.php"); // Refresh untuk update UI
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Farming Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2ecc71;
            --secondary: #3498db;
            --dark: #2c3e50;
            --danger: #e74c3c;
            --light: #ecf0f1;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: var(--light);
            margin: 0;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .container {
            padding: 40px 5%;
            max-width: 1200px;
            margin: auto;
        }

        .welcome-text {
            margin-bottom: 30px;
            text-align: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 30px;
        }

        .status-pill {
            padding: 5px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .bg-on { background: var(--primary); box-shadow: 0 0 15px var(--primary); }
        .bg-off { background: var(--danger); box-shadow: 0 0 15px var(--danger); }

        .btn-action {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-family: 'Poppins';
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            background: white;
            color: var(--dark);
        }

        .btn-action:hover {
            background: var(--light);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .logout-btn {
            color: #ff7675;
            text-decoration: none;
            font-weight: 600;
            border: 1px solid #ff7675;
            padding: 5px 15px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #ff7675;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <h2 style="margin:0;"><i class="fas fa-leaf"></i> Microstech</h2>
        <div>
            <span style="margin-right:15px"><i class="fas fa-user-circle"></i> <?= $_SESSION['username'] ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-text">
            <h1>Panel Kendali Hama</h1>
            <p>Monitor dan kontrol perangkat pertanian Anda secara real-time.</p>
        </div>

        <div class="grid">
            <div class="card">
                <div class="icon-circle" style="color: #f1c40f;">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Lampu Penerangan</h3>
                <div class="status-pill <?= $device['lampu'] == 1 ? 'bg-on' : 'bg-off' ?>">
                    <?= $device['lampu'] == 1 ? 'ACTIVE' : 'INACTIVE' ?>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="type" value="lampu">
                    <input type="hidden" name="current_val" value="<?= $device['lampu'] ?>">
                    <button type="submit" class="btn-action">
                        <i class="fas fa-power-off"></i> Toggle Lampu
                    </button>
                </form>
            </div>

            <div class="card">
                <div class="icon-circle" style="color: #e67e22;">
                    <i class="fas fa-volume-up"></i>
                </div>
                <h3>Buzzer Pengusir</h3>
                <div class="status-pill <?= $device['buzzer'] == 1 ? 'bg-on' : 'bg-off' ?>">
                    <?= $device['buzzer'] == 1 ? 'ACTIVE' : 'INACTIVE' ?>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="type" value="buzzer">
                    <input type="hidden" name="current_val" value="<?= $device['buzzer'] ?>">
                    <button type="submit" class="btn-action">
                        <i class="fas fa-power-off"></i> Toggle Buzzer
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>