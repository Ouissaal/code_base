<?php
class User {
    
    public static function findByEmail($email) {
        global $pdo;
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error finding user by email: " . $e->getMessage());
            return false;
        }
    }
    
    public static function findById($id) {
        global $pdo;
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error finding user by ID: " . $e->getMessage());
            return false;
        }
    }
    
    public static function findByUsername($username) {
        global $pdo;
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE username = ?");
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error finding user by username: " . $e->getMessage());
            return false;
        }
    }
    
    public static function create($username, $email, $password) {
        global $pdo;
        
        try {
            $stmt = $pdo->prepare("INSERT INTO utilisateur (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([
                $username,
                $email,
                password_hash($password, PASSWORD_DEFAULT)
            ]);
            return $pdo->lastInsertId();
        } catch(PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }
    
    public static function update($id, $username, $email) {
        global $pdo;
        
        try {
            $stmt = $pdo->prepare("UPDATE utilisateur SET username = ?, email = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$username, $email, $id]);
            return $stmt->rowCount() > 0;
        } catch(PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }
    
    public static function updatePassword($id, $password) {
        global $pdo;
        
        try {
            $stmt = $pdo->prepare("UPDATE utilisateur SET password = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([
                password_hash($password, PASSWORD_DEFAULT),
                $id
            ]);
            return $stmt->rowCount() > 0;
        } catch(PDOException $e) {
            error_log("Error updating password: " . $e->getMessage());
            return false;
        }
    }
    
    public static function emailExists($email, $excludeId = null) {
        global $pdo;
        
        try {
            if ($excludeId) {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ? AND id != ?");
                $stmt->execute([$email, $excludeId]);
            } else {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
                $stmt->execute([$email]);
            }
            return $stmt->fetchColumn() > 0;
        } catch(PDOException $e) {
            error_log("Error checking email exists: " . $e->getMessage());
            return false;
        }
    }
    
    public static function usernameExists($username, $excludeId = null) {
        global $pdo;
        
        try {
            if ($excludeId) {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE username = ? AND id != ?");
                $stmt->execute([$username, $excludeId]);
            } else {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE username = ?");
                $stmt->execute([$username]);
            }
            return $stmt->fetchColumn() > 0;
        } catch(PDOException $e) {
            error_log("Error checking username exists: " . $e->getMessage());
            return false;
        }
    }
}
?>