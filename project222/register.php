<?php
include "db.php";

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = md5($_POST["password"]); // MD5 for password (not the most secure)
    $role = "user"; // Default role

    // Check if username or email already exists
    $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $error_message = "⚠️ Username or Email already exists!";
    } else {
        // Insert user
        $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
        if ($conn->query($query) === TRUE) {
            $success_message = "✅ Registration successful! <a href='login.php'>Login here</a>";
        } else {
            $error_message = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pharmacy</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="login-container">
        <form method="post" class="login-form">
            <h2>📝 Register</h2>

            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= $error_message ?></p>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <p class="success-message"><?= $success_message ?></p>
            <?php endif; ?>

            <input type="text" name="username" placeholder="👤 Username" required>
            <input type="email" name="email" placeholder="📧 Email" required>
            <input type="password" name="password" placeholder="🔑 Password" required>
            <button type="submit">Register</button>

            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
