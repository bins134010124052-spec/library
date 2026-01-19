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

<h2>Lịch sử đơn hàng của bạn</h2>
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
                        <td>
                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#orderDetail-<?php echo $order['id']; ?>" aria-expanded="false" aria-controls="orderDetail-<?php echo $order['id']; ?>">
                                Xem chi tiết
                            </button>
                        </td>
                    </tr>
                    <tr class="collapse" id="orderDetail-<?php echo $order['id']; ?>">
                        <td colspan="5">
                            <div class="card card-body">
                                <h5>Chi tiết đơn hàng #<?php echo $order['id']; ?></h5>
                                <ul class="list-group">
                                    <?php
                                    $orderDetails = getOrderDetails($order['id']);
                                    foreach ($orderDetails as $item):
                                    ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo htmlspecialchars($item['title']); ?> (x<?php echo $item['quantity']; ?>)
                                            <span class="badge bg-primary rounded-pill"><?php echo number_format($item['price_at_purchase'], 0, ',', '.'); ?> VND</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>