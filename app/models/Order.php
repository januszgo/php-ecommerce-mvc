<?php
// app/models/Order.php

class Order {
    /**
     * Tworzy nowe zamówienie dla użytkownika
     * 
     * @param int $userId ID użytkownika
     * @param array $items Tablica produktów: [ ['id'=>1,'qty'=>2], ... ]
     */
    public static function create($userId, $items) {
        $db = getPDO();
        $db->beginTransaction();

        // Zamiana listy produktów na JSON
        $productsList = json_encode($items);

        // Wstawienie zamówienia do tabeli orders
        $stmt = $db->prepare(
            "INSERT INTO orders (user_id, products_list) VALUES (?, ?)"
        );
        $stmt->execute([$userId, $productsList]);

        $orderId = $db->lastInsertId();

        // Wstawienie pozycji zamówienia do order_items
        $stmtItem = $db->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)"
        );
        foreach ($items as $item) {
            $stmtItem->execute([$orderId, $item['id'], $item['qty']]);
        }

        $db->commit();
    }

    /**
     * Pobiera wszystkie zamówienia danego użytkownika
     * 
     * @param int $userId
     * @return array Lista zamówień z pozycjami
     */
    public static function getByUser($userId) {
        $db = getPDO();

        // Pobranie zamówień
        $stmt = $db->prepare(
            "SELECT * FROM orders WHERE user_id = ? ORDER BY date_of_order DESC"
        );
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pobranie pozycji dla każdego zamówienia
        foreach ($orders as &$order) {
            $stmtItems = $db->prepare(
                "SELECT oi.quantity, p.name, p.price
                 FROM order_items oi
                 JOIN products p ON oi.product_id = p.id
                 WHERE oi.order_id = ?"
            );
            $stmtItems->execute([$order['id']]);
            $order['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
        }

        return $orders;
    }
}
