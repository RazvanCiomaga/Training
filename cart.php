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
            $select ="SELECT * FROM products WHERE id IN (".($_SESSION['cart'] ? implode(",", $_SESSION['cart']) : '0').")";
            $result = mysqli_query($connectDb, $select);
        ?>
        <?php while ($item= mysqli_fetch_array($result)) : ?>
            <tr>
                <td><p><?= sanitize($item["id"]) ?></p></td>
                <td><p><?= sanitize($item["title"]) ?></p></td>
                <td><p><?= sanitize($item["price"]) ?></p></td>
                <td><a href="rmvfromcart.php?remove=<?= sanitize($item['id']) ?>"><?= sanitize(translate('Remove item')) ?></a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>

    </table>
</body>


<?php include "footer.php" ?>