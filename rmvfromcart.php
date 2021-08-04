<?php

include "common.php";


if (isset($_GET['remove']) && !empty($_GET['remove'])) {

    unset($_SESSION['cart'][$_GET['remove']]);
}

header('Location: cart.php');