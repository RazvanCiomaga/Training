<?php

require_once 'common.php';

$selectOrder = 'SELECT * FROM `order`';
$query = mysqli_query($connectDb, $selectOrder);

require_once 'header.php';
?>
    <h1><?= sanitize(translate('All orders')) ?></h1>
    <table border="1">
        <thead>
            <tr>
                <th><?= sanitize(translate('Order ID')) ?></th>
                <th><?= sanitize(translate('Customer Name')) ?></th>
                <th><?= sanitize(translate('Customer Email')) ?></th>
                <th><?= sanitize(translate('Total Price')) ?></th>
                <th><?= sanitize(translate('Checkout Details')) ?></th>
            </tr>
        </thead>
        <tbody>
        <?php while($order = mysqli_fetch_array($query)): ?>
            <tr>
                <td><?= sanitize($order['order_id']) ?></td>
                <td><?= sanitize($order['name']) ?></td>
                <td><?= sanitize($order['email']) ?></td>
                <td><?= sanitize($order['total_price']) ?></td>
                <td><a href="order.php?id=<?= sanitize($order['order_id']) ?>"><?= sanitize(translate('Go to order details')) ?></a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php require_once 'footer.php' ?>
