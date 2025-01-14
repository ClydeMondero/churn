<?php
$host = 'localhost';    // Database host, typically 'localhost' for XAMPP
$db = 'churn';   // The database name you created
$user = 'root';         // Default XAMPP username for MySQL
$pass = '';             // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
