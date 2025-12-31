<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/functions.php';

$pageTitle = 'Quản lý đơn hàng';
include 'header.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$totalOrders = getTotalOrders();
$totalPages = ceil($totalOrders / $limit);

$orders = getOrders($limit, $offset);
?>

<h1 class="mb-4">Quản lý đơn hàng</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Email</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày đặt</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo sanitize($order['customer_name']); ?></td>
                    <td><?php echo sanitize($order['email']); ?></td>
                    <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo $order['status']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                    <td>
                        <a href="order_detail.php?id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">Chi tiết</a>
                        <form method="POST" action="update_order_status.php" class="d-inline">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <select name="status" class="form-select form-select-sm d-inline" style="width: auto;">
                                <option value="Đang xử lý" <?php echo $order['status'] == 'Đang xử lý' ? 'selected' : ''; ?>>Đang xử lý</option>
                                <option value="Đã giao" <?php echo $order['status'] == 'Đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                                <option value="Hoàn thành" <?php echo $order['status'] == 'Hoàn thành' ? 'selected' : ''; ?>>Hoàn thành</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>