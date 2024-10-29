<?php
session_start(); // Khởi tạo session nếu chưa tồn tại

// Kiểm tra yêu cầu xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);

        // Đếm lại số lượng sản phẩm trong giỏ hàng
        $cartItemCount = count($_SESSION['cart']);

        // Trả về dữ liệu JSON cho JavaScript xử lý
        $response = [
            'success' => true,
            'cartItemCount' => $cartItemCount
        ];
        echo json_encode($response);
        exit;
    }
}

// Nếu không thành công, trả về lỗi
$response = [
    'success' => false
];
echo json_encode($response);
