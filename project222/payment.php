<?php
session_start();
include "db.php";

// Redirect if cart is empty
if (empty($_SESSION["cart"])) {
    header("Location: cart.php");
    exit;
}

// Process Payment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardNumber = $_POST["card_number"];
    $cardHolder = $_POST["card_holder"];
    $expiry = $_POST["expiry"];
    $cvv = $_POST["cvv"];

    // Fake validation (Basic check)
    if (strlen($cardNumber) == 16 && strlen($cvv) == 3) {
        echo "<p class='success'>✅ Payment Successful! Your order has been placed.</p>";
        $_SESSION["cart"] = []; // Clear cart
    } else {
        echo "<p class='error'>❌ Invalid Card Details. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Pharmacy</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>
    <div class="container">
        <nav>
            <h1>💳 Payment Page</h1>
            <div class="nav-links">
                <a href="cart.php">⬅ Back to Cart</a>
            </div>
        </nav>

        <form method="POST" class="payment-form">
            <label>Card Number:</label>
            <input type="text" name="card_number" placeholder="" maxlength="16" required>

            <label>Card Holder Name:</label>
            <input type="text" name="card_holder" placeholder="" required>

            <label>Expiry Date:</label>
            <input type="month" name="expiry" required>

            <label>CVV:</label>
            <input type="text" name="cvv" placeholder="" maxlength="3" required>

            <button type="submit">💳 Pay Now</button>
        </form>
    </div>
</body>
</html>
