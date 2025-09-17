<?php
require_once __DIR__ . '/../models/Basket.php';
// app/controllers/BasketController.php
class BasketController {
    public function index() {
        // Pokaz koszyk
        $items = Basket::getItems();
        $view = __DIR__ . '/../views/basket/index.php';
        require __DIR__ . '/../views/layouts/main.php';
    }

    public function add() {
        // Dodaj produkt do koszyka (po id)
        $id = $_GET['id'] ?? null;
        if ($id) {
            Basket::add($id);
        }
        header('Location: index.php?controller=basket&action=index');
        exit;
    }

    public function remove() {
        // Usuń produkt z koszyka
        $id = $_GET['id'] ?? null;
        if ($id) {
            Basket::remove($id);
        }
        header('Location: index.php?controller=basket&action=index');
        exit;
    }

    public function clear() {
        // Wyczyść cały koszyk
        Basket::clear();
        header('Location: index.php?controller=basket&action=index');
        exit;
    }

    public function updateAmount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
            Basket::updateQuantities($_POST['quantities']);
        }
        header('Location: index.php?controller=basket&action=index');
        exit;
    }
}
