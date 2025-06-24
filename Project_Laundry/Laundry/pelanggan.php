<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/Pelanggan.php';

$user = new User();
$user->cekRole();

$pelanggan = new Pelanggan();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'nama_pelanggan' => $_POST['nama_pelanggan'],
        'alamat' => $_POST['alamat'],
        'no_hp' => $_POST['no_hp']
    ];

    if($_POST['action'] == 'tambah') {
        $pelanggan->tambah($data);
    } elseif($_POST['action'] == 'edit' && isset($_POST['id'])) {
        $pelanggan->update($_POST['id'], $data);
    }
    header("Location: pelanggan.php");
    exit();
}

if($action == 'hapus' && $id) {
    $pelanggan->hapus($id);
    header("Location: pelanggan.php");
    exit();
}

$pelanggans = $pelanggan->getAll();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pelanggan - Fresh Laundry</title>
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
                <i class="fas fa-user-friends me-2"></i>Kelola Pelanggan
            </h2>
            <p class="card-text text-muted">Manajemen data pelanggan Fresh Laundry</p>
        </div>
    </div>

    <?php if($action == 'tambah' || ($action == 'edit' && $id)): 
        $editData = $action == 'edit' ? $pelanggan->getById($id) : null;
    ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">
                <?= $action == 'edit' ? '<i class="fas fa-edit me-2"></i>Edit Pelanggan' : '<i class="fas fa-plus-circle me-2"></i>Tambah Pelanggan' ?>
            </h5>
            <form method="POST" action="pelanggan.php">
                <input type="hidden" name="action" value="<?= $action ?>">
                <?php if($action == 'edit'): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">
                        <i class="fas fa-user me-2"></i>Nama Pelanggan
                    </label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" 
                           class="form-control" required 
                           value="<?= htmlspecialchars($editData['nama_pelanggan'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">
                        <i class="fas fa-map-marker-alt me-2"></i>Alamat
                    </label>
                    <input type="text" name="alamat" id="alamat" 
                           class="form-control" required 
                           value="<?= htmlspecialchars($editData['alamat'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">
                        <i class="fas fa-phone me-2"></i>No HP
                    </label>
                    <input type="text" name="no_hp" id="no_hp" 
                           class="form-control" required 
                           value="<?= htmlspecialchars($editData['no_hp'] ?? '') ?>">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="pelanggan.php" class="btn btn-secondary">
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
                <h5 class="card-title mb-0">Daftar Pelanggan</h5>
                <a href="pelanggan.php?action=tambah" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah Pelanggan
                </a>
            </div>
            
            <div class="table-responsive desktop-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-2"></i>ID</th>
                            <th><i class="fas fa-user me-2"></i>Nama Pelanggan</th>
                            <th><i class="fas fa-map-marker-alt me-2"></i>Alamat</th>
                            <th><i class="fas fa-phone me-2"></i>No HP</th>
                            <th><i class="fas fa-cog me-2"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pelanggans as $p): ?>
                        <tr>
                            <td><?= $p['id_pelanggan'] ?></td>
                            <td><?= htmlspecialchars($p['nama_pelanggan']) ?></td>
                            <td><?= htmlspecialchars($p['alamat']) ?></td>
                            <td><?= htmlspecialchars($p['no_hp']) ?></td>
                            <td>
                                <a href="pelanggan.php?action=edit&id=<?= $p['id_pelanggan'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="pelanggan.php?action=hapus&id=<?= $p['id_pelanggan'] ?>" 
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
                <?php foreach($pelanggans as $p): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-hashtag me-2"></i>ID</span>
                            <span class="data-value"><?= $p['id_pelanggan'] ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-user me-2"></i>Nama</span>
                            <span class="data-value"><?= htmlspecialchars($p['nama_pelanggan']) ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-map-marker-alt me-2"></i>Alamat</span>
                            <span class="data-value"><?= htmlspecialchars($p['alamat']) ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label"><i class="fas fa-phone me-2"></i>No HP</span>
                            <span class="data-value"><?= htmlspecialchars($p['no_hp']) ?></span>
                        </div>
                        <div class="action-buttons">
                            <a href="pelanggan.php?action=edit&id=<?= $p['id_pelanggan'] ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="pelanggan.php?action=hapus&id=<?= $p['id_pelanggan'] ?>" 
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
