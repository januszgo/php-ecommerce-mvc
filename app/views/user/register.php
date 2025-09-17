<h1>Rejestracja</h1>

<form method="post" action="index.php?controller=user&action=register">
    <label>Login: 
        <input type="text" name="login" required>
    </label><br>

    <label>Hasło: 
        <input type="password" name="password" required>
    </label><br>

    <label>Potwierdź hasło: 
        <input type="password" name="confirm" required>
    </label><br>

    <label>Imię i nazwisko: 
        <input type="text" name="name" required>
    </label><br>

    <label>Email: 
        <input type="email" name="email" required>
    </label><br>

    <label>Numer telefonu: 
        <input type="text" name="phone">
    </label><br>

    <label>Adres: 
        <input type="text" name="address">
    </label><br>

    <button type="submit">Zarejestruj się</button>
</form>
