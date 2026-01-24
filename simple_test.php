<?php
echo "<h2>Debug Login Issue</h2>";

// Test 1: Connection
echo "<h3>1. Database Connection Test:</h3>";
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=u574344867_thuviensach;charset=utf8",
        "u574344867_wepsach",
        "H1=abGHw5M|w"
    );
    echo "✓ Connected<br>";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Check admin table
echo "<h3>2. Admin Table Check:</h3>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM admins");
    $row = $stmt->fetch();
    echo "Total admins: " . $row['cnt'] . "<br>";
    
    if ($row['cnt'] > 0) {
        $stmt = $pdo->query("SELECT username FROM admins LIMIT 1");
        $admin = $stmt->fetch();
        echo "First admin username: " . $admin['username'] . "<br>";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "<br>";
}

// Test 3: Test password_verify
echo "<h3>3. Password Hash Test:</h3>";
$hash = '$2y$10$FqfdCPqVDyKoEWgpFImUW.T8R5o98GTTmn.fSPifCMxRvEVJeTt1W';
$pwd = 'admin123';
$result = password_verify($pwd, $hash);
echo "Test password_verify('admin123', hash): " . ($result ? "✓ TRUE" : "✗ FALSE") . "<br>";

echo "<br><strong>Status:</strong> If all tests pass, the system is working correctly!<br>";
?>
