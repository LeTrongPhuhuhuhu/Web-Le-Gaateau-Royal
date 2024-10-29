<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

// Lấy thời gian kiểm tra cuối cùng từ session hoặc thiết lập thời gian mặc định
$last_check_time = isset($_SESSION['last_check_time']) ? $_SESSION['last_check_time'] : '1970-01-01 00:00:00';

// Lưu thời gian hiện tại để sử dụng trong lần kiểm tra tiếp theo
$current_check_time = date('Y-m-d H:i:s');

try {
    // Đếm số đơn hàng mới sau thời gian kiểm tra cuối cùng
    $stmt = $pdo->prepare("SELECT COUNT(*) as new_orders FROM orders WHERE update_time > :last_check_time");
    $stmt->execute(['last_check_time' => $last_check_time]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cập nhật thời gian kiểm tra cuối cùng
    $_SESSION['last_check_time'] = $current_check_time;

    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
