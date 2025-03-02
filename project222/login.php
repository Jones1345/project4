<?php
session_start();
include "db.php";

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = md5($_POST["password"]); // MD5-hashed password check

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION["user"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] == "admin") {
            header("Location: admin.php"); // Redirect admin
        } else {
            header("Location: index.php"); // Redirect user
        }
        exit;
    } else {
        $error_message = "❌ Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pharmacy</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <form method="post" class="login-form">
            <h2>🔒 Login</h2>

            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= $error_message ?></p>
            <?php endif; ?>

            <input type="text" name="username" placeholder="👤 Username" required>
            <input type="password" name="password" placeholder="🔑 Password" required>
            <button type="submit">Login</button>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>