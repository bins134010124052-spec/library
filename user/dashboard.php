<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

$user = getUserById($_SESSION['user']);
$pageTitle = 'Dashboard Người dùng';
include '../includes/header.php';
?>

<h1>Chào mừng, <?php echo sanitize($user['name']); ?>!</h1>
<p>Đây là trang dashboard của bạn.</p>

<a href="post_book.php" class="btn btn-primary mb-3">Đăng sách bán</a>

<h2>Lịch sử đơn hàng</h2>
<?php
$orders = getOrdersByUserId($_SESSION['user']);
if (empty($orders)): ?>
    <p>Bạn chưa có đơn hàng nào.</p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['created_at']; ?></td>
                        <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo $order['status']; ?></td>
                        <td><a href="order_detail.php?order_id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">Xem chi tiết</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>