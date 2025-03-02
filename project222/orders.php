<?php
session_start();
include "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION["user"];

// Fetch user's orders
$query = "SELECT p.id, m.name, m.image, p.quantity, p.total_price, p.purchase_date 
          FROM purchases p 
          JOIN medicines m ON p.medicine_id = m.id 
          WHERE p.user = '$user' 
          ORDER BY p.purchase_date DESC";
$result = $conn->query($query);
?>

<h2>Your Order History</h2>
<a href="index.php">Back to Shop</a> | <a href="logout.php">Logout</a>

<div style="display: flex; flex-wrap: wrap;">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px; width: 220px; text-align: center; background-color: #f9f9f9; border-radius: 10px;">
            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" width="100" style="border-radius: 5px;">
            <p><b>Medicine:</b> <?= htmlspecialchars($row["name"]) ?></p>
            <p><b>Quantity:</b> <?= htmlspecialchars($row["quantity"]) ?></p>
            <p><b>Total Price:</b> $<?= htmlspecialchars($row["total_price"]) ?></p>
            <p><b>Purchase Date:</b> <?= htmlspecialchars($row["purchase_date"]) ?></p>
        </div>
    <?php endwhile; ?>
</div>
