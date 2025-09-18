<?php
// app/models/Product.php
class Product {
    public static function getAll($limit = null, $offset = null, $search = '', $category = '', $sort = 'name', $order = 'asc') {
        $db = getPDO();

        $sql = "SELECT * FROM products WHERE 1";
        $params = [];

        if ($search !== '') {
            $sql .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }

        if ($category !== '') {
            $sql .= " AND category = :category";
            $params[':category'] = $category;
        }

        $allowedSort = ['name','price'];
        $allowedOrder = ['asc','desc'];
        if (!in_array($sort,$allowedSort)) $sort = 'name';
        if (!in_array($order,$allowedOrder)) $order = 'asc';

        $sql .= " ORDER BY $sort $order";

        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $db->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }

        if ($limit !== null && $offset !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countAll($search = '', $category = '') {
        $db = getPDO();
        $sql = "SELECT COUNT(*) as total FROM products WHERE 1";
        $params = [];

        if ($search !== '') {
            $sql .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }
        if ($category !== '') {
            $sql .= " AND category = :category";
            $params[':category'] = $category;
        }

        $stmt = $db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();

        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function getCategories() {
        $db = getPDO();
        $stmt = $db->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function find($id) {
        $db = getPDO();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
