<?php

include "common.php";
include "header.php";

?>
<body>
    <h1><?= sanitize(translate("Products in cart")) ?></h1>
    <table border="1">
        <thead>
            <th><?= sanitize(translate("ID")) ?></th>
            <th><?= sanitize(translate("Title")) ?></th>
            <th><?= sanitize(translate("Price")) ?></th>
            <th><?= sanitize(translate("Remove")) ?></th>
        </thead>
        <tbody>
            <?php
                $items = $_SESSION['cart'];
                $cartItems = explode(",", $items);
            ?>
            <?php foreach ($cartItems as $key => $id) : ?>
            <?php
                $select = "SELECT * FROM products WHERE id=$id";
                $result = mysqli_query($connectDb,$select);
                $item = mysqli_fetch_array($result);
            ?>
            <tr>
                <td><p><?= sanitize($item["id"]) ?></p></td>
                <td><p><?= sanitize($item["title"]) ?></p></td>
                <td><p><?= sanitize($item["price"]) ?></p></td>
                <td><a href="rmvfromcart.php?remove=<?= sanitize($key) ?>"><?= sanitize(translate('Remove item')) ?></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</body>


<?php include "footer.php" ?>