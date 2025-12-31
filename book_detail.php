<?php
session_start();
require_once 'includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$book = getBookById($_GET['id']);
if (!$book) {
    header('Location: index.php');
    exit;
}

$pageTitle = sanitize($book['title']);
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-4">
        <img src="<?php echo $book['image_path'] ?: 'uploads/default.jpg'; ?>" class="img-fluid" alt="<?php echo sanitize($book['title']); ?>">
    </div>
    <div class="col-md-8">
        <h1><?php echo sanitize($book['title']); ?></h1>
        <p><strong>Tác giả:</strong> <?php echo sanitize($book['author']); ?></p>
        <p><strong>Nhà xuất bản:</strong> <?php echo sanitize($book['publisher']); ?></p>
        <p><strong>Năm xuất bản:</strong> <?php echo $book['year']; ?></p>
        <p><strong>Giá:</strong> <?php echo number_format($book['price'], 0, ',', '.'); ?> VND</p>
        <p><strong>Mô tả:</strong></p>
        <p><?php echo nl2br(sanitize($book['description'])); ?></p>
        <a href="add_to_cart.php?id=<?php echo $book['id']; ?>" class="btn btn-success btn-lg">Thêm vào giỏ hàng</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>