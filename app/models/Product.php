<?php
// app/models/Product.php
class Product {
    public static function getAll($limit = null, $offset = null) {
        $db = getPDO();
        $sql = "SELECT * FROM products ORDER BY name";
        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $db->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countAll() {
        $db = getPDO();
        $stmt = $db->query("SELECT COUNT(*) as total FROM products");
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function find($id) {
        $db = getPDO();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
