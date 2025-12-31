<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: orders.php');
    exit;
}

global $pdo;
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$_GET['id']]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: orders.php');
    exit;
}

$orderDetails = getOrderDetails($order['id']);

$pageTitle = 'Chi tiết đơn hàng #' . $order['id'];
include 'header.php';
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
        <form method="POST" action="update_order_status.php" class="mt-3">
            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
            <div class="mb-3">
                <label for="status" class="form-label">Cập nhật trạng thái:</label>
                <select name="status" id="status" class="form-select">
                    <option value="Đang xử lý" <?php echo $order['status'] == 'Đang xử lý' ? 'selected' : ''; ?>>Đang xử lý</option>
                    <option value="Đã giao" <?php echo $order['status'] == 'Đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                    <option value="Hoàn thành" <?php echo $order['status'] == 'Hoàn thành' ? 'selected' : ''; ?>>Hoàn thành</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
        </form>
        <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
    </div>
    <div class="col-md-6">
        <h3>Chi tiết đơn hàng</h3>
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

<a href="orders.php" class="btn btn-secondary">Quay lại</a>

<?php include 'footer.php'; ?>