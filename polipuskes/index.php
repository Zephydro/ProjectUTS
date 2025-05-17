<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #001f3f, #0074D9, #7FDBFF);
            color: #ffffff;
        }
        .container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }
        .image-section {
            background: linear-gradient(to bottom, #001f3f, #0074D9);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }
        .form-section {
            background: #ffffff;
            padding: 40px;
            color: #003366;
            flex: 1;
        }
        .form-section h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-section button {
            width: 100%;
            padding: 10px;
            background: #0059b3;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="image-section">
            <img src="image/loginpage.png" alt="Login Image">
        </div>
        <div class="form-section">
            <h2>Login Pasien</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"> <?= $error; ?> </div>
            <?php endif; ?>
            <form method="POST" action="index.php">
                <label>Username:</label>
                <input type="text" name="username" class="form-control mb-2" required>
                <label>Password:</label>
                <input type="password" name="password" class="form-control mb-2" required>
                <button type="submit" name="login" class="btn btn-primary">Masuk</button>
            </form>
            <p class="mt-2">Belum terdaftar? <a href="register.php" style="text-decoration: none;">Daftar Pasien</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
