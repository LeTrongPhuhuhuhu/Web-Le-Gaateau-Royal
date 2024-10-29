<?php
session_start(); // Khởi tạo session

require 'db.php';

// Hàm tính tổng tiền trong giỏ hàng
function calculateTotal($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Xóa sản phẩm khỏi giỏ hàng nếu có yêu cầu
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Le Gâteau Royal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar_client.php'; ?>

<div class="cart-container">
    <h2>Your Cart</h2>
    <?php
    // Tính tổng tiền giỏ hàng
    $total_price = 0;
    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $total_price += $product['price'] * $product['quantity'];
        }
    }
    $total_price = number_format($total_price, 2);
    ?>
    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
                    <tr data-product-id="<?php echo $product_id; ?>">
                        <td>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="cart-product-image">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </td>
                        <td class="item-price" data-price="<?php echo $product['price']; ?>"><?php echo '$' . number_format($product['price'], 2); ?></td>
                        <td>
                            <input type="number" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $product['quantity']; ?>" min="1" max="10" class="quantity-input" data-product-id="<?php echo $product_id; ?>">
                        </td>
                        <td class="item-total"><?php echo '$' . number_format($product['price'] * $product['quantity'], 2); ?></td>
                        <td>
                            <button type="button" class="remove-button-popup" data-product-id="<?php echo $product_id; ?>">
                                <span class="material-symbols-outlined">&#x274C;</span> <!-- Cross symbol -->
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="total-label">Total:</td>
                    <td colspan="2" class="total-amount"><?php echo '$' . $total_price; ?></td>
                </tr>
            </tbody>
        </table>
        <div class="cart-buttons">
            <button id="checkoutButton" class="checkout-button">Proceed to Checkout</button>
            <a href="product.php" class="continue-shopping">Continue Shopping</a>
        </div>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="product.php" class="continue-shopping">Continue Shopping</a>
    <?php endif; ?>
</div>

<!-- Popup Checkout Form -->
<div id="checkoutPopup" class="overlay-1">
    <div class="checkout-popup">
        <span class="close" onclick="closeCheckoutPopup()">&times;</span>
        <div class="checkout-container">
            <div class="checkout-left">
                <h2>Checkout</h2>
                <form id="checkoutForm" action="process_order.php" method="post">
                    <label for="customer_name">Full Name *</label>
                    <input type="text" id="customer_name" name="customer_name" required>

                    <label for="phone">Phone *</label>
                    <input type="text" id="phone" name="phone" required>

                    <label for="address">Address *</label>
                    <textarea id="address" name="address" rows="4" required></textarea>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">

                    <label for="note">Note</label>
                    <textarea id="note" name="note" rows="4"></textarea>

                    <input type="submit" name="submit_order" value="Submit Order" class="confirm-button">
                    <a href="#" class="cancel-button" onclick="closeCheckoutPopup()">Cancel</a>
                </form>
            </div>
            <div class="checkout-right">
                <h2>Order Summary</h2>
                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td><?php echo '$' . number_format($product['price'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="total-summary">Total: <?php echo '$' . $total_price; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Remove Product Popup -->
<div id="confirmRemovePopup" class="overlay-2">
    <div class="confirm-remove-container">
        <div class="confirm-remove-popup">
            <h2>Confirm Removal</h2>
            <p>Are you sure you want to remove this item from your cart?</p>
            <form id="confirmRemoveForm" action="update_cart.php" method="post">
                <input type="hidden" id="removeProductId" name="product_id" value="">
                <input type="submit" value="Confirm" class="confirm-button">
                <a href="#" class="cancel-button" onclick="closeConfirmRemovePopup()">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Update cart item function
        function updateCartItem(input) {
            var productId = input.getAttribute('data-product-id');
            var quantity = parseInt(input.value);

            // Update quantity in the session or database
            // Here you should send an AJAX request to update the quantity

            var row = input.closest('tr');
            var priceCell = row.querySelector('.item-price');
            var totalCell = row.querySelector('.item-total');
            var price = parseFloat(priceCell.getAttribute('data-price'));
            var total = price * quantity;
            totalCell.textContent = '$' + total.toFixed(2);

            // Update total price
            updateTotalPrice();
        }

        // Update total price function
        function updateTotalPrice() {
            var total = 0;
            var totalCells = document.querySelectorAll('.item-total');
            totalCells.forEach(function(cell) {
                var amount = parseFloat(cell.textContent.replace('$', ''));
                total += amount;
            });
            var totalPriceCell = document.querySelector('.total-amount');
            totalPriceCell.textContent = '$' + total.toFixed(2);
        }

        // Show checkout popup when clicking Proceed to Checkout
        document.getElementById('checkoutButton').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('checkoutPopup').style.display = 'block';
        });

        // Close checkout popup
        function closeCheckoutPopup() {
            document.getElementById('checkoutPopup').style.display = 'none';
        }

        document.querySelectorAll('#checkoutPopup .close, #checkoutPopup .cancel-button').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                closeCheckoutPopup();
            });
        });

        // Confirm remove product from cart
        document.querySelectorAll('.remove-button-popup').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var productId = button.getAttribute('data-product-id');
                document.getElementById('removeProductId').value = productId;
                document.getElementById('confirmRemovePopup').style.display = 'block';
            });
        });

        // Confirm removal
        document.getElementById('confirmRemoveForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var productId = document.getElementById('removeProductId').value;

            // Gửi yêu cầu AJAX để xóa sản phẩm
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Cập nhật giỏ hàng và giao diện
                        var row = document.querySelector(`[data-product-id="${productId}"]`);
                        if (row) {
                            row.remove();
                            updateTotalPrice(); // Cập nhật tổng giá
                            closeConfirmRemovePopup();
                        }
                    } else {
                        alert('Failed to remove the item.');
                    }
                }
            };
            xhr.send('action=remove&product_id=' + encodeURIComponent(productId));
        });

        // Đóng popup xác nhận xóa
        function closeConfirmRemovePopup() {
            document.getElementById('confirmRemovePopup').style.display = 'none';
        }

        document.querySelectorAll('#confirmRemovePopup .cancel-button, #confirmRemovePopup .close').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                closeConfirmRemovePopup();
            });
        });

        // Xử lý cập nhật số lượng sản phẩm
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            input.addEventListener('change', function() {
                updateCartItem(input);
            });
        });
    });
</script>

</body>
</html>
