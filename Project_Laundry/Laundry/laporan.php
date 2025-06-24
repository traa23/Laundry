<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/Transaksi.php';

$user = new User();
$user->cekRole();

if(!$user->isOwner()) {
    header("Location: dashboard.php");
    exit();
}

$transaksi = new Transaksi();

$transaksis = $transaksi->getAll();

$total_masuk = 0;
$total_keluar = 0;

// Asumsi: total_harga transaksi dengan status selesai (1) adalah pemasukan
foreach($transaksis as $t) {
    if($t['status'] == 1) {
        $total_masuk += $t['total_harga'];
    }
}

// Untuk pengeluaran, jika ada data pengeluaran lain bisa ditambahkan, tapi saat ini hanya transaksi masuk yang dihitung.

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - Fresh Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
            <i class="fas fa-tshirt me-2"></i>Fresh Laundry
        </a>
        <div class="d-flex">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm">
                <i class="fas fa-home me-1"></i>Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4 fade-in">
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title text-primary">
                <i class="fas fa-chart-line me-2"></i>Laporan Keuangan
            </h2>
            <p class="card-text text-muted">Laporan dan analisis keuangan Fresh Laundry</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">
                                <i class="fas fa-arrow-up me-2"></i>Total Pemasukan
                            </h5>
                            <h3 class="mb-0">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h3>
                        </div>
                        <div>
                            <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">
                                <i class="fas fa-arrow-down me-2"></i>Total Pengeluaran
                            </h5>
                            <h3 class="mb-0">Rp <?= number_format($total_keluar, 0, ',', '.') ?></h3>
                        </div>
                        <div>
                            <i class="fas fa-credit-card fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">
                <i class="fas fa-list me-2"></i>Detail Transaksi
            </h5>
            
            <div class="table-responsive desktop-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-2"></i>ID</th>
                            <th><i class="fas fa-user-tie me-2"></i>Karyawan</th>
                            <th><i class="fas fa-user me-2"></i>Pelanggan</th>
                            <th><i class="fas fa-cogs me-2"></i>Layanan</th>
                            <th><i class="fas fa-weight me-2"></i>Berat</th>
                            <th><i class="fas fa-money-bill-wave me-2"></i>Total</th>
                            <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                            <th><i class="fas fa-info-circle me-2"></i>Status</th>
                            <th><i class="fas fa-credit-card me-2"></i>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($transaksis as $t): ?>
                        <tr>
                            <td><?= $t['Id_transaksi'] ?></td>
                            <td><?= htmlspecialchars($t['nama_karyawan']) ?></td>
                            <td><?= htmlspecialchars($t['nama_pelanggan']) ?></td>
                            <td><?= htmlspecialchars($t['jenis_layanan']) ?></td>
                            <td><?= htmlspecialchars($t['total_berat']) ?> kg</td>
                            <td>Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></td>
                            <td><?= date('d/m/Y', strtotime($t['tanggal_transaksi'])) ?></td>
                            <td>
                                <?php if($t['status']): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Proses</span>
                                <?php endif; ?>
                            </td>
                            <td><?= ucfirst($t['metode']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Card View -->
            <div class="mobile-table-card">
                <?php foreach($transaksis as $t): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-hashtag me-2"></i>ID</span>
                            <span class="data-value"><?= $t['Id_transaksi'] ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-user-tie me-2"></i>Karyawan</span>
                            <span class="data-value"><?= htmlspecialchars($t['nama_karyawan']) ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-user me-2"></i>Pelanggan</span>
                            <span class="data-value"><?= htmlspecialchars($t['nama_pelanggan']) ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-cogs me-2"></i>Layanan</span>
                            <span class="data-value"><?= htmlspecialchars($t['jenis_layanan']) ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-weight me-2"></i>Berat</span>
                            <span class="data-value"><?= htmlspecialchars($t['total_berat']) ?> kg</span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-money-bill-wave me-2"></i>Total</span>
                            <span class="data-value">Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-calendar me-2"></i>Tanggal</span>
                            <span class="data-value"><?= date('d/m/Y', strtotime($t['tanggal_transaksi'])) ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-info-circle me-2"></i>Status</span>
                            <span class="data-value">
                                <?php if($t['status']): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Proses</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-credit-card me-2"></i>Metode</span>
                            <span class="data-value"><?= ucfirst($t['metode']) ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
