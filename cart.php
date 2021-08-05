<?php

include 'common.php';

if (isset($_GET['remove'])) {
    $key = array_search($_GET['remove'], $_SESSION['cart']);
    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
    }

    header('Location: cart.php');
    die;
}

include 'header.php';
?>
<body>
    <h1><?= sanitize(translate('Products in cart')) ?></h1>
    <table border='1'>
        <thead>
        <tr>
            <th><?= sanitize(translate('ID')) ?></th>
            <th><?= sanitize(translate('Title')) ?></th>
            <th><?= sanitize(translate('Price')) ?></th>
            <th><?= sanitize(translate('Remove')) ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $param = $_SESSION['cart'] ? str_repeat('?,', count($_SESSION['cart']) - 1) . '?' : '0';
            $select ='SELECT * FROM products WHERE id IN ($param)';

            $stmt = mysqli_prepare($connectDb, $select);
            $types = str_repeat('s', count($_SESSION['cart']));
            if (!empty($_SESSION['cart'])) {
                mysqli_stmt_bind_param($stmt, $types, ...$_SESSION['cart']);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        ?>
        <?php while ($item = mysqli_fetch_array($result)) : ?>
            <tr>
                <td><p><?= sanitize($item['id']) ?></p></td>
                <td><img src='<?= sanitize($item['image']); ?>' class='img' alt=''/></td>
                <td><p><?= sanitize($item['title']) ?></p></td>
                <td><p><?= sanitize($item['price']) ?></p></td>
                <td><a href='cart.php?remove=<?= sanitize($item['id']) ?>'><?= sanitize(translate('Remove item')) ?></a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <hr/>
    <form action='cart.php' method='POST'>
        <p><?= sanitize(translate('Send an email')) ?></p> <br/>
        <input type='text' name='name' placeholder='Full name' /> <br/><br/>
        <input type='email' name='mail' placeholder='Your email' /> <br/><br/>
        <input type='text' name='subject' placeholder='Subject' /> <br/><br/>
        <textarea name='message' placeholder='Comments'></textarea> <br/><br/>
        <a href='index.php'><?= sanitize(translate('Go to index')) ?></a>
        <button type='submit' name='submit'><?= sanitize(translate('Checkout')) ?></button>
    </form>
</body>

<?php include 'footer.php' ?>