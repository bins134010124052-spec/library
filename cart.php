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

<?php include 'includes/footer.php'; ?>