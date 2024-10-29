// delete_prod.php

<?php
include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Kiểm tra xem Product_ID đã được truyền vào hay chưa
if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$product_id = $_GET['id'];

// Xử lý xóa sản phẩm từ cơ sở dữ liệu
$stmt = $conn->prepare("DELETE FROM products WHERE Product_Id = ?");
$stmt->execute([$product_id]);

// Chuyển hướng người dùng về trang danh sách sản phẩm sau khi xóa thành công
header("Location: product_mng.php");
exit();
?>
