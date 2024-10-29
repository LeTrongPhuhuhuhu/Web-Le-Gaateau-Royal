<?php
include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Lấy danh sách các danh mục sản phẩm từ cơ sở dữ liệu
$stmt = $conn->query("SELECT Category_Id, Category_Name FROM category ORDER BY Category_Name");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$message = ''; // Biến để chứa thông báo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ form và kiểm tra
    $product_name = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    
    $category_id = $_POST['category_id']; // Lấy ID của danh mục sản phẩm được chọn

    // Kiểm tra dữ liệu
    if (empty($product_name) || empty($price) ) {
        $message = "All fields are required.";
    } elseif (!preg_match('/^\d{1,5}(\.\d{1,2})?$/', $price)) {
        $message = "Price must be numeric with up to 5 digits before the decimal point and up to 2 digits after.";
    } else {
        // Xử lý file upload
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            $file_name = $_FILES['product_image']['name'];
            $file_tmp = $_FILES['product_image']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Kiểm tra phần mở rộng file
            if (!in_array($file_ext, $allowed_ext)) {
                $message = "Invalid file type. Allowed types: " . implode(', ', $allowed_ext);
            } else {
                // Đặt tên file duy nhất và lưu file
                $new_file_name = uniqid('img_', true) . '.' . $file_ext;
                $upload_dir = 'uploads/';
                $upload_path = $upload_dir . $new_file_name;

                // Tạo thư mục nếu chưa có
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Lưu thông tin vào cơ sở dữ liệu
                    try {
                        $stmt = $conn->prepare("INSERT INTO products (Product_Name, Description, Price, images, Category_Id) VALUES ( ?, ?, ?, ?, ?)");
                        $stmt->execute([$product_name, $description, $price, $upload_path, $category_id]);

                        // Thông báo thành công và chuyển hướng
                        echo '<script>alert("Product added successfully."); window.location = "product_mng.php";</script>';
                        exit;
                    } catch (PDOException $e) {
                        $message = "Error: " . $e->getMessage();
                    }
                } else {
                    $message = "Failed to upload image.";
                }
            }
        } else {
            $message = "Image upload error or no image uploaded.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Products</title>
  
</head>
<body>
    <?php include 'admin_navbar.php'; ?>
    <p class="list_of_products">Add New Products</p>
    <br>
    <div class="form-container">
        <form action="" method="post" class="product-form" enctype="multipart/form-data">
            <div class="form-column">
                <?php if (!empty($message)): ?>
                    <div class="alert"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="product_name">Product name:</label>
                    <input type="text" name="product_name" id="product_name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" name="description" id="description">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" name="price" id="price" required>
                    <small>Enter numeric value up to 5 digits before the decimal point and up to 2 digits after.</small>
                </div>

                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">Select category...</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['Category_Id']); ?>"><?php echo htmlspecialchars($category['Category_Name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_image">Product Image:</label>
                    <input type="file" name="product_image" id="product_image" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn_add">Add</button>
                    <button type="reset" class="btn_reset">Reset</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
