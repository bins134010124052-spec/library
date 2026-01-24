<?php
// includes/config.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'u574344867_thuviensach');
define('DB_USER', 'u574344867_wepsach');
define('DB_PASS', 'H1=abGHw5M|w');

// $user = "root"; $pass = "";$db   = "wepsach";


try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
