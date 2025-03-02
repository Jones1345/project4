<?php
session_start();
include "db.php";

if (!isset($_SESSION["user"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Check if medicine is in purchases
    $checkQuery = "SELECT * FROM purchases WHERE medicine_id = '$id'";
    $checkResult = $conn->query($checkQuery);
    $imageQuery = $conn->query("SELECT image FROM medicines WHERE id = '$id'");

    if (!$imageQuery) {
        die("<p class='error'>Error in SQL query: " . $conn->error . "</p>");
    }
    
    if ($imageQuery->num_rows > 0) {
        $imageRow = $imageQuery->fetch_assoc();
        $imagePath = "uploads/" . $imageRow['image'];
    
        // Delete the medicine from the database
        $deleteQuery = "DELETE FROM medicines WHERE id = '$id'";
        if ($conn->query($deleteQuery)) {
            echo "<p class='success'>Medicine deleted successfully!</p>";
    
            // Delete image if not default
            if (!empty($imageRow['image']) && $imageRow['image'] != 'default.jpg' && file_exists($imagePath)) {
                unlink($imagePath);
            }
        } else {
            echo "<p class='error'>Error deleting medicine: " . $conn->error . "</p>";
        }
    } else {
        echo "<p class='error'>Error: Medicine not found!</p>";
    }
}

// Fetch medicines
$result = $conn->query("SELECT * FROM medicines");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Pharmacy</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <nav>
            <h1>🛠 Admin Panel - Manage Medicines</h1>
            <div class="nav-links">
                <a href="index.php">🏠 Home</a>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </nav>

        <h2>➕ Add Medicine</h2>
        <form method="post" enctype="multipart/form-data" class="form-container">
            <input type="text" name="name" placeholder="Medicine Name" required>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <input type="number" name="stock" placeholder="Stock Quantity" required>
            <input type="date" name="expiry_date" required>
            <input type="file" name="image" accept="image/*">
            <button type="submit" name="add_medicine">Add Medicine</button>
        </form>

        <h2>📦 Existing Medicines</h2>
        <div class="medicine-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="medicine-card">
                    <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <h3><?= htmlspecialchars($row["name"]) ?></h3>
                    <p>💰 $<?= htmlspecialchars($row["price"]) ?></p>
                    <p>📦 Stock: <?= htmlspecialchars($row["stock"]) ?></p>
                    <p>🗓 Expiry: <?= htmlspecialchars($row["expiry_date"]) ?></p>
                    <a href="admin.php?delete=<?= $row['id'] ?>" 
                       onclick="return confirm('Are you sure you want to delete this medicine?');"
                       class="delete-button">
                       ❌ Delete
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
