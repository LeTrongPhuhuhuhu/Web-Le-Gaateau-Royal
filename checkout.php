<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Le Gâteau Royal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar_client.php'; ?>

<div class="checkout-container">
    <h2>Checkout</h2>
    <form action="process_order.php" method="post">
        <div class="form-group">
            <label for="customer_name">Full Name *</label>
            <input type="text" id="customer_name" name="customer_name" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone *</label>
            <input type="text" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="address">Address *</label>
            <textarea id="address" name="address" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <textarea id="note" name="note" rows="4"></textarea>
        </div>

        <div class="form-buttons">
            <input type="submit" name="submit_order" value="Submit Order" class="submit-button">
            <a href="cart.php" class="cancel-button">Cancel</a> <!-- Cancel button to return to cart.php -->
        </div>
    </form>
</div>

<?php include 'footer_client.php'; ?>

<script>
    // JavaScript code can be added here for additional functionality
</script>

</body>
</html>
