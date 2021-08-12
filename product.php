<?php

require_once 'common.php';

checkLogin();

$pageTitle = translate('Add/Edit Product');

if (isset($_POST['add']) || isset($_POST['update']) ){
    $titleErr = '';
    $imageErr = '';
    $priceErr = '';
    $numericErr = '';
    $imageExist = '';
    $extensionErr = '';

    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageFolder = "images/";
    $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
    $extension = ['jpg','jpeg','png'];

    $productTitle = $_POST['title'];
    $productPrice = $_POST['price'];

    /**
     * Validate form and inserting/updating new product in products table if it's valid
     * Create an error message if not
     */
    if (!empty($productTitle) && !empty($imageName) && !empty($productPrice) && is_numeric($productPrice) && in_array($imageExtension, $extension)) {
        $insertedImage = $imageFolder.$imageName;

        if (isset($_POST['add'])) {
            $insertProduct = "INSERT INTO products (title,image,price) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connectDb, $insertProduct);

            mysqli_stmt_bind_param($stmt, 'sss', $productTitle, $insertedImage, $productPrice);

            if (mysqli_stmt_execute($stmt)) {
                $lastId = mysqli_insert_id($connectDb);
            }

            mysqli_stmt_close($stmt);

        } else if (isset($_POST['update'])) {
            $updateProduct = "UPDATE products SET title = ? , image = ? , price = ? WHERE id = ?";
            $stmt = mysqli_prepare($connectDb, $updateProduct);

            $lastId = $_GET['update'];

            mysqli_stmt_bind_param($stmt, 'ssss', $productTitle, $insertedImage, $productPrice, $_GET['update']);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
        }

        /**
         * Set image name same as product id
         */
        $query = 'UPDATE `products` SET image = ? WHERE id = ?';
        $stmt = mysqli_prepare($connectDb, $query);

        $newName = 'images/'.$lastId.'.'.$imageExtension;
        move_uploaded_file($imageTmpName, $newName);

        mysqli_stmt_bind_param($stmt, 'ss', $newName, $lastId);

        mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));

        mysqli_stmt_close($stmt);

        header('Location: products.php');

    }  else {
        if (empty($productTitle)) {
            $titleErr = translate('Title field required');
        }

        if (empty($imageName)) {
            $imageErr = translate('Image field required');
        }

        if (empty($productPrice)) {
            $priceErr = translate('Price field required');
        }

        if (!is_numeric($productPrice)) {
            $numericErr = translate('Price must be numeric');
        }

        if (!in_array($imageExtension, $extension)) {
            $extensionErr = translate('File extension must be .jpg, .jpeg or .png');
        }
    }
}

require_once 'header.php';
?>
    <h1><?= sanitize(translate('Add product details')) ?></h1>

    <form action="product.php?update=<?= sanitize($_GET['update']); ?>" enctype='multipart/form-data' method="POST">
        <label for="title"><?= sanitize(translate('Product Title:')) ?></label><br/>
        <input type="text" name="title" id="title" /><br/>
        <?php if(!empty($titleErr)): ?>
            <p style="color: red;"><?= sanitize($titleErr) ?></p>
        <?php endif; ?><br/>

        <label for="image"><?= sanitize(translate('Product Image:')) ?></label><br/>
        <input type="file" name="image" id="image" /><br/>
        <?php if(!empty($imageErr)): ?>
            <p style="color: red;"><?= sanitize($imageErr) ?></p>
        <?php endif; ?><br/>

        <?php if(!empty($imageExist)): ?>
            <p style="color: red;"><?= sanitize($imageExist) ?></p>
        <?php endif; ?><br/>

        <?php if(!empty($extensionErr)): ?>
            <p style="color: red;"><?= sanitize($extensionErr) ?></p>
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
