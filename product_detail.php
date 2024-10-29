<?php
session_start(); // Khởi tạo session

require 'db.php';

// Lấy Product_Id từ URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra Product_Id hợp lệ
if ($product_id <= 0) {
    die('Invalid product ID');
}

// Truy vấn thông tin chi tiết sản phẩm
$query = "SELECT * FROM products WHERE Product_Id = :product_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra nếu sản phẩm không tồn tại
if (!$product) {
    die('Product not found');
}

// Truy vấn tên danh mục sản phẩm
$category_query = "SELECT * FROM category WHERE Category_Id = :category_id";
$category_stmt = $conn->prepare($category_query);
$category_stmt->bindParam(':category_id', $product['Category_Id'], PDO::PARAM_INT);
$category_stmt->execute();
$category = $category_stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra nếu danh mục không tồn tại
if (!$category) {
    die('Category not found');
}

// Xử lý khi thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Tạo giỏ hàng nếu chưa tồn tại
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng, thì chỉ cập nhật số lượng
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Nếu chưa có trong giỏ hàng, thêm mới sản phẩm vào giỏ
        $_SESSION['cart'][$product_id] = [
            'id' => $product['Product_Id'],
            'name' => $product['Product_Name'],
            'price' => $product['Price'],
            'quantity' => $quantity,
            'image' => $product['images']
        ];
    }

    // Chuyển hướng để tránh POST lại khi làm mới trang
    header("Location: product_detail.php?id=" . $product_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['Product_Name']); ?> - Le Gâteau Royal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar_client.php'; ?>

    <div class="breadcrumb">
        <a href="product.php">Products</a> /
        <a href="product.php?category=<?php echo $category['Category_Id']; ?>" class="<?php echo ($category['Category_Id'] == $selected_category) ? 'active' : ''; ?>">
            <?php echo htmlspecialchars($category['Category_Name']); ?>
        </a>/
        <span><?php echo htmlspecialchars($product['Product_Name']); ?></span>
    </div>

    <div class="product-detail">
        <div class="product-image">
            <img src="<?php echo htmlspecialchars($product['images']); ?>" alt="<?php echo htmlspecialchars($product['Product_Name']); ?>">
        </div>
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['Product_Name']); ?></h1>
            <p class="price"><?php echo '$' . number_format($product['Price'], 2); ?></p>
            <div class="description">
                <h3>Description: </h3>
                <p><?php echo nl2br(htmlspecialchars($product['Description'])); ?></p>
            </div>
            <form method="POST" class="add-to-cart-form">
                <div class="quantity-controls">
                    <button type="button" onclick="changeQuantity(-1)" class="quantity-button">-</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantity-input">
                    <button type="button" onclick="changeQuantity(1)" class="quantity-button">+</button>
                </div>
                <button type="submit" class="add-to-cart-button">Add to Cart</button>
            </form>
        </div>
    </div>

    <a href="product.php" class="back-link">&lt; Back to Products</a>

   

    <script>
        function changeQuantity(amount) {
            const quantityInput = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + amount;
            if (newQuantity < 1) newQuantity = 1;
            quantityInput.value = newQuantity;
        }
    </script>
<?php include 'footer_client.php'; ?>
</body>
</html>
