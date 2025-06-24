<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/Layanan.php';

$user = new User();
$user->cekRole();

$layanan = new Layanan();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'jenis_layanan' => $_POST['jenis_layanan'],
        'berat' => $_POST['berat'],
        'harga' => $_POST['harga']
    ];

    if($_POST['action'] == 'tambah') {
        $layanan->tambah($data);
    } elseif($_POST['action'] == 'edit' && isset($_POST['id'])) {
        $layanan->update($_POST['id'], $data);
    }
    header("Location: layanan.php");
    exit();
}

if($action == 'hapus' && $id) {
    $layanan->hapus($id);
    header("Location: layanan.php");
    exit();
}

$layanans = $layanan->getAll();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Layanan - Fresh Laundry</title>
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
                <i class="fas fa-cogs me-2"></i>Kelola Layanan
            </h2>
            <p class="card-text text-muted">Manajemen jenis layanan Fresh Laundry</p>
        </div>
    </div>

    <?php if($action == 'tambah' || ($action == 'edit' && $id)): 
        $editData = $action == 'edit' ? $layanan->getById($id) : null;
    ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">
                <?= $action == 'edit' ? '<i class="fas fa-edit me-2"></i>Edit Layanan' : '<i class="fas fa-plus-circle me-2"></i>Tambah Layanan' ?>
            </h5>
            <form method="POST" action="layanan.php">
                <input type="hidden" name="action" value="<?= $action ?>">
                <?php if($action == 'edit'): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="jenis_layanan" class="form-label">
                        <i class="fas fa-tags me-2"></i>Jenis Layanan
                    </label>
                    <input type="text" name="jenis_layanan" id="jenis_layanan" 
                           class="form-control" required 
                           value="<?= htmlspecialchars($editData['jenis_layanan'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="berat" class="form-label">
                        <i class="fas fa-weight me-2"></i>Berat (kg)
                    </label>
                    <input type="number" step="0.01" name="berat" id="berat" 
                           class="form-control" required 
                           value="<?= htmlspecialchars($editData['berat'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">
                        <i class="fas fa-money-bill-wave me-2"></i>Harga (Rp)
                    </label>
                    <input type="number" step="0.01" name="harga" id="harga" 
                           class="form-control" required 
                           value="<?= htmlspecialchars($editData['harga'] ?? '') ?>">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="layanan.php" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
    <?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Daftar Layanan</h5>
                <a href="layanan.php?action=tambah" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah Layanan
                </a>
            </div>
            
            <div class="table-responsive desktop-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-2"></i>ID</th>
                            <th><i class="fas fa-tags me-2"></i>Jenis Layanan</th>
                            <th><i class="fas fa-weight me-2"></i>Berat (kg)</th>
                            <th><i class="fas fa-money-bill-wave me-2"></i>Harga (Rp)</th>
                            <th><i class="fas fa-cog me-2"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($layanans as $l): ?>
                        <tr>
                            <td><?= $l['id_layanan'] ?></td>
                            <td><?= htmlspecialchars($l['jenis_layanan']) ?></td>
                            <td><?= htmlspecialchars($l['berat']) ?></td>
                            <td>Rp <?= number_format($l['harga'], 0, ',', '.') ?></td>
                            <td>
                                <a href="layanan.php?action=edit&id=<?= $l['id_layanan'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="layanan.php?action=hapus&id=<?= $l['id_layanan'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Card View -->
            <div class="mobile-table-card">
                <?php foreach($layanans as $l): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-hashtag me-2"></i>ID</span>
                            <span class="data-value"><?= $l['id_layanan'] ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-tag me-2"></i>Jenis</span>
                            <span class="data-value"><?= htmlspecialchars($l['jenis_layanan']) ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-money-bill-wave me-2"></i>Harga</span>
                            <span class="data-value">Rp <?= number_format($l['harga'], 0, ',', '.') ?>/kg</span>
                        </div>
                        <div class="action-buttons">
                            <a href="layanan.php?action=edit&id=<?= $l['id_layanan'] ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="layanan.php?action=hapus&id=<?= $l['id_layanan'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
