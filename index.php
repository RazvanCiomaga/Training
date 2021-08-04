<?php

include "common.php";

if (isset($_SESSION['cart']) && isset($_GET['id'])) {
    $_SESSION['cart'][] = $_GET['id'];
}

include "header.php";


?>

<body>
    <h1><?= sanitize(translate("Products Page")) ?></h1>
    <div class="container">
        <?php
            $select ="SELECT * FROM products WHERE id NOT IN(".($_SESSION['cart'] ? implode(",", $_SESSION['cart']) : '0').")";
            $result = mysqli_query($connectDb, $select);
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th><?= sanitize(translate("ID")) ?></th>
                    <th><?= sanitize(translate("Image")) ?></th>
                    <th><?= sanitize(translate("Title")) ?></th>
                    <th><?= sanitize(translate("Description")) ?></th>
                    <th><?= sanitize(translate("Price")) ?></th>
                    <th><?= sanitize(translate("Add to cart")) ?></th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_array($result)) : ?>
                <tr>
                    <td><p><?= sanitize($row["id"]) ?></p></td>
                    <td><img src="<?= sanitize($row["image"]); ?>" class="img" /></td>
                    <td><h2><?= sanitize($row["title"]) ?></h2></td>
                    <td><p><?= sanitize($row["description"]) ?></p></td>
                    <td><h4><?= sanitize($row["price"]) ?></h4></td>
                    <td><a href="index.php?id=<?= sanitize($row["id"]) ?>"><?= sanitize(translate("Add to Cart")) ?></a></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

<?php

include "footer.php";

?>



