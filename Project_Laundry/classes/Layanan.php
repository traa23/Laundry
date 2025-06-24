<?php
require_once 'config/database.php';

class Layanan extends Database {
    private $table = "layanan";
    
    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->koneksi->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->koneksi->prepare("SELECT * FROM {$this->table} WHERE id_layanan = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function tambah($data) {
        $stmt = $this->koneksi->prepare("INSERT INTO {$this->table} (jenis_layanan, berat, harga) VALUES (?, ?, ?)");
        $stmt->bind_param("sdd", $data['jenis_layanan'], $data['berat'], $data['harga']);
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $stmt = $this->koneksi->prepare("UPDATE {$this->table} SET jenis_layanan = ?, berat = ?, harga = ? WHERE id_layanan = ?");
        $stmt->bind_param("sddi", $data['jenis_layanan'], $data['berat'], $data['harga'], $id);
        return $stmt->execute();
    }
    
    public function hapus($id) {
        $stmt = $this->koneksi->prepare("DELETE FROM {$this->table} WHERE id_layanan = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function hitungHarga($id_layanan, $berat) {
        $layanan = $this->getById($id_layanan);
        if($layanan) {
            return $layanan['harga'] * $berat;
        }
        return 0;
    }
}
?>
