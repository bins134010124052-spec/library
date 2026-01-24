<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check admin table
$stmt = $pdo->query("SELECT * FROM admins");
$admins = $stmt->fetchAll();

echo "<h2>Admin Accounts:</h2>";
echo "<pre>";
print_r($admins);
echo "</pre>";

// Test password verification
if (!empty($admins)) {
    $admin = $admins[0];
    echo "<h3>Testing password verification for: " . $admin['username'] . "</h3>";
    echo "Stored hash: " . substr($admin['password'], 0, 20) . "...<br>";
    
    // Test with 'admin123'
    $test_password = 'admin123';
    $result = password_verify($test_password, $admin['password']);
    echo "Verify 'admin123': " . ($result ? "✓ TRUE" : "✗ FALSE") . "<br>";
    
    // Test if hash is valid
    $info = password_get_info($admin['password']);
    echo "Hash algorithm: " . $info['alg'] . "<br>";
    echo "Hash needs rehash: " . ($password_needs_rehash($admin['password'], PASSWORD_DEFAULT) ? "YES" : "NO") . "<br>";
}
?>
