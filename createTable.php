<?php

require_once "config.php";
require_once "connectDatabase.php";

$createTable ="CREATE TABLE products (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(30) NOT NULL,
image text NOT NULL,
description VARCHAR(650) NOT NULL,
price VARCHAR(50) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($connectDb,$createTable)){
    echo "Table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($connectDb);
}

 $insertProducts = "INSERT INTO products (title,image,description,price) VALUES
('Apple Watch 7','images/apple-watch-7.jpg','Apple Watch is a wearable smartwatch that allows users to accomplish a variety of tasks, including making phone calls, sending text messages and reading email','520 EURO'
);";
$insertProducts .= "INSERT INTO products (title,image,description,price) VALUES ('Beats by Dre Solo3','images/beats-by-dre-solo3.jfif','Comprising a pair of Bluetooth wireless on-ear headphones styled in black, the Beats by Dr. Dre Beats Solo3 can provide up to 40 hours off a single charge','150 EURO');";
$insertProducts .= "INSERT INTO products (title,image,description,price) VALUES ('Apple Ipod 7','images/apple-ipod-7.jpg','For the number of apps you get with iOS 12, it feels like good value for money – especially when you compare it to the cost of an iPhone.','250 EURO');";
$insertProducts .= "INSERT INTO products (title,image,description,price) VALUES ('Samsung Galaxy Watch 3','images/galaxy-watch-3.jpg','The Samsung Galaxy Watch 3 brings a rotating bezel, ECG monitoring and fall detection right to your wrist. It is the best Android lifestyle smartwatch you can get now.','350 EURO
');";
$insertProducts .= "INSERT INTO products (title,image,description,price) VALUES ('Fitbit Charge 4','images/fitbit-4.jpg','The Charge 4 tracks your steps, distance, floors climbed, calories burned, and Active Zone Minutes, a new metric earned for time spent in fat burn, cardio, or peak heart rate zone.','120 EURO');";
$insertProducts .= "INSERT INTO products (title,image,description,price) VALUES ('Airpods Pro','images/airpods-pro.jpg','AirPods Pro have been designed to deliver Active Noise Cancellation for immersive sound, Transparency mode so you can hear your surroundings, and a customizable fit for all-day comfort.','220 EURO');";


if(mysqli_multi_query($connectDb,$insertProducts)){
    echo "<br>.New insert has been done.";
} else {
    echo "<br>"."Error: ".$insertProducts.mysqli_error($connectDb);
}

mysqli_close($connectDb);


?>