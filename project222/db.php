<?php
$host = "localhost";
$user = "root"; // Change if using another MySQL user
$pass = "";
$dbname = "pharmacy_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>