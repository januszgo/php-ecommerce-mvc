<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Sklep MVC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <a href="index.php">Produkty</a> |
    <a href="index.php?controller=basket&action=index">Koszyk</a> |
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="index.php?controller=user&action=profile">Profil</a> |
        <a href="index.php?controller=user&action=orders">Moje zamówienia</a> |
        <a href="index.php?controller=user&action=listUsers">Użytkownicy</a> |
        <a href="index.php?controller=user&action=logout">Wyloguj</a>
    <?php else: ?>
        <a href="index.php?controller=user&action=login">Logowanie</a> |
        <a href="index.php?controller=user&action=listUsers">Użytkownicy</a> |
        <a href="index.php?controller=user&action=register">Rejestracja</a>
    <?php endif; ?>
</nav>
<hr>
<div class="container">
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php include $view; ?>
</div>
</body>
</html>
