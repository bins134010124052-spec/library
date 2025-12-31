<?php
session_start();
require_once 'includes/functions.php';

if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

if (!isset($_SESSION['user'])) {
    header('Location: login.php?redirect=checkout.php');
    exit;
}

$user = getUserById($_SESSION['user']);

$pageTitle = 'Thanh toán';
include 'includes/header.php';

$errors = [];
$success = false;
$orderId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = sanitize($_POST['address'] ?? '');

    if (empty($address)) $errors[] = 'Địa chỉ không được để trống.';

    if (empty($errors)) {
        $customerData = ['name' => $user['name'], 'email' => $user['email'], 'phone' => $user['phone'], 'address' => $address];
        $orderId = createOrder($customerData, $_SESSION['cart'], $_SESSION['user']);
        if ($orderId) {
            $success = true;
            unset($_SESSION['cart']); // Clear cart
        } else {
            $errors[] = 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.';
        }
    }
}
?>

<h1 class="mb-4">Thanh toán</h1>

<?php if ($success): ?>
    <div class="alert alert-success">
        <h4>Đặt hàng thành công!</h4>
        <p>Mã đơn hàng của bạn: <strong><?php echo $orderId; ?></strong></p>
        <p>Cảm ơn bạn đã mua hàng. Chúng tôi sẽ liên hệ sớm.</p>
        <a href="index.php" class="btn btn-primary">Về trang chủ</a>
    </div>
<?php else: ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <h3>Thông tin đơn hàng</h3>
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
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td><?php echo sanitize($item['title']); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <h4>Tổng tiền: <?php echo number_format(getCartTotal(), 0, ',', '.'); ?> VND</h4>
        </div>
        <div class="col-md-4">
            <h3>Địa chỉ giao hàng</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ giao hàng *</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success btn-lg">Đặt hàng</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>