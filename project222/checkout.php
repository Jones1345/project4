<?php
session_start();
include "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION["cart"])) {
    echo "Your cart is empty. <a href='index.php'>Go Back</a>";
    exit;
}

// Process order
foreach ($_SESSION["cart"] as $medicine_id) {
    $query = "UPDATE medicines SET stock = stock - 1 WHERE id = '$medicine_id'";
    $conn->query($query);
}

// Clear cart
unset($_SESSION["cart"]);

echo "Order placed successfully! <a href='index.php'>Go Back</a>";
?>
