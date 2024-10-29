<?php
require 'db.php';

// Số sản phẩm trên mỗi trang
$products_per_page = 9;

// Lấy trang hiện tại từ tham số truy vấn page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($current_page - 1) * $products_per_page;

// Truy vấn để lấy số lượng sản phẩm và phân trang
$stmt = $conn->query("SELECT COUNT(*) AS total FROM products");
$total_results = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_results / $products_per_page);

// Truy vấn lấy danh sách các danh mục
$categories_stmt = $conn->query("SELECT * FROM category");
$categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý lọc sản phẩm theo danh mục
$selected_category = isset($_GET['category']) ? $_GET['category'] : null;
$where_clause = '';
$params = [];
if (!empty($selected_category)) {
    $where_clause = ' WHERE Category_Id = :category_id';
    $params['category_id'] = $selected_category;
}

// Truy vấn lấy danh sách sản phẩm với điều kiện lọc theo danh mục
$query = "SELECT * FROM products";
if (!empty($where_clause)) {
    $query .= $where_clause;
}
$query .= " LIMIT :start, :products_per_page";
$stmt = $conn->prepare($query);
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':products_per_page', $products_per_page, PDO::PARAM_INT);
foreach ($params as $param_name => $param_value) {
    $stmt->bindValue(':' . $param_name, $param_value);
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Gâteau Royal - Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <?php include 'navbar_client.php'; ?>
</header>
<div class="category-nav">
    <a href="product.php" class="<?php echo is_null($selected_category) ? 'active' : ''; ?>">All</a>
    <?php foreach ($categories as $index => $category): ?>
        <?php if ($index > 0): ?>
            <span class="separator">/</span>
        <?php endif; ?>
        <a href="product.php?category=<?php echo $category['Category_Id']; ?>" class="<?php echo ($category['Category_Id'] == $selected_category) ? 'active' : ''; ?>">
            <?php echo htmlspecialchars($category['Category_Name']); ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="product-grid">
    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card" onclick="window.location='product_detail.php?id=<?php echo $product['Product_Id']; ?>'">
                <a href="product_detail.php?id=<?php echo $product['Product_Id']; ?>" style="text-decoration: none; color: inherit;">
                    <img src="<?php echo htmlspecialchars($product['images']); ?>" alt="<?php echo htmlspecialchars($product['Product_Name']); ?>">
                    <div class="product-details">
                        <h3><?php echo htmlspecialchars($product['Product_Name']); ?></h3>
                        <p class="price"><?php echo '$' . number_format($product['Price'], 2); ?></p>
                        
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>


<!-- Phân trang -->
<div class="pagination">
    <?php if ($total_pages > 1): ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="product.php?page=<?php echo $i; ?>&category=<?php echo $selected_category; ?>" class="<?php echo ($i === $current_page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    <?php endif; ?>
</div>

<?php include'footer_client.php';?>

</body>
</html>
