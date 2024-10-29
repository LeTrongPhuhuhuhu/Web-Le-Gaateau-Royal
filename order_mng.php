<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
include 'db.php';

// Query to fetch all orders
$ordersQuery = $conn->query("SELECT * FROM `order_detail` ORDER BY update_time DESC");
$orders = $ordersQuery->fetchAll(PDO::FETCH_ASSOC);

// Mark new orders as viewed
$conn->query("UPDATE `order_detail` SET is_viewed = TRUE WHERE is_viewed = FALSE");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Le Gâteau Royal Admin</title>
    <link rel="stylesheet" href="admin.css">
    
    <script>
        function goToOrderDetail(orderId) {
            window.location.href = 'order_detail.php?Order_Detail_ID=' + orderId;
        }
    </script>
</head>

<body>
<?php include 'admin_navbar.php'; ?>
    <div class="content">
        <h2>Order Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Mã hóa đơn</th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr onclick="goToOrderDetail('<?php echo $order['Order_Detail_ID']; ?>')">
                        <td><?php echo $order['Order_Detail_ID']; ?></td>
                        <td><?php echo $order['Customer_Name']; ?></td>
                        <td><?php echo $order['Phone']; ?></td>
                        <td><?php echo $order['update_time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
