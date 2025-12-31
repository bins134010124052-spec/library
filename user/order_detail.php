<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header('Location: dashboard.php');
    exit;
}

global $pdo;
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$_GET['order_id'], $_SESSION['user']]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: dashboard.php');
    exit;
}

$orderDetails = getOrderDetails($order['id']);

$pageTitle = 'Chi tiết đơn hàng #' . $order['id'];
include '../includes/header.php';
?>

<h1 class="mb-4">Chi tiết đơn hàng #<?php echo $order['id']; ?></h1>

<div class="row">
    <div class="col-md-6">
        <h3>Thông tin khách hàng</h3>
        <p><strong>Tên:</strong> <?php echo sanitize($order['customer_name']); ?></p>
        <p><strong>Email:</strong> <?php echo sanitize($order['email']); ?></p>
        <p><strong>SĐT:</strong> <?php echo sanitize($order['phone']); ?></p>
        <p><strong>Địa chỉ:</strong> <?php echo nl2br(sanitize($order['address'])); ?></p>
        <p><strong>Trạng thái:</strong> <?php echo $order['status']; ?></p>
        <p><strong>Ngày đặt:</strong> <?php echo $order['created_at']; ?></p>
    </div>
    <div class="col-md-6">
        <h3>Chi tiết sản phẩm</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sách</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderDetails as $detail): ?>
                        <tr>
                            <td><?php echo sanitize($detail['title']); ?></td>
                            <td><?php echo $detail['quantity']; ?></td>
                            <td><?php echo number_format($detail['price_at_purchase'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($detail['price_at_purchase'] * $detail['quantity'], 0, ',', '.'); ?> VND</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <h4>Tổng tiền: <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</h4>
    </div>
</div>

<a href="dashboard.php" class="btn btn-secondary">Quay lại Dashboard</a>

<?php include '../includes/footer.php'; ?>