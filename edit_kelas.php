

```php
<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

function e($nilai)
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: kelola_kelas.php');
    exit;
}

// Ambil data kelas
$stmt = mysqli_prepare($koneksi, "SELECT * FROM t_kelas WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header('Location: kelola_kelas.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $tingkat = trim($_POST['tingkat'] ?? '');
    $jurusan = trim($_POST['jurusan'] ?? '');

    if ($nama === '' || $tingkat === '' || $jurusan === '') {
        $error = 'Semua field wajib diisi.';
    } else {
        $update = mysqli_prepare(
            $koneksi,
            "UPDATE t_kelas SET nama = ?, tingkat = ?, jurusan = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param($update, "sssi", $nama, $tingkat, $jurusan, $id);

        if (mysqli_stmt_execute($update)) {
            header('Location: kelola_kelas.php?pesan=edit');
            exit;
        } else {
            $error = 'Data kelas gagal diperbarui.';
        }
    }

    // Tampilkan kembali input yang dikirim
    $data['nama'] = $nama;
    $data['tingkat'] = $tingkat;
    $data['jurusan'] = $jurusan;
}

$namaUser = $_SESSION['name'] ?? 'Pengguna';
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kelas</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #172554;
            color: white;
            padding: 25px 15px;
            overflow-y: auto;
        }

        .sidebar h4 {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
        }

        .sidebar .user-info {
            text-align: center;
            font-size: 13px;
            color: #cbd5e1;
            margin-bottom: 25px;
        }

        .sidebar a {
            display: block;
            color: #e2e8f0;
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 6px;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #263b70;
            color: white;
        }

        .sidebar a.active {
            background: #3157d5;
            color: white;
            font-weight: bold;
        }

        .sidebar a.logout {
            margin-top: 20px;
            background: #b91c1c;
            color: white;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h2 {
            color: #172554;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .page-header p {
            color: #6b7280;
            margin: 0;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.06);
            max-width: 850px;
        }

        .form-card h5 {
            color: #172554;
            font-weight: bold;
            margin-bottom: 22px;
        }

        label {
            color: #172554;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 7px;
            min-height: 42px;
        }

        .form-control:focus {
            border-color: #3157d5;
            box-shadow: 0 0 0 0.15rem rgba(49, 87, 213, 0.15);
        }

        .btn-primary {
            background: #3157d5;
            border-color: #3157d5;
            border-radius: 7px;
            padding: 9px 20px;
        }

        .btn-primary:hover {
            background: #2445b8;
            border-color: #2445b8;
        }

        .btn-secondary {
            border-radius: 7px;
            padding: 9px 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h4>Sistem Pelanggaran</h4>
    <div class="user-info">
        <?= e($namaUser) ?> · <?= e(ucfirst($role)) ?>
    </div>

    <a href="dashboard.php">▦ Dashboard</a>
    <a href="kelola_siswa.php">♙ Kelola Siswa</a>
    <a href="kelola_guru.php">♙ Kelola Guru</a>
    <a href="kelola_kelas.php" class="active">▣ Kelola Kelas</a>
    <a href="kelola_tahun_ajaran.php">▤ Tahun Ajaran</a>
    <a href="penempatan_siswa.php">⇄ Penempatan Siswa</a>
    <a href="kelola_wali_kelas.php">♧ Wali Kelas</a>
    <a href="kelola_kategori_pelanggaran.php">▤ Kategori Pelanggaran</a>
    <a href="menu3.php">⚠ Jenis Pelanggaran</a>
    <a href="catatan.php">☷ Catatan Pelanggaran</a>
    <a href="laporan.php">▧ Laporan</a>

    <?php if ($role === 'admin'): ?>
        <a href="menu4.php">⚙ Pengguna/Admin</a>
    <?php endif; ?>

    <a href="logout.php" class="logout"
       onclick="return confirm('Yakin ingin keluar?')">↪ Logout</a>
</div>

<div class="content">
    <div class="page-header">
        <h2>Edit Data Kelas</h2>
        <p>Perbarui informasi kelas pada sistem.</p>
    </div>

    <div class="form-card">
        <h5>Form Edit Kelas</h5>

        <?php if ($error !== ''): ?>
            <div class