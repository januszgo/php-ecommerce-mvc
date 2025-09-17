<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';

class UserController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::authenticate($login, $password);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header('Location: index.php');
                exit;
            } else {
                $error = "Nieprawidłowy login lub hasło";
            }
        }

        $view = __DIR__ . '/../views/user/login.php';
        require __DIR__ . '/../views/layouts/main.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login    = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm'] ?? '';
            $name     = $_POST['name'] ?? '';
            $email    = $_POST['email'] ?? '';
            $phone    = $_POST['phone'] ?? null;
            $address  = $_POST['address'] ?? null;

            // Sprawdzenie, czy użytkownik już istnieje
            if (User::exists($login, $email)) {
                $error = "Użytkownik z tym loginem lub emailem już istnieje.";
            } elseif ($password && $password === $confirm) {
                try {
                    User::create($login, $name, $password, $email, $phone, $address);
                    $user = User::authenticate($login, $password);
                    if ($user) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        header('Location: index.php');
                        exit;
                    } else {
                        $error = "Nie udało się zalogować po rejestracji";
                    }
                } catch (PDOException $e) {
                    $error = "Błąd bazy danych: " . $e->getMessage();
                }
            } else {
                $error = "Hasła nie są takie same";
            }
        }

        $view = __DIR__ . '/../views/user/register.php';
        require __DIR__ . '/../views/layouts/main.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
    
        $user = User::findById($_SESSION['user_id']);
        if (!$user) {
            // jeśli użytkownik nie istnieje w bazie
            session_destroy();
            header('Location: index.php?controller=user&action=login');
            exit;
        }
        $error = null;
        $success = null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? null;
            $phone    = $_POST['phone'] ?? null;
            $address  = $_POST['address'] ?? null;
    
            try {
                User::updateProfile($_SESSION['user_id'], $password, $phone, $address);
                $success = "Dane zostały zaktualizowane";
                $user = User::findById($_SESSION['user_id']); // odśwież dane
            } catch (PDOException $e) {
                $error = "Błąd aktualizacji: " . $e->getMessage();
            }
        }
    
        $view = __DIR__ . '/../views/user/profile.php';
        require __DIR__ . '/../views/layouts/main.php';
    }

    public function orders() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        $orders = Order::getByUser($_SESSION['user_id']);
        $view = __DIR__ . '/../views/user/orders.php';
        require __DIR__ . '/../views/layouts/main.php';
    }

    public function listUsers() {
        // opcjonalnie: dostęp tylko dla zalogowanych użytkowników
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: index.php?controller=user&action=login');
        //     exit;
        // }
    
        // Pobranie wszystkich użytkowników (bez haseł)
        $allUsers = User::getAll();
    
        $view = __DIR__ . '/../views/user/users.php';
        require __DIR__ . '/../views/layouts/main.php';
    }
}
