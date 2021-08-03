<?php

require_once "config.php";
$connectDb = mysqli_connect($serverName,$username,$password,$dbName);
if (!$connectDb) { die("Connection failed: " . mysqli_connect_error()); }

?>