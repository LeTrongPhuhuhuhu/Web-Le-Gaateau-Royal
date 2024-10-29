<?php
session_start();
session_unset(); // Xóa tất cả các biến session
session_destroy(); // Hủy session

// Xóa các cookie nếu có
if (isset($_COOKIE['email'])) {
    setcookie('email', '', time() - 3600); // Đặt thời gian hết hạn trong quá khứ (để xóa cookie)
}
if (isset($_COOKIE['pswd'])) {
    setcookie('pswd', '', time() - 3600);
}

// Chuyển hướng người dùng về trang login
header("Location: login.php");
exit();
?>
