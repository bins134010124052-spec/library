<?php
session_start();
require_once 'includes/functions.php';

$pageTitle = 'Danh sách sách';
include 'includes/header.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;
$totalBooks = getTotalBooks('', 'approved');
$totalPages = ceil($totalBooks / $limit);

$books = getBooks($limit, $offset, 'approved');
?>

<h1 class="mb-4">Tất cả sách</h1>

<div class="row">
    <?php foreach ($books as $book): ?>
        <div class="col-md-3 mb-4">
            <div class="card book-card h-100">
                <img src="<?php echo $book['image_path'] ?: 'uploads/default.jpg'; ?>" class="card-img-top book-image" alt="<?php echo sanitize($book['title']); ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo sanitize($book['title']); ?></h5>
                    <p class="card-text">Tác giả: <?php echo sanitize($book['author']); ?></p>
                    <p class="card-text fw-bold"><?php echo number_format($book['price'], 0, ',', '.'); ?> VND</p>
                    <div class="mt-auto">
                        <a href="book_detail.php?id=<?php echo $book['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        <a href="add_to_cart.php?id=<?php echo $book['id']; ?>" class="btn btn-success">Thêm vào giỏ</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>">Trang <?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include 'includes/footer.php'; ?>