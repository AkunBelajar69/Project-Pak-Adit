<?php
include 'koneksi.php';
include 'icons.php';

// Proses tambah siswa
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    mysqli_query($conn, "INSERT INTO siswa (nama, kelas) VALUES ('$nama', '$kelas')");
    echo "<script>alert('Siswa berhasil ditambahkan!'); window.location='siswa.php';</script>";
}

// Proses hapus siswa
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM siswa WHERE id='$id'");
    echo "<script>alert('Siswa dihapus!'); window.location='siswa.php';</script>";
}

// Proses edit siswa
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    mysqli_query($conn, "UPDATE siswa SET nama='$nama', kelas='$kelas' WHERE id='$id'");
    echo "<script>alert('Data siswa diupdate!'); window.location='siswa.php';</script>";
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'"));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <span class="logo-mark"><?= icon('stamp', 20) ?></span>
            <span class="logo-text">Catatan<br>Absensi</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-link">
                <span class="nav-icon"><?= icon('home') ?></span>
                <span class="nav-text">Beranda</span>
            </a>
            <a href="absensi.php" class="nav-link">
                <span class="nav-icon"><?= icon('clipboard') ?></span>
                <span class="nav-text">Absensi</span>
            </a>
            <a href="siswa.php" class="nav-link active">
                <span class="nav-icon"><?= icon('users') ?></span>
                <span class="nav-text">Siswa</span>
            </a>
            <a href="guru.php" class="nav-link">
                <span class="nav-icon"><?= icon('cap') ?></span>
                <span class="nav-text">Guru</span>
            </a>
            <a href="laporan.php" class="nav-link">
                <span class="nav-icon"><?= icon('bar-chart') ?></span>
                <span class="nav-text">Laporan</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Page Title -->
            <div class="page-title">
                <span class="eyebrow">Data Peserta Didik</span>
                <h1>
                    <span class="title-icon"><?= icon('users', 20) ?></span>
                    Data Siswa
                </h1>
                <p>Kelola data siswa</p>
            </div>

            <!-- Form -->
            <div class="form-container">
                <div class="form-title">
                    <?= icon($edit_data ? 'pencil' : 'plus', 18) ?>
                    <?= $edit_data ? 'Edit Data Siswa' : 'Tambah Siswa Baru' ?>
                </div>
                <form method="POST">
                    <?php if ($edit_data): ?>
                        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" name="nama" required value="<?= $edit_data ? $edit_data['nama'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" required value="<?= $edit_data ? $edit_data['kelas'] : '' ?>">
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="<?= $edit_data ? 'edit' : 'tambah' ?>" class="btn btn-primary">
                            <?= icon($edit_data ? 'pencil' : 'plus', 15) ?>
                            <?= $edit_data ? 'Update' : 'Tambah' ?> Siswa
                        </button>
                        <?php if ($edit_data): ?>
                            <a href="siswa.php" class="btn btn-back"><?= icon('x', 15) ?> Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-title">
                    <span class="icon"><?= icon('users', 16) ?></span>
                    Daftar Siswa
                </div>
                <div class="card">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ico_edit = icon('pencil', 13);
                                $ico_hapus = icon('trash', 13);
                                $result = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama");
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td><strong>{$row['nama']}</strong></td>
                                            <td>{$row['kelas']}</td>
                                            <td>
                                                <a href='siswa.php?edit={$row['id']}' class='btn btn-edit'>{$ico_edit} Edit</a>
                                                <a href='siswa.php?hapus={$row['id']}' class='btn btn-hapus' onclick='return confirm(\"Yakin hapus?\")'>{$ico_hapus} Hapus</a>
                                            </td>
                                          </tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>