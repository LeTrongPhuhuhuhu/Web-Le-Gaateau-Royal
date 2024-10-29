<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    unset($_SESSION['cart']);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
