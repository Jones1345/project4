<?php
session_start();
include "db.php";

// Initialize cart if not set
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Fetch medicines
$result = $conn->query("SELECT * FROM medicines");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["medicine_id"])) {
    $id = $_POST["medicine_id"];
    
    // Fetch medicine details
    $medQuery = $conn->query("SELECT * FROM medicines WHERE id = '$id'");
    $medicine = $medQuery->fetch_assoc();

    if ($medicine) {
        if (!isset($_SESSION["cart"][$id])) {
            $_SESSION["cart"][$id] = [
                "name" => $medicine["name"],
                "price" => $medicine["price"],
                "quantity" => 1
            ];
        } else {
            $_SESSION["cart"][$id]["quantity"] += 1;
        }
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Store</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <nav>
            <h1>💊 Pharmacy Store</h1>
            <div class="nav-links">
                <a href="cart.php">🛒 Cart (<?= count($_SESSION["cart"] ?? []) ?>)</a>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </nav>

        <h2>🛍 Available Medicines</h2>
        
        <div class="medicine-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="medicine-card">
                    <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <h3><?= htmlspecialchars($row["name"]) ?></h3>
                    <p>💰 $<?= htmlspecialchars($row["price"]) ?></p>
                    <form method="POST">
                        <input type="hidden" name="medicine_id" value="<?= $row['id'] ?>">
                        <button type="submit">➕ Add to Cart</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
