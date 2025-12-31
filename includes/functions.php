<?php
// functions.php - Utility functions

require_once 'config.php';

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validate phone (simple check)
function isValidPhone($phone) {
    return preg_match('/^[0-9+\-\s()]+$/', $phone);
}

// Hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Get book by ID
function getBookById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Get all books with pagination
function getBooks($limit = 10, $offset = 0, $status = null) {
    global $pdo;
    $sql = "SELECT * FROM books";
    $params = [];
    if ($status) {
        $sql .= " WHERE status = ?";
        $params[] = $status;
    }
    $sql .= " LIMIT ? OFFSET ?";
    $stmt = $pdo->prepare($sql);
    $i = 1;
    if ($status) {
        $stmt->bindValue($i++, $status, PDO::PARAM_STR);
    }
    $stmt->bindValue($i++, $limit, PDO::PARAM_INT);
    $stmt->bindValue($i++, $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Search books
function searchBooks($query, $limit = 10, $offset = 0, $status = 'approved') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM books WHERE (title LIKE ? OR author LIKE ?) AND status = ? LIMIT ? OFFSET ?");
    $search = "%$query%";
    $stmt->bindParam(1, $search, PDO::PARAM_STR);
    $stmt->bindParam(2, $search, PDO::PARAM_STR);
    $stmt->bindParam(3, $status, PDO::PARAM_STR);
    $stmt->bindParam(4, $limit, PDO::PARAM_INT);
    $stmt->bindParam(5, $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Get total books
function getTotalBooks($query = '', $status = null) {
    global $pdo;
    if ($query) {
        $sql = "SELECT COUNT(*) FROM books WHERE (title LIKE ? OR author LIKE ?)";
        $params = ["%$query%", "%$query%"];
        if ($status) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } else {
        $sql = "SELECT COUNT(*) FROM books";
        if ($status) {
            $sql .= " WHERE status = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$status]);
        } else {
            $stmt = $pdo->query($sql);
        }
    }
    return $stmt->fetchColumn();
}

// Add to cart (session)
function addToCart($bookId, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $book = getBookById($bookId);
    if ($book) {
        if (isset($_SESSION['cart'][$bookId])) {
            $_SESSION['cart'][$bookId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$bookId] = [
                'title' => $book['title'],
                'price' => $book['price'],
                'quantity' => $quantity,
                'image_path' => $book['image_path']
            ];
        }
    }
}

// Update cart quantity
function updateCart($bookId, $quantity) {
    if (isset($_SESSION['cart'][$bookId])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$bookId]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$bookId]);
        }
    }
}

// Remove from cart
function removeFromCart($bookId) {
    if (isset($_SESSION['cart'][$bookId])) {
        unset($_SESSION['cart'][$bookId]);
    }
}

// Get cart total
function getCartTotal() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

// Get cart items count
function getCartCount() {
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}

// Create order
function createOrder($customerData, $cart, $userId = null) {
    global $pdo;
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, customer_name, email, phone, address, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $customerData['name'], $customerData['email'], $customerData['phone'], $customerData['address'], getCartTotal()]);
        $orderId = $pdo->lastInsertId();

        foreach ($cart as $bookId => $item) {
            $stmt = $pdo->prepare("INSERT INTO order_details (order_id, book_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");
            $stmt->execute([$orderId, $bookId, $item['quantity'], $item['price']]);
        }

        $pdo->commit();
        return $orderId;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

// Get orders for admin
function getOrders($limit = 10, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM orders ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bindParam(1, $limit, PDO::PARAM_INT);
    $stmt->bindParam(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Get orders by user ID
function getOrdersByUserId($userId, $limit = 10, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bindParam(1, $userId, PDO::PARAM_INT);
    $stmt->bindParam(2, $limit, PDO::PARAM_INT);
    $stmt->bindParam(3, $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Get total orders
function getTotalOrders() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM orders");
    return $stmt->fetchColumn();
}

// Get order details
function getOrderDetails($orderId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT od.*, b.title, b.image_path FROM order_details od JOIN books b ON od.book_id = b.id WHERE od.order_id = ?");
    $stmt->execute([$orderId]);
    return $stmt->fetchAll();
}

// Update order status
function updateOrderStatus($orderId, $status) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    return $stmt->execute([$status, $orderId]);
}

// Add book (admin or user)
function addBook($data, $imagePath = null, $userId = null, $status = 'approved') {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO books (title, author, publisher, year, price, description, image_path, user_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$data['title'], $data['author'], $data['publisher'], $data['year'], $data['price'], $data['description'], $imagePath, $userId, $status]);
}

// Update book
function updateBook($id, $data, $imagePath = null) {
    global $pdo;
    $sql = "UPDATE books SET title=?, author=?, publisher=?, year=?, price=?, description=?";
    $params = [$data['title'], $data['author'], $data['publisher'], $data['year'], $data['price'], $data['description']];
    if ($imagePath) {
        $sql .= ", image_path=?";
        $params[] = $imagePath;
    }
    $sql .= " WHERE id=?";
    $params[] = $id;
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

// Update book status
function updateBookStatus($id, $status) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE books SET status = ? WHERE id = ?");
    return $stmt->execute([$status, $id]);
}

// Upload image
function uploadImage($file) {
    $targetDir = __DIR__ . "/../uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $targetFile = $targetDir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }

    // Check file size (5MB max)
    if ($file["size"] > 5000000) {
        return false;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return false;
    }

    // Generate unique name
    $newName = uniqid() . "." . $imageFileType;
    $targetFile = $targetDir . $newName;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return 'uploads/' . $newName;
    } else {
        return false;
    }
}

// User functions
function registerUser($data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$data['name'], $data['email'], $data['phone'], hashPassword($data['password'])]);
}

function loginUser($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && verifyPassword($password, $user['password'])) {
        return $user;
    }
    return false;
}

function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getUserByEmail($email) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}
?>