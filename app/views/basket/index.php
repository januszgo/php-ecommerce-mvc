<h1>Koszyk</h1>
<?php if (empty($items)): ?>
    <p>Koszyk jest pusty.</p>
<?php else: ?>
<form method="post" action="index.php?controller=basket&action=updateAmount">
<table>
    <tr><th width="120">Zdjęcie</th><th>Produkt</th><th>Ilość</th><th>Cena</th><th></th></tr>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><?php if (!empty($item['photo'])): ?>
                <img src="<?= htmlspecialchars($item['photo']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="100">
            <?php else: ?>
                Brak zdjęcia
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($item['name']); ?></td>
        <td>
            <input type="number" name="quantities[<?= $item['id'] ?>]" 
                   value="<?= $item['qty'] ?>" min="1" max="<?= $item['amount'] ?>">
        </td>
        <td><?= number_format($item['price'] * $item['qty'],2); ?> PLN</td>
        <td>
            <a href="index.php?controller=basket&action=remove&id=<?= $item['id'] ?>">Usuń</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<button type="submit">Aktualizuj koszyk</button>
</form>

<p><strong>Razem:</strong>
<?php 
$total = 0;
foreach ($items as $item) { $total += $item['price'] * $item['qty']; }
echo number_format($total,2); ?> PLN
</p>
<?php if (isset($_SESSION['user_id'])): ?>
    <a href="index.php?controller=order&action=create">Złóż zamówienie</a>
<?php else: ?>
    <p>
        <a href="index.php?controller=user&action=login">Zaloguj się</a>
        aby złożyć zamówienie.
    </p>
<?php endif; ?>
<p><a href="index.php?controller=basket&action=clear">Wyczyść koszyk</a></p>
<?php endif; ?>
