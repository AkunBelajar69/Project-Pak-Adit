<?php
include 'koneksi.php';
include 'icons.php';

// Proses tambah absensi
if (isset($_POST['tambah'])) {
    $siswa_id = $_POST['siswa_id'];
    $guru_id = $_POST['guru_id'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];

    $query = "INSERT INTO absensi (siswa_id, guru_id, tanggal, status, keterangan) 
              VALUES ('$siswa_id', '$guru_id', '$tanggal', '$status', '$keterangan')";
    mysqli_query($conn, $query);
    echo "<script>alert('Absensi berhasil ditambahkan!'); window.location='absensi.php';</script>";
}

// Proses hapus absensi
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM absensi WHERE id='$id'");
    echo "<script>alert('Data absensi dihapus!'); window.location='absensi.php';</script>";
}

// Proses edit absensi
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $siswa_id = $_POST['siswa_id'];
    $guru_id = $_POST['guru_id'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];

    $query = "UPDATE absensi SET 
              siswa_id='$siswa_id', 
              guru_id='$guru_id', 
              tanggal='$tanggal', 
              status='$status', 
              keterangan='$keterangan' 
              WHERE id='$id'";
    mysqli_query($conn, $query);
    echo "<script>alert('Data absensi diupdate!'); window.location='absensi.php';</script>";
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM absensi WHERE id='$id'"));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa</title>
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
            <a href="absensi.php" class="nav-link active">
                <span class="nav-icon"><?= icon('clipboard') ?></span>
                <span class="nav-text">Absensi</span>
            </a>
            <a href="siswa.php" class="nav-link">
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
                <span class="eyebrow">Manajemen Kehadiran</span>
                <h1>
                    <span class="title-icon"><?= icon('clipboard', 20) ?></span>
                    Form Absensi
                </h1>
                <p>Catat kehadiran siswa</p>
            </div>

            <!-- Form Tambah/Edit Absensi -->
            <div class="form-container">
                <div class="form-title">
                    <?= icon($edit_data ? 'pencil' : 'plus', 18) ?>
                    <?= $edit_data ? 'Edit Data Absensi' : 'Tambah Absensi Baru' ?>
                </div>
                <form method="POST">
                    <?php if ($edit_data): ?>
                        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <select name="siswa_id" required>
                            <option value="">Pilih Siswa</option>
                            <?php
                            $siswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama");
                            while ($s = mysqli_fetch_assoc($siswa)) {
                                $selected = ($edit_data && $edit_data['siswa_id'] == $s['id']) ? 'selected' : '';
                                echo "<option value='{$s['id']}' $selected>{$s['nama']} - {$s['kelas']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Guru / Mapel</label>
                        <select name="guru_id" required>
                            <option value="">Pilih Guru</option>
                            <?php
                            $guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama");
                            while ($g = mysqli_fetch_assoc($guru)) {
                                $selected = ($edit_data && $edit_data['guru_id'] == $g['id']) ? 'selected' : '';
                                echo "<option value='{$g['id']}' $selected>{$g['nama']} - {$g['mapel']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" required 
                               value="<?= $edit_data ? $edit_data['tanggal'] : date('Y-m-d') ?>">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required>
                            <option value="Hadir" <?= $edit_data && $edit_data['status'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                            <option value="Sakit" <?= $edit_data && $edit_data['status'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                            <option value="Izin" <?= $edit_data && $edit_data['status'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
                            <option value="Alpha" <?= $edit_data && $edit_data['status'] == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="3"><?= $edit_data ? $edit_data['keterangan'] : '' ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="<?= $edit_data ? 'edit' : 'tambah' ?>" class="btn btn-primary">
                            <?= icon($edit_data ? 'pencil' : 'plus', 15) ?>
                            <?= $edit_data ? 'Update' : 'Tambah' ?> Absensi
                        </button>
                        <?php if ($edit_data): ?>
                            <a href="absensi.php" class="btn btn-back"><?= icon('x', 15) ?> Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Tabel Data Absensi -->
            <div class="table-container">
                <div class="table-title">
                    <span class="icon"><?= icon('note', 16) ?></span>
                    Daftar Absensi
                </div>
                <div class="card">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Guru</th>
                                    <th>Mapel</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ico_edit = icon('pencil', 13);
                                $ico_hapus = icon('trash', 13);
                                $query = "SELECT a.*, s.nama as nama_siswa, s.kelas, g.nama as nama_guru, g.mapel 
                                          FROM absensi a 
                                          JOIN siswa s ON a.siswa_id = s.id 
                                          JOIN guru g ON a.guru_id = g.id 
                                          ORDER BY a.tanggal DESC, a.id DESC";
                                $result = mysqli_query($conn, $query);
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $status_class = strtolower($row['status']);
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td><strong>{$row['nama_siswa']}</strong></td>
                                            <td>{$row['kelas']}</td>
                                            <td>{$row['nama_guru']}</td>
                                            <td>{$row['mapel']}</td>
                                            <td>" . date('d/m/Y', strtotime($row['tanggal'])) . "</td>
                                            <td><span class='tag tag-{$status_class}'>{$row['status']}</span></td>
                                            <td>{$row['keterangan']}</td>
                                            <td>
                                                <a href='absensi.php?edit={$row['id']}' class='btn btn-edit'>{$ico_edit} Edit</a>
                                                <a href='absensi.php?hapus={$row['id']}' class='btn btn-hapus' onclick='return confirm(\"Yakin hapus?\")'>{$ico_hapus} Hapus</a>
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
