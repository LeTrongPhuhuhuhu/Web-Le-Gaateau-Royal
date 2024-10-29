<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_order'])) {
    // Kết nối cơ sở dữ liệu
    include 'db_connect.php';

    // Lấy dữ liệu từ form
    $customer_name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $note = trim($_POST['note']);
    $update_time = date('Y-m-d H:i:s'); // Thời gian hiện tại

    // Tính tổng giá trị đơn hàng và chuẩn bị dữ liệu sản phẩm
    $total_amount = 0;
    $total_quantity = 0;
    $orders_item = [];
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $total_amount += $product['price'] * $product['quantity'];
            $total_quantity += $product['quantity'];
            $orders_item[] = $product['name'];
        }
    }
    $orders_item_string = implode(", ", $orders_item);

    try {
        // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng order_detail
        $sql = "INSERT INTO order_detail (customer_name, phone, address, email, note, update_time, orders_item, quantity_of_product, total_amount)
                VALUES (:customer_name, :phone, :address, :email, :note, :update_time, :orders_item, :quantity_of_product, :total_amount)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':update_time', $update_time);
        $stmt->bindParam(':orders_item', $orders_item_string);
        $stmt->bindParam(':quantity_of_product', $total_quantity);
        $stmt->bindParam(':total_amount', $total_amount);

        if ($stmt->execute()) {
            // Đơn hàng được xử lý thành công, xóa giỏ hàng
            unset($_SESSION['cart']); // Xóa giỏ hàng trong session

            // Hiển thị thông báo thành công và điều hướng đến trang chủ
            echo "<script>
                alert('Thanks for your order!');
                window.location.href = 'index.php';
            </script>";
        } else {
            // Thông báo lỗi
            echo "<script>alert('Error placing order. Please try again later.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
