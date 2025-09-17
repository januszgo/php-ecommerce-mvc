<?php
require_once __DIR__ . '/Product.php';
// app/models/Basket.php
class Basket {
    public static function add($id) {
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
        if (isset($_SESSION['basket'][$id])) {
            $_SESSION['basket'][$id]++;
        } else {
            $_SESSION['basket'][$id] = 1;
        }
    }

    public static function remove($id) {
        if (isset($_SESSION['basket'][$id])) {
            unset($_SESSION['basket'][$id]);
        }
    }

    public static function clear() {
        unset($_SESSION['basket']);
    }

    public static function getItems() {
        $items = [];
        if (!isset($_SESSION['basket'])) {
            return $items;
        }
        foreach ($_SESSION['basket'] as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $product['qty'] = $qty;
                $items[] = $product;
            }
        }
        return $items;
    }

    public static function updateQuantities($quantities) {
        if (!isset($_SESSION['basket'])) return;
        foreach ($quantities as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $qty = max(1, min((int)$qty, (int)$product['amount'])); // ograniczenie do amount
                $_SESSION['basket'][$id] = $qty;
            }
        }
    }
}
