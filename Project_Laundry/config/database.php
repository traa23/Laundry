<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "laundry";
    protected $koneksi;

    public function __construct() {
        try {
            $this->koneksi = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->koneksi->connect_error) {
                throw new Exception("Koneksi database gagal: " . $this->koneksi->connect_error);
            }

            // Membuat tabel users jika belum ada
            $this->createUsersTable();
            
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    private function createUsersTable() {
        // Hapus tabel users jika sudah ada
        $this->koneksi->query("DROP TABLE IF EXISTS `users`");
        
        // Buat tabel users baru
        $sql = "CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL,
            `password` varchar(255) NOT NULL,
            `role` enum('admin','owner') NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $this->koneksi->query($sql);

        // Cek apakah tabel users kosong
        $result = $this->koneksi->query("SELECT COUNT(*) as count FROM users");
        $row = $result->fetch_assoc();
        
        if ($row['count'] == 0) {
            // Insert default admin dan owner dengan password yang sudah di-hash menggunakan prepared statement
            $adminPass = password_hash('admin123', PASSWORD_DEFAULT);
            $ownerPass = password_hash('owner123', PASSWORD_DEFAULT);

            $stmt = $this->koneksi->prepare("INSERT INTO `users` (`username`, `password`, `role`) VALUES (?, ?, ?), (?, ?, ?)");
            $adminRole = 'admin';
            $ownerRole = 'owner';
            $stmt->bind_param("ssssss", $adminUsername, $adminPassParam, $adminRole, $ownerUsername, $ownerPassParam, $ownerRole);

            $adminUsername = 'admin';
            $adminPassParam = $adminPass;
            $ownerUsername = 'owner';
            $ownerPassParam = $ownerPass;

            $stmt->execute();
            $stmt->close();
        }
    }

    public function getKoneksi() {
        return $this->koneksi;
    }
}
?>
