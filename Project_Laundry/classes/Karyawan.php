<?php
require_once 'config/database.php';

class Karyawan extends Database {
    private $table = "karyawan";
    
    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->koneksi->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->koneksi->prepare("SELECT * FROM {$this->table} WHERE id_karyawan = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function tambah($data) {
        $stmt = $this->koneksi->prepare("INSERT INTO {$this->table} (nama_karyawan, alamat, no_hp) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['nama_karyawan'], $data['alamat'], $data['no_hp']);
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $stmt = $this->koneksi->prepare("UPDATE {$this->table} SET nama_karyawan = ?, alamat = ?, no_hp = ? WHERE id_karyawan = ?");
        $stmt->bind_param("sssi", $data['nama_karyawan'], $data['alamat'], $data['no_hp'], $id);
        return $stmt->execute();
    }
    
    public function hapus($id) {
        $stmt = $this->koneksi->prepare("DELETE FROM {$this->table} WHERE id_karyawan = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
