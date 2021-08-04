<?php

require_once "config.php";

$connect = mysqli_connect($serverName,$username,$password);

if (!$connect) { die("Connection failed: ". mysqli_connect_error()); }

$createDb = "CREATE DATABASE training";
if (mysqli_query($connect,$createDb)) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($connect);
}

mysqli_close($connect);
?>

