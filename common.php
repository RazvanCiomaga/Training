<?php

/**
 * Starting a working session
 */
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

require_once "config.php";

/**
 * Connect to database
 */
$connectDb = mysqli_connect(serverName,username,password,dbName );
if (!$connectDb) {
    die("Connection failed: " . mysqli_connect_error());
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


