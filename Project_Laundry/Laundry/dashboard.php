<?php
session_start();
require_once 'classes/User.php';

$user = new User();
$user->cekRole();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Fresh Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="fas fa-tshirt me-2"></i>Fresh Laundry</a>
    <div class="d-flex">
      <span class="navbar-text me-3"><i class="fas fa-user me-1"></i>Halo, <?= htmlspecialchars($_SESSION['username']) ?></span>
      <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4 fade-in">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h2 class="card-title text-primary"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Fresh Laundry</h2>
                    <p class="card-text text-muted">Selamat datang di sistem manajemen laundry terbaik</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Kelola Karyawan</h5>
                    <p class="card-text">Manajemen data karyawan</p>
                    <a href="karyawan.php" class="btn btn-primary">Akses <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cogs fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Kelola Layanan</h5>
                    <p class="card-text">Manajemen jenis layanan</p>
                    <a href="layanan.php" class="btn btn-success">Akses <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-friends fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Kelola Pelanggan</h5>
                    <p class="card-text">Manajemen data pelanggan</p>
                    <a href="pelanggan.php" class="btn btn-warning">Akses <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-exchange-alt fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Kelola Transaksi</h5>
                    <p class="card-text">Manajemen transaksi laundry</p>
                    <a href="transaksi.php" class="btn btn-info">Akses <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <?php if($user->isOwner()): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-3x text-danger mb-3"></i>
                    <h5 class="card-title">Laporan Keuangan</h5>
                    <p class="card-text">Laporan dan analisis keuangan</p>
                    <a href="laporan.php" class="btn btn-danger">Akses <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
