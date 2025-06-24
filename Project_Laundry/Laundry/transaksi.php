 <?php
session_start();
require_once 'classes/User.php';
require_once 'classes/Transaksi.php';
require_once 'classes/Karyawan.php';
require_once 'classes/Pelanggan.php';
require_once 'classes/Layanan.php';

$user = new User();
$user->cekRole();

$transaksi = new Transaksi();
$karyawan = new Karyawan();
$pelanggan = new Pelanggan();
$layanan = new Layanan();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id_karyawan' => $_POST['id_karyawan'],
        'id_pelanggan' => $_POST['id_pelanggan'],
        'id_layanan' => $_POST['id_layanan'],
        'total_berat' => $_POST['total_berat'],
        'total_harga' => $_POST['total_harga'],
        'tanggal_transaksi' => $_POST['tanggal_transaksi'],
        'status' => $_POST['status'],
        'metode' => $_POST['metode']
    ];

    if($_POST['action'] == 'tambah') {
        $transaksi->tambah($data);
    } elseif($_POST['action'] == 'edit' && isset($_POST['id'])) {
        $transaksi->update($_POST['id'], $data);
    }
    header("Location: transaksi.php");
    exit();
}

if($action == 'hapus' && $id) {
    $transaksi->hapus($id);
    header("Location: transaksi.php");
    exit();
}

$transaksis = $transaksi->getAll();
$karyawans = $karyawan->getAll();
$pelanggans = $pelanggan->getAll();
$layanans = $layanan->getAll();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Transaksi - Fresh Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        function hitungTotal() {
            const idLayanan = document.getElementById('id_layanan').value;
            const berat = document.getElementById('total_berat').value;
            const layananHarga = <?= json_encode(array_column($layanans, 'harga', 'id_layanan')) ?>;
            
            if(idLayanan && berat) {
                const total = layananHarga[idLayanan] * berat;
                document.getElementById('total_harga').value = total;
            }
        }
    </script>
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
                <i class="fas fa-exchange-alt me-2"></i>Kelola Transaksi
            </h2>
            <p class="card-text text-muted">Manajemen transaksi laundry Fresh Laundry</p>
        </div>
    </div>

    <?php if($action == 'tambah' || ($action == 'edit' && $id)): 
        $editData = $action == 'edit' ? $transaksi->getById($id) : null;
    ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">
                <?= $action == 'edit' ? '<i class="fas fa-edit me-2"></i>Edit Transaksi' : '<i class="fas fa-plus-circle me-2"></i>Tambah Transaksi' ?>
            </h5>
            <form method="POST" action="transaksi.php">
                <input type="hidden" name="action" value="<?= $action ?>">
                <?php if($action == 'edit'): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_karyawan" class="form-label">
                                <i class="fas fa-user-tie me-2"></i>Karyawan
                            </label>
                            <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                                <option value="">Pilih Karyawan</option>
                                <?php foreach($karyawans as $k): ?>
                                    <option value="<?= $k['id_karyawan'] ?>" <?= ($editData['id_karyawan'] ?? '') == $k['id_karyawan'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k['nama_karyawan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_pelanggan" class="form-label">
                                <i class="fas fa-user me-2"></i>Pelanggan
                            </label>
                            <select name="id_pelanggan" id="id_pelanggan" class="form-control" required>
                                <option value="">Pilih Pelanggan</option>
                                <?php foreach($pelanggans as $p): ?>
                                    <option value="<?= $p['id_pelanggan'] ?>" <?= ($editData['id_pelanggan'] ?? '') == $p['id_pelanggan'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['nama_pelanggan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_layanan" class="form-label">
                                <i class="fas fa-cogs me-2"></i>Layanan
                            </label>
                            <select name="id_layanan" id="id_layanan" class="form-control" required onchange="hitungTotal()">
                                <option value="">Pilih Layanan</option>
                                <?php foreach($layanans as $l): ?>
                                    <option value="<?= $l['id_layanan'] ?>" <?= ($editData['id_layanan'] ?? '') == $l['id_layanan'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($l['jenis_layanan']) ?> - Rp<?= number_format($l['harga'], 0, ',', '.') ?>/kg
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_berat" class="form-label">
                                <i class="fas fa-weight me-2"></i>Total Berat (kg)
                            </label>
                            <input type="number" step="0.01" name="total_berat" id="total_berat" 
                                   class="form-control" required 
                                   value="<?= htmlspecialchars($editData['total_berat'] ?? '') ?>" 
                                   onchange="hitungTotal()">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_harga" class="form-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Total Harga (Rp)
                            </label>
                            <input type="number" step="0.01" name="total_harga" id="total_harga" 
                                   class="form-control" required 
                                   value="<?= htmlspecialchars($editData['total_harga'] ?? '') ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_transaksi" class="form-label">
                                <i class="fas fa-calendar me-2"></i>Tanggal Transaksi
                            </label>
                            <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" 
                                   class="form-control" required 
                                   value="<?= htmlspecialchars($editData['tanggal_transaksi'] ?? date('Y-m-d')) ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Status
                            </label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="0" <?= ($editData['status'] ?? '') == '0' ? 'selected' : '' ?>>Proses</option>
                                <option value="1" <?= ($editData['status'] ?? '') == '1' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="metode" class="form-label">
                                <i class="fas fa-credit-card me-2"></i>Metode Pembayaran
                            </label>
                            <select name="metode" id="metode" class="form-control" required>
                                <option value="cash" <?= ($editData['metode'] ?? '') == 'cash' ? 'selected' : '' ?>>Cash</option>
                                <option value="transfer" <?= ($editData['metode'] ?? '') == 'transfer' ? 'selected' : '' ?>>Transfer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="transaksi.php" class="btn btn-secondary">
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
                <h5 class="card-title mb-0">Daftar Transaksi</h5>
                <a href="transaksi.php?action=tambah" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah Transaksi
                </a>
            </div>
            
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
                            <th><i class="fas fa-cog me-2"></i>Aksi</th>
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
                            <td>
                                <a href="transaksi.php?action=edit&id=<?= $t['Id_transaksi'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="transaksi.php?action=hapus&id=<?= $t['Id_transaksi'] ?>" 
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
                        <div class="action-buttons">
                            <a href="transaksi.php?action=edit&id=<?= $t['Id_transaksi'] ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="transaksi.php?action=hapus&id=<?= $t['Id_transaksi'] ?>" 
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
