<h1>Moje zamówienia</h1>
<?php if (empty($orders)): ?>
    <p>Nie masz jeszcze zamówień.</p>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <h3>Zamówienie #<?= $order['id']; ?></h3>
        <p>
            <strong>Data zamówienia:</strong> <?= $order['date_of_order']; ?><br>
            <strong>Data wysyłki:</strong> <?= $order['date_of_shipping'] ?? '–'; ?><br>
            <strong>Data dostawy:</strong> <?= $order['date_of_delivery'] ?? '–'; ?><br>
            <strong>Status:</strong> <?= htmlspecialchars($order['status']); ?>
        </p>
        <table border="1" cellpadding="5">
            <tr><th>Nazwa</th><th>Ilość</th><th>Cena</th></tr>
            <?php foreach ($order['items'] as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']); ?></td>
                <td><?= $item['quantity']; ?></td>
                <td><?= number_format($item['price'] * $item['quantity'],2); ?> PLN</td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p><strong>Łącznie:</strong> 
            <?php 
            $total = 0;
            foreach ($order['items'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            echo number_format($total, 2);
            ?> PLN
        </p>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>
