<?php
include 'koneksi.php';
include 'icons.php';

$filter_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$filter_siswa = isset($_GET['siswa']) ? $_GET['siswa'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$where = "1=1";
if ($filter_tanggal) $where .= " AND a.tanggal='$filter_tanggal'";
if ($filter_siswa) $where .= " AND a.siswa_id='$filter_siswa'";
if ($filter_status) $where .= " AND a.status='$filter_status'";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
            <a href="siswa.php" class="nav-link">
                <span class="nav-icon"><?= icon('users') ?></span>
                <span class="nav-text">Siswa</span>
            </a>
            <a href="guru.php" class="nav-link">
                <span class="nav-icon"><?= icon('cap') ?></span>
                <span class="nav-text">Guru</span>
            </a>
            <a href="laporan.php" class="nav-link active">
                <span class="nav-icon"><?= icon('bar-chart') ?></span>
                <span class="nav-text">Laporan</span>
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="container">
            <div class="page-title">
                <span class="eyebrow">Rekap &amp; Analisis</span>
                <h1>
                    <span class="title-icon"><?= icon('bar-chart', 20) ?></span>
                    Laporan Absensi
                </h1>
                <p>Filter dan lihat data absensi</p>
            </div>

            <div class="filter-container">
                <div class="filter-title">
                    <?= icon('filter', 16) ?>
                    Filter Data
                </div>
                <form method="GET">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="<?= $filter_tanggal ?>">
                    </div>
                    <div class="form-group">
                        <label>Siswa</label>
                        <select name="siswa">
                            <option value="">Semua</option>
                            <?php
                            $siswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama");
                            while ($s = mysqli_fetch_assoc($siswa)) {
                                $selected = ($filter_siswa == $s['id']) ? 'selected' : '';
                                echo "<option value='{$s['id']}' $selected>{$s['nama']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="">Semua</option>
                            <option value="Hadir" <?= $filter_status == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                            <option value="Sakit" <?= $filter_status == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                            <option value="Izin" <?= $filter_status == 'Izin' ? 'selected' : '' ?>>Izin</option>
                            <option value="Alpha" <?= $filter_status == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary"><?= icon('filter', 15) ?> Filter</button>
                        <a href="laporan.php" class="btn btn-back"><?= icon('refresh', 15) ?> Reset</a>
                    </div>
                </form>
            </div>

            <div class="table-container">
                <div class="table-title">
                    <span class="icon"><?= icon('note', 16) ?></span>
                    Data Absensi
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT a.*, s.nama as nama_siswa, s.kelas, g.nama as nama_guru, g.mapel 
                                          FROM absensi a 
                                          JOIN siswa s ON a.siswa_id = s.id 
                                          JOIN guru g ON a.guru_id = g.id 
                                          WHERE $where 
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
