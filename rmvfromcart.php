<?php

include "common.php";

if (isset($_GET['remove'])) {
    $key = array_search($_GET['remove'], $_SESSION['cart']);
    if (is_numeric($key)) {
        unset($_SESSION['cart'][$key]);
    }
}

header('Location: cart.php');
