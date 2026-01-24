<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

echo "<h2>Debug: Check Password Hashing</h2>";

// Test password hashing
$test_password = "test123";
$hashed = hashPassword($test_password);

echo "<h3>1. Hashing Test:</h3>";
echo "Original password: <strong>$test_password</strong><br>";
echo "Hashed password: <strong>" . substr($hashed, 0, 30) . "...</strong><br>";
echo "Verify result: " . (verifyPassword($test_password, $hashed) ? "✓ TRUE" : "✗ FALSE") . "<br><br>";

// Check admin in database
echo "<h3>2. Check Admin Accounts in Database:</h3>";
try {
    $stmt = $pdo->query("SELECT id, username, email, password FROM admins");
    $admins = $stmt->fetchAll();
    
    if (empty($admins)) {
        echo "No admin accounts found!<br>";
    } else {
        foreach ($admins as $admin) {
            echo "<strong>Username:</strong> " . $admin['username'] . "<br>";
            echo "<strong>Email:</strong> " . $admin['email'] . "<br>";
            echo "<strong>Password Hash:</strong> " . substr($admin['password'], 0, 30) . "...<br>";
            
            // Try to verify with some common passwords
            echo "<strong>Test verify:</strong><br>";
            $test_passwords = ['admin123', 'test123', 'password123', $admin['username']];
            foreach ($test_passwords as $pwd) {
                $result = verifyPassword($pwd, $admin['password']);
                echo "  - '$pwd': " . ($result ? "✓ MATCH" : "✗ NO") . "<br>";
            }
            echo "<br>";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
