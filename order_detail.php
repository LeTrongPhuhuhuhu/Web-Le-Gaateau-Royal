<?php
// Include the session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include 'db.php';

// Retrieve order details
$order_id = isset($_GET['Order_Detail_ID']) ? $_GET['Order_Detail_ID'] : 0;

try {
    // Fetch order details
    $stmt = $conn->prepare("SELECT * FROM order_detail WHERE Order_Detail_ID = :order_id");
    $stmt->execute(['order_id' => $order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "Order not found.";
        exit;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Le Gâteau Royal Admin</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        /* Existing CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .order-details-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .order-details-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .order-details-container table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        .order-details-container table th, 
        .order-details-container table td {
            padding: 12px 15px;
            text-align: left;
        }

        .order-details-container table th {
            background-color: #ecf0f1;
            font-weight: bold;
            color: #34495e;
        }

        .order-details-container table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .order-details-container table tbody tr:hover {
            background-color: #ecf0f1;
            cursor: pointer;
        }

        .order-details-container .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            text-align: center;
            display: block;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        .order-details-container .btn-back:hover {
            background-color: #2980b9;
        }

        .total-amount {
            text-align: right;
            padding: 15px 0;
        }

        .total-amount th,
        .total-amount td {
            padding: 10px 20px;
        }
    </style>
</head>
<body>

<?php include 'admin_navbar.php'; ?>

<div class="order-details-container">
    <h2>Order Details</h2>
    <table>
        <tr>
            <th>Order Detail ID</th>
            <td><?php echo htmlspecialchars($order['Order_Detail_ID']); ?></td>
        </tr>
        <tr>
            <th>Customer Name</th>
            <td><?php echo htmlspecialchars($order['Customer_Name']); ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo htmlspecialchars($order['Phone']); ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?php echo htmlspecialchars($order['Address']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($order['Email']); ?></td>
        </tr>
        <tr>
            <th>Note</th>
            <td><?php echo htmlspecialchars($order['Note']); ?></td>
        </tr>
        <tr>
            <th>Orders Item</th>
            <td><?php echo htmlspecialchars($order['Orders_Item']); ?></td>
        </tr>
        <tr>
            <th>Quantity of Product</th>
            <td><?php echo htmlspecialchars($order['Quantity_of_Product']); ?></td>
        </tr>
        <tr>
            <th>Price</th>
            <td><?php echo htmlspecialchars($order['Price']); ?></td>
        </tr>
        <tr>
            <th>Total Amount</th>
            <td><?php echo htmlspecialchars($order['Total_Amount']); ?></td>
        </tr>
        <tr>
            <th>Update Time</th>
            <td><?php echo htmlspecialchars($order['update_time']); ?></td>
        </tr>
        <tr>
            <th>Is Viewed</th>
            <td><?php echo htmlspecialchars($order['is_viewed']); ?></td>
        </tr>
    </table>

    <a href="order_mng.php" class="btn-back">Back to Order Management</a>
</div>

</body>
</html>
