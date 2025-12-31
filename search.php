<?php
session_start();
require_once 'includes/functions.php';

$pageTitle = 'Tìm kiếm sách';
include 'includes/header.php';

$query = isset($_GET['q']) ? sanitize($_GET['q']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

$books = [];
$totalBooks = 0;
if ($query) {
    $books = searchBooks($query, $limit, $offset, 'approved');
    $totalBooks = getTotalBooks($query, 'approved');
}
$totalPages = ceil($totalBooks / $limit);
?>

<h1 class="mb-4">Tìm kiếm sách</h1>

<form method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Tìm theo tên sách hoặc tác giả" value="<?php echo sanitize($query); ?>" required>
        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
    </div>
</form>

<?php if ($query): ?>
    <h2>Kết quả cho "<?php echo sanitize($query); ?>"</h2>
    <?php if (empty($books)): ?>
        <p>Không tìm thấy sách nào.</p>
    <?php else: ?>
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
                        <a class="page-link" href="?q=<?php echo urlencode($query); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>