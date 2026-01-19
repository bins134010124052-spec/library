<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$bookId = (int)$_GET['id'];

// Verify book belongs to user
global $pdo;
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? AND user_id = ?");
$stmt->execute([$bookId, $_SESSION['user']]);
$book = $stmt->fetch();

if (!$book) {
    $_SESSION['error'] = 'Sách không tồn tại hoặc bạn không có quyền xóa.';
    header('Location: dashboard.php');
    exit;
}

// Delete the book
if (deleteBookByUser($bookId, $_SESSION['user'])) {
    $_SESSION['success'] = 'Xóa sách thành công!';
} else {
    $_SESSION['error'] = 'Có lỗi xảy ra khi xóa sách.';
}

header('Location: dashboard.php');
exit;
?>
