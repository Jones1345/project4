<?php
session_start();
include "db.php";

// Initialize cart if not set
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Remove an item from the cart
if (isset($_GET["remove"])) {
    $id = $_GET["remove"];
    unset($_SESSION["cart"][$id]);
    header("Location: cart.php");
    exit;
}

// Process order (you can enhance this later)
if (isset($_POST["checkout"])) {
    echo "<p class='success'>Order placed successfully! (Feature coming soon)</p>";
    $_SESSION["cart"] = []; // Clear the cart after checkout
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Pharmacy</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div class="container">
        <nav>
            <h1>🛒 Your Cart</h1>
            <div class="nav-links">
                <a href="index.php">⬅ Back to Shop</a>
            </div>
        </nav>

        <?php if (empty($_SESSION["cart"])): ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php else: ?>
            <table class="cart-table">
                <tr>
                    <th>Medicine</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Remove</th>
                </tr>
                <?php foreach ($_SESSION["cart"] as $id => $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item["name"]) ?></td>
                        <td>$<?= htmlspecialchars($item["price"]) ?></td>
                        <td><?= htmlspecialchars($item["quantity"]) ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $id ?>" class="delete-button">❌</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <a href="payment.php" class="checkout-button">💳 Proceed to Payment</a>
        <?php endif; ?>
    </div>
</body>
</html>
