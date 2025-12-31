<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
$action = $_GET['action'] ?? '';

if (!$id || !in_array($action, ['approve', 'reject'])) {
    header('Location: books.php');
    exit;
}

$status = $action == 'approve' ? 'approved' : 'rejected';

if (updateBookStatus($id, $status)) {
    header('Location: books.php?status=pending');
} else {
    echo "Lỗi cập nhật trạng thái.";
}
?>