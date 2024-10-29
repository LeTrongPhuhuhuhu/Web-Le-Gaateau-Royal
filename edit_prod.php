<?php
include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Kiểm tra xem Product_ID đã được truyền vào hay chưa
if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$product_id = $_GET['id'];

// Truy vấn để lấy thông tin sản phẩm cần sửa
$stmt = $conn->prepare("SELECT * FROM products WHERE Product_Id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

// Truy vấn để lấy danh sách category
$category_stmt = $conn->prepare("SELECT Category_Id, Category_Name FROM category");
$category_stmt->execute();
$categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý khi người dùng gửi biểu mẫu sửa đổi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $category_id = $_POST['category']; // Lấy Category_Id từ form

    // Cập nhật thông tin sản phẩm vào cơ sở dữ liệu
    $stmt = $conn->prepare("UPDATE products SET Product_Name = ?, Description = ?, Price = ?, Category_Id = ? WHERE Product_Id = ?");
    $stmt->execute([$name, $description, $price, $category_id, $product_id]);

    // Chuyển hướng người dùng về trang danh sách sản phẩm sau khi sửa đổi thành công
    header("Location: product_mng.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>
    <h2>Edit Product</h2>
    <div class="form-container">
        <form action="" method="post" class="product-form" enctype="multipart/form-data">
            <div class="form-column">
                <?php if (!empty($message)): ?>
                    <div class="alert"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="product_name">Product name:</label>
                    <input type="text" name="name" id="product_name" value="<?php echo htmlspecialchars($product['Product_Name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($product['Description']); ?>">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($product['Price']); ?>" required>
                </div>
              
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['Category_Id']); ?>" <?php echo ($category['Category_Id'] == $product['Category_Id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['Category_Name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_image">Product Image:</label>
                    <input type="file" name="product_image" id="product_image">
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn_add">Save Change</button>
                    <button type="reset" class="btn_reset">Reset</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
