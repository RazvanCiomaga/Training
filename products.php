<?php

require_once 'common.php';

$pageTitle = 'Products';

require_once 'header.php';
?>
<body>
    <?php if($_SESSION['login']): ?>
        <?php
            $selectProducts = 'SELECT title,image,description,price FROM products ';
            $result = mysqli_query($connectDb, $selectProducts);
        ?>
        <h1><?= sanitize(translate('All Products')) ?></h1>
        <table border="1">
            <thead>
                <tr>
                    <th><?= sanitize(translate('Title')) ?></th>
                    <th><?= sanitize(translate('Image')) ?></th>
                    <th><?= sanitize(translate('Description')) ?></th>
                    <th><?= sanitize(translate('Price')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_array($result)) : ?>
                    <tr>
                        <td><p><?= sanitize($product['title']) ?></p></td>
                        <td><img src='<?= sanitize($product['image']); ?>' class='img' alt=''/></td>
                        <td><p><?= sanitize($product['description']) ?></p></td>
                        <td><p><?= sanitize($product['price']) ?></p></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php
        else:
            die;
        endif;
    ?>
</body>
<?php require_once 'footer.php'; ?>

