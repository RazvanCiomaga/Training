<?php

include "common.php";

if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    $id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $value) {
        if($key == $id) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

header('Location: cart.php');