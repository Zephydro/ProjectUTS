<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #001f3f;
            color: #ffffff;
            padding: 20px;
            position: fixed;
        }
        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            margin: 10px 0;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #0074D9;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .welcome {
            font-size: 1.5rem;
            color: #003366;
        }
        .image-placeholder {
            width: 100%;
            height: 300px;
            background-color: #cccccc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar col-md-3 col-lg-2">
            <h4>Menu</h4>
            <p>Selamat datang, <?= $_SESSION['username']; ?>!</p>
            <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="pendaftaran.php"><i class="fas fa-edit"></i> Form Pendaftaran</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="content w-100">
            <div class="container">
                <h2>Selamat Datang</h2>
                <p class="welcome">Kesehatan Anda Kebahagiaan Kami. Kami Siap Melayani Kesehatan Anda dengan Sepenuh Hati.</p>
                <img src="image/rs.jpg" alt="rs Image" class="img-fluid image-placeholder">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>