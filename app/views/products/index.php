<h1>Lista produktów</h1>

<form method="get" action="index.php">
    <input type="hidden" name="controller" value="product">
    <input type="hidden" name="action" value="index">

    <label>Szukaj:
        <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </label>

    <label>Kategoria:
        <select name="category">
            <option value="">-- wszystkie --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>" <?= ($cat === ($_GET['category'] ?? '')) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <button type="submit">Filtruj</button>
</form>

<table>
    <tr>
        <th width="100">Zdjęcie</th>
        <th>
            <a href="?controller=product&action=index&<?= http_build_query(array_merge($_GET,['sort'=>'name','order'=>($_GET['order']??'asc')==='asc'?'desc':'asc'])) ?>">
                Nazwa
            </a>
        </th>
        <th>Kategoria</th>
        <th>
            <a href="?controller=product&action=index&<?= http_build_query(array_merge($_GET,['sort'=>'price','order'=>($_GET['order']??'asc')==='asc'?'desc':'asc'])) ?>">
                Cena
            </a>
        </th>
        <th>Dostępność</th>
        <th></th>
    </tr>

    <?php foreach ($products as $product): ?>
    <tr>
        <td>
            <?php if (!empty($product['photo'])): ?>
                <img src="<?= htmlspecialchars($product['photo']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="100">
            <?php else: ?>
                Brak zdjęcia
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($product['name']); ?></td>
        <td><?= htmlspecialchars($product['category']); ?></td>
        <td><?= number_format($product['price'],2); ?> PLN</td>
        <td><?= $product['available'] ? 'Dostępny' : '<span style="color:red;">Niedostępny</span>' ?></td>
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
            <a href="index.php?controller=product&action=index&page=<?= $p ?>&<?= http_build_query($_GET) ?>"><?= $p ?></a>
        <?php endif; ?>
        &nbsp;
    <?php endfor; ?>
</div>
<?php endif; ?>
