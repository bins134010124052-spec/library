<?php
session_start();
require_once 'includes/functions.php';

$pageTitle = 'Giỏ hàng';
include 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$total = getCartTotal();
?>

<h1 class="mb-4">Giỏ hàng của bạn</h1>

<?php if (empty($cart)): ?>
    <p>Giỏ hàng trống. <a href="books.php">Tiếp tục mua sắm</a></p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sách</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $id => $item): ?>
                    <tr class="cart-item">
                        <td><img src="<?php echo $item['image_path'] ?: 'uploads/default.jpg'; ?>" alt="<?php echo sanitize($item['title']); ?>"></td>
                        <td><?php echo sanitize($item['title']); ?></td>
                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                        <td>
                            <form method="POST" action="update_cart.php" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control d-inline" style="width: 80px;">
                                <button type="submit" class="btn btn-sm btn-secondary">Cập nhật</button>
                            </form>
                        </td>
                        <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                        <td><a href="remove_from_cart.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Xóa</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-end">
        <h4>Tổng tiền: <?php echo number_format($total, 0, ',', '.'); ?> VND</h4>
        <a href="checkout.php" class="btn btn-primary btn-lg">Thanh toán</a>
    </div>
<?php endif; ?>

<hr class="my-5">

<h2 class="mb-4">Đơn hàng của bạn</h2>

<?php
$orders = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = sanitize($_POST['email']);
    if (isValidEmail($email)) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE email = ? ORDER BY created_at DESC");
        $stmt->execute([$email]);
        $orders = $stmt->fetchAll();
        if (empty($orders)) {
            $message = 'Không tìm thấy đơn hàng nào với email này.';
        }
    } else {
        $message = 'Email không hợp lệ.';
    }
} elseif (isset($_SESSION['customer_email'])) {
    // Nếu đã có email trong session (sau đặt hàng), tự động hiển thị
    $email = $_SESSION['customer_email'];
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE email = ? ORDER BY created_at DESC");
    $stmt->execute([$email]);
    $orders = $stmt->fetchAll();
}
?>

<?php if (!isset($_SESSION['customer_email']) || $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn để xem đơn hàng" required value="<?php echo isset($_SESSION['customer_email']) ? sanitize($_SESSION['customer_email']) : ''; ?>">
            <button class="btn btn-primary" type="submit">Xem đơn hàng</button>
        </div>
    </form>
<?php endif; ?>

<?php if ($message): ?>
    <div class="alert alert-info"><?php echo $message; ?></div>
<?php endif; ?>

<?php if (!empty($orders)): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo sanitize($order['customer_name']); ?></td>
                        <td><?php echo sanitize($order['email']); ?></td>
                        <td><?php echo sanitize($order['phone']); ?></td>
                        <td><?php echo sanitize($order['address']); ?></td>
                        <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo $order['status']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                        <td><a href="order_detail.php?id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">Xem chi tiết</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>