<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
if (isset($_POST['daftar'])) {
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $poli = $_POST['poli'];
    $dokter_id = $_POST['dokter']; // ini sekarang ID dokter
    $tanggal = $_POST['tanggal'];
    $keadaan = $_POST['keadaan'];

    $stmt = $conn->prepare("INSERT INTO pendaftaran (nama_pasien, umur, poli_tujuan, dokter_id, tanggal, keluhan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisis", $nama, $umur, $poli, $dokter_id, $tanggal, $keadaan);
    $stmt->execute();

    $success = "Pendaftaran berhasil!";
}

// Ambil data dokter per poli
$doctors = [];
$poliOptions = ['Umum', 'Gigi', 'Anak', 'Spesialis', 'Kandungan'];
foreach ($poliOptions as $poli) {
    $stmt = $conn->prepare("SELECT * FROM dokters WHERE poli = ?");
    $stmt->bind_param("s", $poli);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctors[$poli] = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Form Pendaftaran Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-dark: #001f3f;
            --primary-light: #3498db;
            --white: #fff;
            --gray-light: #f5f5f5;
        }
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--primary-dark);
            color: var(--white);
            padding: 20px;
        }
        .sidebar a {
            color: var(--white);
            text-decoration: none;
            margin: 10px 0;
            display: block;
            padding: 8px;
            border-radius: 5px;
        }
        .sidebar a.active, .sidebar a:hover {
            background-color: var(--primary-light);
        }
        .content {
            padding: 20px;
        }
        .form-container {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 20px;
        }
        .form-header {
            background-color: var(--primary-dark);
            color: var(--white);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        h2 {
            color: var(--white);
            margin-bottom: 20px;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-dark);
            font-weight: 500;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--primary-light);
            outline: none;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        button.submit-btn {
            background-color: var(--primary-dark);
            color: var(--white);
            border: none;
            padding: 14px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        button.submit-btn:hover {
            background-color: var(--primary-light);
        }
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column flex-md-row">
        <!-- Sidebar -->
        <div class="sidebar col-md-3 col-lg-2">
            <h4>Menu</h4>
            <p>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="pendaftaran.php" class="active"><i class="fas fa-edit"></i> Form Pendaftaran</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <!-- Main Content -->
        <div class="content col-md-9 col-lg-10">
            <div class="container py-4">
                <div class="form-container">
                    <div class="form-header">
                        <h2>Form Pendaftaran Pasien</h2>
                    </div>

                    <?php if (isset($success)) echo "<div class='success-message'>$success</div>"; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label for="nama">Nama Pasien</label>
                            <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="number" id="umur" name="umur" placeholder="Masukkan umur" required>
                        </div>

                        <div class="form-group">
                            <label for="poli">Pilih Poli</label>
                            <select name="poli" id="poli" required onchange="updateDoctors(this.value)">
                                <option value="">Pilih Poli</option>
                                <?php foreach ($poliOptions as $option) { ?>
                                    <option value="<?= htmlspecialchars($option); ?>"><?= htmlspecialchars($option); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dokter">Pilih Dokter</label>
                            <select name="dokter" id="dokter" required>
                                <option value="">Pilih Dokter</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal Kunjungan</label>
                            <input type="date" id="tanggal" name="tanggal" required>
                        </div>

                        <div class="form-group">
                            <label for="keadaan">Keluhan</label>
                            <textarea id="keadaan" name="keadaan" placeholder="Jelaskan keluhan anda secara detail" required></textarea>
                        </div>

                        <button type="submit" name="daftar" class="submit-btn">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const doctors = <?= json_encode($doctors); ?>;

    function updateDoctors(poli) {
        const dokterSelect = document.getElementById('dokter');
        dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';

        if (doctors[poli]) {
            doctors[poli].forEach(dokter => {
                dokterSelect.innerHTML += `<option value="${dokter.nama}">${dokter.nama}</option>`;
            });
        }
    }
</script>

</body>
</html>
