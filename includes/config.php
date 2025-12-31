<?php
// config.php - Database configuration

define('DB_HOST', 'localhost');
define('DB_NAME', 'wepsach');
define('DB_USER', 'root'); // Change if needed
define('DB_PASS', ''); // Change if needed

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>