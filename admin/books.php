<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/functions.php';

$pageTitle = 'Quản lý sách';
include 'header.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$status = isset($_GET['status']) ? $_GET['status'] : null;
$totalBooks = getTotalBooks('', $status);
$totalPages = ceil($totalBooks / $limit);

$books = getBooks($limit, $offset, $status);
?>

<h1 class="mb-4">Quản lý sách</h1>

<div class="mb-3">
    <form method="GET" class="d-inline">
        <label for="status">Lọc theo trạng thái:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <option value="approved" <?php echo $status == 'approved' ? 'selected' : ''; ?>>Đã duyệt</option>
            <option value="pending" <?php echo $status == 'pending' ? 'selected' : ''; ?>>Chờ duyệt</option>
            <option value="rejected" <?php echo $status == 'rejected' ? 'selected' : ''; ?>>Từ chối</option>
        </select>
    </form>
</div>

<a href="add_book.php" class="btn btn-success mb-3">Thêm sách mới</a>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên sách</th>
                <th>Tác giả</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th>Người đăng</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo $book['id']; ?></td>
                    <td><img src="<?php echo $book['image_path'] ?: '../uploads/default.jpg'; ?>" alt="Ảnh" style="width: 50px;"></td>
                    <td><?php echo sanitize($book['title']); ?></td>
                    <td><?php echo sanitize($book['author']); ?></td>
                    <td><?php echo number_format($book['price'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo $book['status']; ?></td>
                    <td><?php echo $book['user_id'] ? 'User ' . $book['user_id'] : 'Admin'; ?></td>
                    <td>
                        <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                        <?php if ($book['status'] == 'pending'): ?>
                            <a href="approve_book.php?id=<?php echo $book['id']; ?>&action=approve" class="btn btn-success btn-sm">Duyệt</a>
                            <a href="approve_book.php?id=<?php echo $book['id']; ?>&action=reject" class="btn btn-warning btn-sm">Từ chối</a>
                        <?php endif; ?>
                        <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


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