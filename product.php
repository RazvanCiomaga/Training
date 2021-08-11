<?php

require_once 'common.php';

checkLogin();

$pageTitle = translate('Add/Edit Product');

if (isset($_POST['add']) || isset($_POST['update']) ){
    $titleErr = '';
    $imageErr = '';
    $priceErr = '';
    $numericErr = '';
    $productTitle = $_POST['title'];
    $productImage = $_POST['image'];
    $productPrice = $_POST['price'];

    /**
     * Validate form and inserting/updating new product in products table if it's valid
     * Create an error message if not
     */
    if (!empty($productTitle) && !empty($productImage) && !empty($productPrice) && is_numeric($productPrice)) {
        /**
         * Insert
         */
        if (isset($_POST['add'])) {
            $insertProduct = "INSERT INTO products (title,image,price) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connectDb, $insertProduct);

            mysqli_stmt_bind_param($stmt, 'sss', $productTitle, $productImage, $productPrice);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

        } else if (isset($_POST['update'])) {
            $updateProduct = "UPDATE products SET title = ? , image = ? , price = ? WHERE id = ?";
            $stmt = mysqli_prepare($connectDb, $updateProduct);

            mysqli_stmt_bind_param($stmt, 'ssss', $productTitle, $productImage, $productPrice, $_GET['update']);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
        }

        header('Location: products.php');

    }  else {
            if (empty($productTitle)) {
                $titleErr = translate('Title field required');
            }

            if (empty($productImage)) {
                $imageErr = translate('Image field required');
            }

            if (empty($productPrice)) {
                $priceErr = translate('Price field required');
            }

            if (!is_numeric($productPrice)) {
                $numericErr = translate('Price must be numeric');
            }

        }
}

require_once 'header.php';
?>
    <h1><?= sanitize(translate('Add product details')) ?></h1>

    <form action="product.php?update=<?= sanitize($_GET['update']); ?>" method="POST">
        <label for="title"><?= sanitize(translate('Product Title:')) ?></label><br/>
        <input type="text" name="title" id="title" /><br/>
        <?php if(!empty($titleErr)): ?>
            <p style="color: red;"><?= sanitize($titleErr) ?></p>
        <?php endif; ?><br/>

        <label for="image"><?= sanitize(translate('Product Image:')) ?></label><br/>
        <input type="text" name="image" id="image" /><br/>
        <?php if(!empty($imageErr)): ?>
            <p style="color: red;"><?= sanitize($imageErr) ?></p>
        <?php endif; ?><br/>

        <label for="price"><?= sanitize(translate('Product Price:')) ?></label><br/>
        <input type="text" name="price" id="price" /><br/>
        <?php if(!empty($priceErr)): ?>
            <p style="color: red;"><?= sanitize($priceErr) ?></p>
        <?php endif; ?><br/>

        <?php if(!empty($numericErr)): ?>
            <p style="color: red;"><?= sanitize($numericErr) ?></p>
        <?php endif; ?><br/>

        <button type="submit" name="add" formaction="product.php"><?= sanitize(translate('Add')) ?></button>

        <button type="submit" name="update"><?= sanitize(translate('Update')) ?></button>
    </form>
<?php require_once 'footer.php'; ?>
