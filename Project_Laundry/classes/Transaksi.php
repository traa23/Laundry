<?php
require_once 'config/database.php';

class Transaksi extends Database {
    private $table = "transaksilaundry";
    
    public function getAll() {
        $query = "SELECT t.*, k.nama_karyawan, p.nama_pelanggan, l.jenis_layanan 
                  FROM {$this->table} t
                  JOIN karyawan k ON t.id_karyawan = k.id_karyawan
                  JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                  JOIN layanan l ON t.id_layanan = l.id_layanan
                  ORDER BY t.tanggal_transaksi DESC";
        $result = $this->koneksi->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->koneksi->prepare("SELECT * FROM {$this->table} WHERE Id_transaksi = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function tambah($data) {
        $stmt = $this->koneksi->prepare("INSERT INTO {$this->table} (id_karyawan, id_pelanggan, id_layanan, total_harga, tanggal_transaksi, status, metode, total_berat) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidssis", $data['id_karyawan'], $data['id_pelanggan'], $data['id_layanan'], $data['total_harga'], $data['tanggal_transaksi'], $data['status'], $data['metode'], $data['total_berat']);
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $stmt = $this->koneksi->prepare("UPDATE {$this->table} SET id_karyawan = ?, id_pelanggan = ?, id_layanan = ?, total_harga = ?, tanggal_transaksi = ?, status = ?, metode = ?, total_berat = ? WHERE Id_transaksi = ?");
        $stmt->bind_param("iiidssisi", $data['id_karyawan'], $data['id_pelanggan'], $data['id_layanan'], $data['total_harga'], $data['tanggal_transaksi'], $data['status'], $data['metode'], $data['total_berat'], $id);
        return $stmt->execute();
    }
    
    public function hapus($id) {
        $stmt = $this->koneksi->prepare("DELETE FROM {$this->table} WHERE Id_transaksi = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
