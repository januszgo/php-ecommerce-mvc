<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Basket.php';
// app/controllers/OrderController.php
class OrderController {
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
        $userId = $_SESSION['user_id'];
        $items = Basket::getItems();
        if (!empty($items)) {
            Order::create($userId, $items);
            Basket::clear();
        }
        header('Location: index.php?controller=user&action=orders');
        exit;
    }
}
