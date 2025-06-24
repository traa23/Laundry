<?php
require_once 'config/database.php';

class Pelanggan extends Database {
    private $table = "pelanggan";
    
    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->koneksi->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->koneksi->prepare("SELECT * FROM {$this->table} WHERE id_pelanggan = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function tambah($data) {
        $stmt = $this->koneksi->prepare("INSERT INTO {$this->table} (nama_pelanggan, alamat, no_hp) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['nama_pelanggan'], $data['alamat'], $data['no_hp']);
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $stmt = $this->koneksi->prepare("UPDATE {$this->table} SET nama_pelanggan = ?, alamat = ?, no_hp = ? WHERE id_pelanggan = ?");
        $stmt->bind_param("sssi", $data['nama_pelanggan'], $data['alamat'], $data['no_hp'], $id);
        return $stmt->execute();
    }
    
    public function hapus($id) {
        $stmt = $this->koneksi->prepare("DELETE FROM {$this->table} WHERE id_pelanggan = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
