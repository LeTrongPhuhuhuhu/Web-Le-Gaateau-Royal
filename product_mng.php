<?php
include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Truy vấn để lấy danh sách sản phẩm từ bảng products và kết hợp với bảng category
$stmt = $conn->query("SELECT p.*, c.Category_Name 
                      FROM products p
                      LEFT JOIN category c ON p.Category_Id = c.Category_Id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Biến lưu trữ chuỗi HTML cho các sản phẩm
$productRows = '';

foreach ($products as $product) {
    // Định dạng giá tiền với ký hiệu $ và hai chữ số thập phân
    $formatted_price = '$' . number_format($product['Price'], 2);

    // Xây dựng chuỗi HTML cho từng sản phẩm và cột category
    $productRows .= '
        <tr>
            <td><img src="' . htmlspecialchars($product['images']) . '"></td>
            <td>' . htmlspecialchars($product['Product_Name']) . '</td>
            <td>' . htmlspecialchars($product['Description']) . '</td>
            <td>' . $formatted_price . '</td>
           
            <td>' . htmlspecialchars($product['Category_Name']) . '</td>
            <td>
                <a href="edit_prod.php?id=' . $product['Product_Id'] . '" class="btn-edit">Edit</a>
                <a href="delete_prod.php?id=' . $product['Product_Id'] . '" class="btn-delete" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>
            </td>
        </tr>
    ';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <div class="product-list-container">
        <h2>Product List</h2>
        <div style="margin-bottom: 10px;">
            <a href="add_new_prod.php" class="btn-add-new">Add New</a>
        </div>
        <table class="product-list">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                   
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $productRows; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
