<?php

session_start();
require_once "connectDatabase.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css" />
    <title>Products Page</title>
</head>
<body>
    <h1>Products Page</h1>
    <div class="container">

        <?php
        $select ="SELECT title,image,description,price FROM products ORDER BY id ASC";
        $result = mysqli_query($connectDb,$select);
        while($row = mysqli_fetch_array($result)){
        ?>
        <div class="product-container">
            <form method="post" class="formular">
                <div>
                    <img src="<?php echo $row["image"]; ?>" class="img" />
                    <div>
                        <h2><?php echo $row["title"] ?></h2>
                        <p><?php echo $row["description"]; ?></p>
                        <h4><?php echo $row["price"]; ?></h4>
                    </div>

                    <input type="submit" name="add_to_cart" value="Add" />
                </div>
            </form>
        </div>
        <?php
            }

        ?>

    </div>

</body>
</html>
