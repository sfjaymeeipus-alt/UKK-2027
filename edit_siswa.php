
<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Cek ID siswa
if (!isset($_GET['id'])) {
    die("ID siswa tidak ditemukan!");
}

$id = (int) $_GET['id'];

// Ambil data siswa
$query = mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE id='$id'");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$siswa = mysqli_fetch_assoc($query);

if (!$siswa) {
    die("Data siswa tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .sidebar {
            background: #172554;
            color: white;
            min-height: 100vh;
            padding: 22px 15px;
        }

        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 30px;
        }

        .sidebar .nav-link {
            color: #e2e8f0;
            padding: 12px 14px;
            margin-bottom: 6px;
            border-radius: 6px;
            transition: 0.2s;
        }

        .sidebar .nav-link:hover {
            background: #263b70;
            color: white;
        }

        .sidebar .nav-link.active {
            background: #3157d5;
            color: white;
        }

        .sidebar .logout {
            color: #fca5a5;
        }

        .content {
            padding: 28px;
        }

        .page-title {
            color: #172554;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .card-main {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        .card-main .card-header {
            background: #172554;
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 18px 22px;
            font-weight: bold;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 10px 12px;
            height: auto;
        }

        .form-control:focus {
            border-color: #3157d5;
            box-shadow: 0 0 0 0.2rem rgba(49, 87, 213, 0.15);
        }

        label {
            color: #172554;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .btn-primary {
            background: #3157d5;
            border-color: #3157d5;
            border-radius: 6px;
        }

        .btn-primary:hover {
            background: #2445b8;
            border-color: #2445b8;
        }

        .btn-secondary {
            border-radius: 6px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .footer {
            color: #64748b;
            font-size: 13px;
        }

        @media (max-width: 767px) {
            .sidebar {
                min-height: auto;
            }

            .content {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 sidebar">
            <h4>Sistem Pelanggaran</h4>

            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        &#8962; Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelola_siswa.php" class="nav-link active">
                        ♟ Data Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelola_guru.php" class="nav-link">
                        ♟ Data Guru
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelola_kelas.php" class="nav-link">
                        ▦ Data Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelola_tahun_ajaran.php" class="nav-link">
                        &#9719; Kelola Tahun Ajaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelola_wali_kelas.php" class="nav-link">
                        &#9817; Kelola Wali Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelola_penempatan_siswa.php" class="nav-link">
                        &#8644; Penempatan Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelola_kategori_pelanggaran.php" class="nav-link">
                        &#9776; Kategori Pelanggaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="tentang_saya.php" class="nav-link">
                        &#8505; About Me
                    </a>
                </li>

                <hr style="border-color: #475569;">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link logout"
                       onclick="return confirm('Yakin ingin logout?')">
                        &#10140; Logout
                    </a>
                </li>
            </ul>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 content">

            <div class="mb-4">
                <h2 class="page-title">Edit Data Siswa</h2>
                <p class="text-muted">
                    Perbarui informasi data siswa dengan benar.
                </p>
            </div>

            <div class="card card-main">
                <div class="card-header">
                    Form Edit Data Siswa
                </div>

                <div class="card-body p-4">

                    <form action="proses_edit_siswa.php" method="POST">

                        <input type="hidden" name="id"
                               value="<?= htmlspecialchars($siswa['id']) ?>">

                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" name="nis"
                                   class="form-control"
                                   value="<?= htmlspecialchars($siswa['nis'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" name="nisn"
                                   class="form-control"
                                   value="<?= htmlspecialchars($siswa['nisn'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama"
                                   class="form-control"
                                   value="<?= htmlspecialchars($siswa['nama'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                    class="form-control" required>
                                <option value="L"
                                    <?= $siswa['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>
                                    Laki-laki
                                </option>

                                <option value="P"
                                    <?= $siswa['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                   class="form-control"
                                   value="<?= htmlspecialchars($siswa['tanggal_lahir'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat"
                                      class="form-control"
                                      rows="3"
                                      required><?= htmlspecialchars($siswa['alamat'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status Aktif</label>
                            <select name="status_aktif"
                                    class="form-control" required>
                                <option value="1"
                                    <?= $siswa['status_aktif'] == 1 ? 'selected' : '' ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= $siswa['status_aktif'] == 0 ? 'selected' : '' ?>>
                                    Tidak Aktif
                                </option>
                            </select>
                        </div>

                        <hr>

                        <button type="submit" name="update"
                                class="btn btn-primary">
                            Simpan Perubahan
                        </button>

                        <a href="kelola_siswa.php"
                           class="btn btn-secondary">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

            <p class="footer text-center mt-4">
                &copy; <?= date('Y') ?> Sistem Informasi Pelanggaran Siswa
            </p>

        </main>

    </div>
</div>

</body>
</html>
