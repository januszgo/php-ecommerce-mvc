<?php
class User {

    public static function create($login, $name, $password, $email, $phone = null, $address = null) {
        $db = getPDO();

        // Włącz tryb wyjątków PDO
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Hashowanie hasła
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare(
            "INSERT INTO users (login, name, password, email, phone, address) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([$login, $name, $hashedPassword, $email, $phone, $address]);
    }

    public static function exists($login, $email) {
        $db = getPDO();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("SELECT id FROM users WHERE login = ? OR email = ?");
        $stmt->execute([$login, $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public static function authenticate($login, $password) {
        $db = getPDO();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public static function findById($id) {
        $db = getPDO();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateProfile($id, $password = null, $phone = null, $address = null) {
        $db = getPDO();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password = ?, phone = ?, address = ? WHERE id = ?");
            $stmt->execute([$hashedPassword, $phone, $address, $id]);
        } else {
            $stmt = $db->prepare("UPDATE users SET phone = ?, address = ? WHERE id = ?");
            $stmt->execute([$phone, $address, $id]);
        }
    }

    public static function getAll() {
        $db = getPDO();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $db->query("SELECT id, login, name, email, phone, address FROM users ORDER BY login");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
