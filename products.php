<?php

require_once 'common.php';

checkLogin();

$pageTitle = translate('Products');

/**
 * Delete product from tabel
 */
if (isset($_GET['delete'])) {
    $delete = "DELETE FROM `products` WHERE id = ?";
    $stmt = mysqli_prepare($connectDb, $delete);

    mysqli_stmt_bind_param($stmt, 's', $_GET['delete']);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: products.php');
}

/**
 * Select all products from products tabel
 */
$selectProducts = 'SELECT id,title,image,price FROM products ';
$result = mysqli_query($connectDb, $selectProducts);

require_once 'header.php';
?>
    <form action='product.php' method='POST'>
        <h1><?= sanitize(translate('All Products')) ?></h1>
            <table border="1">
                <thead>
                    <tr>
                        <th><?= sanitize(translate('Image')) ?></th>
                        <th><?= sanitize(translate('Title')) ?></th>
                        <th><?= sanitize(translate('Price')) ?></th>
                        <th><?= sanitize(translate('Delete Product')) ?></th>
                        <th><?= sanitize(translate('Update Product')) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = mysqli_fetch_array($result)) : ?>
                        <tr>
                            <td><img src='<?= sanitize($product['image']); ?>' class='img' alt=''/></td>
                            <td><p><?= sanitize($product['title']) ?></p></td>
                            <td><p><?= sanitize($product['price']) ?></p></td>
                            <td><a href='products.php?delete=<?= $product['id'] ?>'><?= sanitize(translate('Delete Product')) ?></a></td>
                            <td><a href='product.php?update=<?= $product['id'] ?>'><?= sanitize(translate('Update Product')) ?></a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table><br/>
        <button type="submit" name="addProduct"><?= sanitize(translate('Add Product')) ?></button>
    </form>
<?php require_once 'footer.php'; ?>
