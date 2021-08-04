<?php

require_once "common.php";


if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $items = $_SESSION['cart'];
    $cartItems = explode(",", $items);
    $items .= "," . $_GET['id'];
    $_SESSION['cart'] = $items;
    header('location: index.php?status=success');
} else {
    $items = $_GET['id'];
    $_SESSION['cart'] = $items;
    header('location: index.php?status=success');
}
if (in_array($_GET['id'], $cartItems)) {
    header('location: index.php?status=incart');
} /*else {
    $items .= "," . $_GET['id'];
    $_SESSION['cart'] = $items;
    header('location: index.php?status=success');
}*/

