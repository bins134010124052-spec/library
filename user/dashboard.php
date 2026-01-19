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

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<a href="post_book.php" class="btn btn-primary mb-3">Đăng sách bán</a>

<h2>Sách của tôi</h2>
<?php
$userBooks = getBooksByUserId($_SESSION['user']);
if (empty($userBooks)): ?>
    <p>Bạn chưa đăng sách nào. <a href="post_book.php">Đăng sách ngay</a></p>
<?php else: ?>
    <div class="table-responsive mb-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userBooks as $book): ?>
                    <tr>
                        <td><img src="../<?php echo $book['image_path'] ?: 'uploads/default.jpg'; ?>" alt="<?php echo sanitize($book['title']); ?>" style="max-width: 50px; height: auto;"></td>
                        <td><?php echo sanitize($book['title']); ?></td>
                        <td><?php echo sanitize($book['author']); ?></td>
                        <td><?php echo number_format($book['price'], 0, ',', '.'); ?> VND</td>
                        <td><span class="badge bg-<?php echo $book['status'] == 'approved' ? 'success' : ($book['status'] == 'pending' ? 'warning' : 'danger'); ?>"><?php echo $book['status'] == 'approved' ? 'Đã phê duyệt' : ($book['status'] == 'pending' ? 'Chờ phê duyệt' : 'Từ chối'); ?></span></td>
                        <td>
                            <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sách này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

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