<?php
require_once __DIR__ . '/../models/Product.php';
// app/controllers/ProductController.php
class ProductController {
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $sort = $_GET['sort'] ?? 'name';
        $order = $_GET['order'] ?? 'asc';

        $products = Product::getAll($limit, $offset, $search, $category, $sort, $order);
        $totalProducts = Product::countAll($search, $category);
        $totalPages = ceil($totalProducts / $limit);
        $categories = Product::getCategories();

        $view = __DIR__ . '/../views/products/index.php';
        require __DIR__ . '/../views/layouts/main.php';
    }
}