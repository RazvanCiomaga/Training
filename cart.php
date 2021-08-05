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
            $param = $_SESSION['cart'] ? str_repeat("?,", count($_SESSION['cart']) - 1) . '?' : '0';
            $select ="SELECT * FROM products WHERE id IN ($param)";
            $stmt = mysqli_prepare($connectDb, $select);
            $types = str_repeat('s', count($_SESSION['cart']));
            mysqli_stmt_bind_param($stmt, $types, ...$_SESSION['cart']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        ?>
        <?php while ($item= mysqli_fetch_array($result)) : ?>
            <tr>
                <td><p><?= sanitize($item["id"]) ?></p></td>
                <td><img src="<?= sanitize($item["image"]); ?>" class="img" /></td>
                <td><p><?= sanitize($item["title"]) ?></p></td>
                <td><p><?= sanitize($item["price"]) ?></p></td>
                <td><a href="rmvfromcart.php?remove=<?= sanitize($item['id']) ?>"><?= sanitize(translate('Remove item')) ?></a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>


<?php include "footer.php" ?>