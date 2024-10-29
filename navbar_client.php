<?php
require 'db.php';

session_start();
$total_quantity = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_quantity += $item['quantity'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Gâteau Royal</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <a href="index.php" class="navbar-logo">
            <img src="Image/logo/logoremove.png" alt="Le Gâteau Royal Logo"><span></span>
        </a>
        <ul>
            <li><a href="index.php">Shop</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="cart.php">Cart (<?php echo $total_quantity; ?>)</a></li>

        </ul>
        </nav>

    </header>
   

</body>

</html>