<?php

include 'common.php';

if (isset($_SESSION['cart']) && isset($_GET['id'])) {
    if (!in_array($_GET['id'], $_SESSION['cart'])) {
        $_SESSION['cart'][] = $_GET['id'];
    }

    header('location: index.php');
    die;
}

include 'header.php';
?>
<body>
    <h1><?= sanitize(translate('Products Page')) ?></h1>
    <div class='container'>
        <?php
            $param = $_SESSION['cart'] ? str_repeat('?,', count($_SESSION['cart']) - 1) . '?' : '0';
            $select ="SELECT * FROM products WHERE id NOT IN ($param)";

            $stmt = mysqli_prepare($connectDb, $select);
            $types = str_repeat('s', count($_SESSION['cart']));
            if (!empty($_SESSION['cart'])) {
                mysqli_stmt_bind_param($stmt, $types, ...$_SESSION['cart']);
            }
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        ?>
        <table border='1'>
            <thead>
                <tr>
                    <th><?= sanitize(translate('ID')) ?></th>
                    <th><?= sanitize(translate('Image')) ?></th>
                    <th><?= sanitize(translate('Title')) ?></th>
                    <th><?= sanitize(translate('Description')) ?></th>
                    <th><?= sanitize(translate('Price')) ?></th>
                    <th><?= sanitize(translate('Add to cart')) ?></th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_array($result)) : ?>
                <tr>
                    <td><p><?= sanitize($row['id']) ?></p></td>
                    <td><img src='<?= sanitize($row['image']); ?>' class='img' /></td>
                    <td><h2><?= sanitize($row['title']) ?></h2></td>
                    <td><p><?= sanitize($row['description']) ?></p></td>
                    <td><h4><?= sanitize($row['price']) ?></h4></td>
                    <td><a href='index.php?id=<?= sanitize($row['id']) ?>'><?= sanitize(translate('Add to Cart')) ?></a></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

<?php include 'footer.php' ?>



