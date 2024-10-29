<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
include 'db.php';

// Fetch the number of new orders that have not been viewed
$newOrdersQuery = $conn->query("SELECT COUNT(*) AS new_orders_count FROM `order_detail` WHERE is_viewed = FALSE");
$newOrders = $newOrdersQuery->fetch(PDO::FETCH_ASSOC)['new_orders_count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <nav class="nav">
        <div class="navbar">
            <span class="item-nav">
                <a class="navbarbrand" href="admin.php">Le Gâteau Royal Admin</a>
                <a href="product_mng.php">Product Management</a>
                <a href="order_mng.php">Order Management <span class="order-count"><?php echo $newOrders; ?></span></a>
                <a href="category_mng.php">Category Management</a>
                <a href="revenue_static.php">Revenue Statistics</a>
            </span>
            <span class="info">
                <?php if (isset($_SESSION['Email'])) : ?>
                    <a>Xin chào, <?php echo htmlspecialchars($_SESSION['Email']); ?>!</a>
                    <a href="logout.php"><img class="logout-icon" src="Image/logo/logout.png" alt="Logout"></a>
                <?php endif; ?>
            </span>
        </div>
    </nav>
</body>

</html>
