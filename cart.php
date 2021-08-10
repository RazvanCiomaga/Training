<?php

include 'common.php';

$pageTitle = 'Cart';

if (isset($_GET['remove'])) {
    $key = array_search($_GET['remove'], $_SESSION['cart']);
    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
    }

    header('Location: cart.php');
    die;
}

if (isset($_POST['submit'])) {
    $totalPrice = 0;
    $nameError = '';
    $contentError = '';
    $mailError = '';
    $customerMail = $_POST['mail'];
    $customerName = $_POST['name'];
    $mailContent = $_POST['message'];
    $subject = $_POST['subject'];
    $checkMail = filter_var($customerMail,FILTER_VALIDATE_EMAIL);
    $checkName = preg_match("/^[a-zA-Z-' ]*$/", $customerName);

    if ($checkMail && $checkName && !empty($mailContent)) {
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $param = $_SESSION['cart'] ? str_repeat('?,', count($_SESSION['cart']) - 1) . '?' : '0';
            $select ="SELECT * FROM products WHERE id IN ($param)";

            $stmt = mysqli_prepare($connectDb, $select);
            $types = str_repeat('s', count($_SESSION['cart']));

            mysqli_stmt_bind_param($stmt, $types, ...$_SESSION['cart']);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $insertOrder = "INSERT INTO `order` (total_price, name , email) VALUES (".$_SESSION['totalPrice'].", '$customerName', '$customerMail')";
            if (mysqli_query($connectDb, $insertOrder)) {
                $lastId = mysqli_insert_id($connectDb);
            }

            while ($item = mysqli_fetch_array($result)) {
                $orderProduct = "INSERT INTO `order_product` (order_id, product_id) VALUES ('$lastId', ".$item['id'].")";
                mysqli_query($connectDb, $orderProduct);
            }

            $txt = "<html>
                    <head>
                        <title><?= translate(Products added to cart) >?</title>
                    </head>
                    <body>
                        <table border='1'>
                            <thead>
                            <tr>
                                <th><?= sanitize(translate('Image')) ?></th>
                                <th><?= sanitize(translate('Title')) ?></th>
                                <th><?= sanitize(translate('Description')) ?></th>
                                <th><?= sanitize(translate('Price')) ?></th>
                                <th><?= sanitize(translate('Remove')) ?></th>
                            </tr>
                            </thead>
                            <tbody> ";

            while ($item = mysqli_fetch_array($result)) {
                $txt .= "<td><img src='".sanitize($item['image'])."' class='img' alt=''/></td>
                                 <td><p>".sanitize($item['title'])."</p></td>
                                 <td><p>".sanitize($item['description'])."</p></td>
                                 <td><p>".sanitize($item['price'])."</p></td> ";
            }

            $txt .= "       </tbody>
                        </table>
                    </body>
                    </html>";

            unset($_SESSION['cart']);
        }

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: ".$customerMail;
        $txt .= "\n"."You have received an email from ".$customerName.".\n\n".$mailContent;

        mail(shopManager, $subject, $txt, $headers);
        header("Location: cart.php");
    }

    if (!$checkName || empty($customerName)) {
        $nameError = "Required field!Only letters and white space allowed.";
    }

    if (!$checkMail) {
        $mailError = 'Please enter an valid mail!' ;
    }

    if (empty($mailContent)) {
        $contentError = 'Please enter an message!';
    }
}


include 'header.php';
?>
<body>
    <h1><?= sanitize(translate('Products in cart')) ?></h1>
    <?php if ($_SESSION['login']): ?>
        <form action='cart.php' method='POST'>
            <table border='1'>
                <thead>
                <tr>
                    <th><?= sanitize(translate('Image')) ?></th>
                    <th><?= sanitize(translate('Title')) ?></th>
                    <th><?= sanitize(translate('Description')) ?></th>
                    <th><?= sanitize(translate('Price')) ?></th>
                    <th><?= sanitize(translate('Remove')) ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $_SESSION['totalPrice'] = 0;

                    $param = $_SESSION['cart'] ? str_repeat('?,', count($_SESSION['cart']) - 1) . '?' : '0';
                    $select ="SELECT * FROM products WHERE id IN ($param)";

                    $stmt = mysqli_prepare($connectDb, $select);
                    $types = str_repeat('s', count($_SESSION['cart']));

                    if (!empty($_SESSION['cart'])) {
                        mysqli_stmt_bind_param($stmt, $types, ...$_SESSION['cart']);
                    }

                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                ?>
                <?php while ($item = mysqli_fetch_array($result)) : ?>
                    <?php $_SESSION['totalPrice'] += (float)$item['price']; ?>
                    <tr>
                        <td><img src='<?= sanitize($item['image']); ?>' class='img' alt=''/></td>
                        <td><p><?= sanitize($item['title']) ?></p></td>
                        <td><p><?= sanitize($item['description']) ?></p></td>
                        <td><p><?= sanitize($item['price']) ?></p></td>
                        <td><a href='cart.php?remove=<?= sanitize($item['id']) ?>'><?= sanitize(translate('Remove item')) ?></a></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <hr/>
            <h2><?= sanitize(translate('Send an email')) ?></h2> <br/>
            <input type='text' name='name' placeholder='Full name' /> <br/>
            <?php if(!empty($nameError)) : ?>
                <p style="color: red;"><?= $nameError ?></p>
            <?php endif; ?><br/>
            <input type='email' name='mail' placeholder='Your email' /> <br/>
            <?php if(!empty($mailError)) : ?>
                <p style="color: red;"><?= $mailError ?></p>
            <?php endif; ?><br/>
            <input type='text' name='subject' placeholder='Subject' /> <br/><br/>
            <textarea name='message' placeholder='Comments'></textarea>
            <?php if(!empty($contentError)) : ?>
                <p style="color: red;"><?= $contentError?></p>
            <?php endif; ?><br/>
            <a href='index.php'><?= sanitize(translate('Go to index')) ?></a>
            <button type='submit' name='submit'><?= sanitize(translate('Checkout')) ?></button>
        </form>
    <?php
        else:
            header('Location: login.php');
        endif;
    ?>
</body>
<?php include 'footer.php' ?>