<h1>Twój profil</h1>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <label>Email:<br>
        <?= htmlspecialchars($user['email']) ?>
    </label><br><br>

    <label>Imię:<br>
        <?= htmlspecialchars($user['name']) ?>
    </label><br><br>

    <label>Login:<br>
        <?= htmlspecialchars($user['login']) ?>
    </label><br><br>

    <label>Nowe hasło:<br>
        <input type="password" name="password" placeholder="Pozostaw puste, jeśli bez zmian">
    </label><br><br>

    <label>Telefon:<br>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
    </label><br><br>

    <label>Adres:<br>
        <input type="text" name="address" value="<?= htmlspecialchars($user['address']) ?>">
    </label><br><br>

    <button type="submit">Zapisz zmiany</button>
</form>
