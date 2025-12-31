<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/functions.php';

$pageTitle = 'Dashboard Admin';
include 'header.php';
?>

<h1 class="mb-4">Quản trị viên</h1>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Quản lý sách</h5>
            </div>
            <div class="card-body">
                <a href="books.php" class="btn btn-primary">Xem tất cả sách</a>
                <a href="add_book.php" class="btn btn-success">Thêm sách mới</a>
                <a href="books.php?status=pending" class="btn btn-warning">Duyệt sách người dùng</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Quản lý đơn hàng</h5>
            </div>
            <div class="card-body">
                <a href="orders.php" class="btn btn-primary">Xem đơn hàng</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>