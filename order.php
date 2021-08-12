<?php

require_once 'common.php';

/**
 * Select ordered products and order details
 */
$order = 'SELECT products.title,products.image,products.price,order.order_id,order.name,order.email,order.total_price FROM `products`  
          JOIN `order_product` ON products.id = order_product.product_id 
          JOIN `order` ON order.order_id = order_product.order_id
          WHERE order_product.order_id = ? AND order.order_id = ?';

$stmt = mysqli_prepare($connectDb, $order);

mysqli_stmt_bind_param($stmt , 'ss', $_GET['id'], $_GET['id']);

mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
$product = mysqli_stmt_get_result($stmt);

mysqli_stmt_close($stmt);

require_once 'header.php';
?>
    <h1><?= sanitize(translate('Order Details')) ?></h1>
    <table border="1">
        <thead>
            <tr>
                <th><?= sanitize(translate('Product Image')) ?></th>
                <th><?= sanitize(translate('Product Title')) ?></th>
                <th><?= sanitize(translate('Product Price')) ?></th>
                <th><h3><?= sanitize(translate('Total Price')) ?></h3></th>
            </tr>
        </thead>
        <tbody>
        <!--- Display ordered products --->
        <?php while($item = mysqli_fetch_array($product)): ?>
            <tr>
                <td><img src='<?= sanitize($item['image']); ?>' class='img' alt=''/></td>
                <td><p><?= sanitize($item['title']) ?></p></td>
                <td><p><?= sanitize($item['price']) ?></p></td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <td><h3><?= sanitize(translate('Order ID')) ?></h3></td>
            <td><h3><?= sanitize(translate('Customer Name')) ?></h3></td>
            <td><h3><?= sanitize(translate('Customer Email')) ?></h3></td>
        </tr>
        <!--- Display order details --->
       <?php foreach($product as $details): ?>
        <tr>
            <td><?= sanitize($details['order_id']) ?></td>
            <td><?= sanitize($details['name']) ?></td>
            <td><?= sanitize($details['email']) ?></td>
            <td><?= sanitize($details['total_price']) ?></td>
        </tr>
       <?php
            break;
            endforeach;
       ?>

        </tbody>
    </table><br/>
    <a href='orders.php'><?= sanitize(translate('Go to orders')) ?></a>
<?php require_once 'footer.php'; ?>
