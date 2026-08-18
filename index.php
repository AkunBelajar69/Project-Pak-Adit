<?php
include 'koneksi.php';
include 'icons.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Absensi</title>
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
            <a href="index.php" class="nav-link active">
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
                <span class="eyebrow">Ringkasan Hari Ini</span>
                <h1>
                    <span class="title-icon"><?= icon('home', 20) ?></span>
                    Dashboard
                </h1>
                <p>Catatan kehadiran siswa</p>
            </div>

            <!-- Stats -->
            <div class="stats">
                <?php
                $total_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa"))['total'];
                $today = date('Y-m-d');
                $hadir_hari_ini = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi WHERE tanggal='$today' AND status='Hadir'"))['total'];
                $total_absensi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi"))['total'];
                ?>
                <div class="stat-card">
                    <span class="stat-icon"><?= icon('users') ?></span>
                    <div class="stat-number"><?= $total_siswa ?></div>
                    <div class="stat-label">Total Siswa</div>
                </div>
                <div class="stat-card">
                    <span class="stat-icon"><?= icon('clipboard') ?></span>
                    <div class="stat-number"><?= $hadir_hari_ini ?></div>
                    <div class="stat-label">Hadir Hari Ini</div>
                </div>
                <div class="stat-card">
                    <span class="stat-icon"><?= icon('note') ?></span>
                    <div class="stat-number"><?= $total_absensi ?></div>
                    <div class="stat-label">Total Absensi</div>
                </div>
            </div>

            <!-- Table -->
            <div class="card">
                <div class="card-head">
                    <h2>
                        <span class="card-icon"><?= icon('note', 16) ?></span>
                        Absensi Terbaru
                    </h2>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Siswa</th>
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
                                      ORDER BY a.tanggal DESC, a.id DESC 
                                      LIMIT 15";
                            $result = mysqli_query($conn, $query);
                            $no = 1;

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $status_class = strtolower($row['status']);
                                    $keterangan = $row['keterangan'] ?: '-';
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td><strong>{$row['nama_siswa']}</strong></td>
                                            <td>{$row['kelas']}</td>
                                            <td>{$row['nama_guru']}</td>
                                            <td>{$row['mapel']}</td>
                                            <td>" . date('d/m/Y', strtotime($row['tanggal'])) . "</td>
                                            <td><span class='tag tag-{$status_class}'>{$row['status']}</span></td>
                                            <td>{$keterangan}</td>
                                          </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='8' class='empty'>Belum ada data absensi</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
