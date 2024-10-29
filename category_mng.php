<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Xử lý thêm danh mục mới
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);
    
    if (!empty($category_name)) {
        try {
            $stmt = $conn->prepare("INSERT INTO category (Category_Name) VALUES (?)");
            $stmt->execute([$category_name]);
            $message = "Category added successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Category name is required.";
    }
}

// Xử lý xóa danh mục
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $category_id = $_GET['id'];
    
    try {
        $stmt = $conn->prepare("DELETE FROM category WHERE Category_Id = ?");
        $stmt->execute([$category_id]);
        $message = "Category deleted successfully.";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Truy vấn để lấy danh sách các danh mục từ bảng categories
$stmt = $conn->query("SELECT * FROM category");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link rel="stylesheet" href="admin.css"> <!-- Định dạng CSS -->
    <style>
        /* Định dạng cho bảng */
        .product-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .product-list th, .product-list td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .product-list th {
            background-color: #f2f2f2;
        }
        .product-list td img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .product-list .btn-edit, .product-list .btn-delete {
            padding: 5px 10px;
            text-decoration: none;
            color: #fff;
            cursor: pointer;
            margin-right: 5px;
        }
        .product-list .btn-edit {
            background-color: #4CAF50;
        }
        .product-list .btn-delete {
            background-color: #f44336;
        }
        .product-list .btn-edit:hover, .product-list .btn-delete:hover {
            opacity: 0.8;
        }
        .add-category {
            margin-bottom: 10px;
        }
        .add-category input[type="text"] {
            padding: 8px;
            width: 200px;
            margin-right: 10px;
        }
        .add-category button {
            padding: 8px;
            cursor: pointer;
            background-color: #4CAF50;
            border: none;
            color: #fff;
        }
        .add-category button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'admin_navbar.php'; ?> <!-- Include thanh navbar -->

    <div class="product-list-container">
        <h2>Category Management</h2>
        
        <?php if (isset($message)): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Form thêm danh mục mới -->
        <div class="add-category">
            <form action="" method="post">
                <input type="text" name="category_name" placeholder="Category name" required>
                <button type="submit">Add Category</button>
            </form>
        </div>

        <!-- Bảng hiển thị danh sách danh mục -->
        <table class="product-list">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($category['Category_Id']); ?></td>
                        <td><?php echo htmlspecialchars($category['Category_Name']); ?></td>
                        <td>
                            <a href="edit_category.php?id=<?php echo $category['Category_Id']; ?>" class="btn-edit">Edit</a>
                            <a href="?action=delete&id=<?php echo $category['Category_Id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
