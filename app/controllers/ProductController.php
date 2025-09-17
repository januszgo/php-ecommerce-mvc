<?php
require_once __DIR__ . '/../models/Product.php';
// app/controllers/ProductController.php
class ProductController {
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $products = Product::getAll($limit, $offset);
        $totalProducts = Product::countAll();
        $totalPages = ceil($totalProducts / $limit);

        $view = __DIR__ . '/../views/products/index.php';
        require __DIR__ . '/../views/layouts/main.php';
    }
}