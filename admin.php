<?php
include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Truy vấn để lấy số lượng đơn hàng mới chưa xem
$stmt = $conn->prepare("SELECT COUNT(*) AS new_orders FROM order_detail WHERE is_viewed = 0");
$stmt->execute();
$new_orders = $stmt->fetch(PDO::FETCH_ASSOC)['new_orders'];

// Xử lý tìm kiếm sản phẩm
$search_results = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_term = $_POST['search_term'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE Product_Name LIKE ?");
    $stmt->execute(['%' . $search_term . '%']);
    $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Le Gâteau Royal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .content {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .content h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #343a40;
        }

        .notification {
            background-color: #ff4757;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.2em;
        }

        .notification h3 {
            margin: 0 0 10px 0;
        }

        .search-container {
            margin-bottom: 40px;
            text-align: center;
        }

        .search-form {
            display: flex;
            justify-content: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-form input[type="text"] {
            width: 75%;
            padding: 15px;
            border: 1px solid #ced4da;
            border-radius: 15px 0 0 15px;
            font-size: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .search-form .btn-search {
            width: 25%;
            padding: 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 0 15px 15px 0;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .search-form .btn-search:hover {
            background-color: #0056b3;
        }

        .product-list table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .product-list th, .product-list td {
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }

        .product-list th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: bold;
        }

        .product-list tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .product-list tr:hover {
            background-color: #e9ecef;
            cursor: pointer;
        }

        .btn-edit, .btn-delete {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
            }

            .search-form input[type="text"], .search-form .btn-search {
                width: 100%;
                border-radius: 15px;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <div class="content">
        <h2>Welcome to Admin Dashboard</h2>

        <!-- Thông báo đơn hàng mới -->
        <div class="notification">
            <h3>New Orders</h3>
            <p><?php echo $new_orders; ?> new orders received today.</p>
        </div>

        <!-- Form tìm kiếm sản phẩm -->
        <div class="search-container">
            <form action="" method="post" class="search-form">
                <input type="text" name="search_term" placeholder="Enter product name" required>
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>

        <!-- Kết quả tìm kiếm sản phẩm -->
        <div class="product-list">
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($search_results as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['Product_Name']); ?></td>
                            <td><?php echo htmlspecialchars($product['Description']); ?></td>
                            <td><?php echo htmlspecialchars($product['Price']); ?></td>
                            <td><?php echo htmlspecialchars($product['Category_Id']); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['Product_Id']; ?>" class="btn-edit">Edit</a>
                                <a href="delete_product.php?id=<?php echo $product['Product_Id']; ?>" class="btn-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($search_results) && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No products found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
