<?php
require_once 'config/database.php';

class User extends Database {
    private $table = "users";
    
    public function login($username, $password) {
        try {
            $stmt = $this->koneksi->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $this->koneksi->error);
            }
            
            $stmt->bind_param("s", $username);
            if (!$stmt->execute()) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
            
            $result = $stmt->get_result();
            
            if($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if(password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['username'] = $user['username'];
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    public function cekRole() {
        if(!isset($_SESSION['role'])) {
            header("Location: index.php");
            exit();
        }
    }

    public function isOwner() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'owner';
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>
