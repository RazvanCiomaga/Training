<?php

include "common.php";

$items = $_SESSION['cart'];
$cartItems = explode(",", $items);
if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    $remove = $_GET['remove'];
    unset($cartItems[$remove]);
    $itemIds = implode(",", $cartItems);
    $_SESSION['cart'] = $itemIds;
}

header('Location: cart.php');