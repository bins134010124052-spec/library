<?php
// Test database connection
echo "<h2>Database Connection Test</h2>";

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=u574344867_thuviensach;charset=utf8",
        "u574344867_wepsach",
        "H1=abGHw5M|w",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    echo "✓ Database connection successful!<br><br>";
    
    // Check admin table
    echo "<h3>Admin Accounts:</h3>";
    $stmt = $pdo->query("SELECT id, username, email FROM admins");
    $admins = $stmt->fetchAll();
    
    if (empty($admins)) {
        echo "No admin accounts found!<br>";
    } else {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th></tr>";
        foreach ($admins as $admin) {
            echo "<tr>";
            echo "<td>" . $admin['id'] . "</td>";
            echo "<td>" . $admin['username'] . "</td>";
            echo "<td>" . $admin['email'] . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    }
    
    // Test password verification
    if (!empty($admins)) {
        echo "<h3>Password Verification Test:</h3>";
        $admin = $admins[0];
        
        // Test with some passwords
        $test_passwords = ['admin123', 'test123', 'password'];
        foreach ($test_passwords as $pwd) {
            $result = password_verify($pwd, $admin['password'] ?? '');
            echo "Password '$pwd' for user '{$admin['username']}': " . ($result ? "✓ MATCH" : "✗ NO MATCH") . "<br>";
        }
    }
    
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage();
}
?>
