<h1>Lista produktów</h1>
<table>
    <tr><th width="100">Zdjęcie</th><th>Nazwa</th><th>Cena</th><th>Dostępność</th><th></th></tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?php if (!empty($product['photo'])): ?>
                <img src="<?= htmlspecialchars($product['photo']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="100">
            <?php else: ?>
                Brak zdjęcia
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($product['name']); ?></td>
        <td><?= number_format($product['price'],2); ?> PLN</td>
        <td>
            <?= $product['available'] ? 'Dostępny' : '<span style="color:red;">Niedostępny</span>' ?>
        </td>
        <td>
            <?php if ($product['available']): ?>
                <form method="post" action="index.php?controller=basket&action=add&id=<?= $product['id']; ?>">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit">Dodaj do koszyka</button>
                </form>
            <?php else: ?>
                <button disabled>Brak w magazynie</button>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- PAGINACJA -->
<?php if ($totalPages > 1): ?>
<div style="margin-top:20px;">
    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
        <?php if ($p == $page): ?>
            <strong><?= $p ?></strong>
        <?php else: ?>
            <a href="index.php?controller=product&action=index&page=<?= $p ?>"><?= $p ?></a>
        <?php endif; ?>
        &nbsp;
    <?php endfor; ?>
</div>
<?php endif; ?>
