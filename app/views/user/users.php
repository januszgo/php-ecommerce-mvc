<h1>Lista użytkowników</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Login</th>
        <th>Imię</th>
        <th>Email</th>
        <th>Telefon</th>
        <th>Adres</th>
    </tr>
    <?php foreach ($allUsers as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['login']) ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
        <td><?= htmlspecialchars($user['address'] ?? '-') ?></td>
    </tr>
    <?php endforeach; ?>
</table>
