<?php

/***
 * Setting up an page title
 */
$pageTitle = '';

/**
 * Starting a working session
 */
session_start();

/**
 * creating session cart array
 */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/**
 * Create images array
 */
if (!isset($_SESSION['images'])) {
    $_SESSION['images'] = [];
}


/***
 * create a variable to check if customer is logged in
 */
if(!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

/**
 * Function that check if user is logged in
 */
function checkLogin() {
    if (!$_SESSION['login']) {
        header('Location: login.php');
        die;
    }
}

require_once 'config.php';

/**
 * Connect to database
 */
$connectDb = mysqli_connect(Server_Name, Username, Password, Database_Name);
if (!$connectDb) {
    die('Connection failed: ' . mysqli_connect_error());
}

/**
 * Function to translate a label
 *
 * @param $text
 * @return mixed|string
 */
function translate($text) {
    $translations = [
        'Products Page' => 'Pagina Produs'
    ];

    return isset($translations[$text]) ? $translations[$text] : $text;
}

/**
 * Function to sanitize against XSS
 *
 * @param $string
 * @return string
 */
function sanitize($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}



