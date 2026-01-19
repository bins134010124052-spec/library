<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$bookId = (int)$_GET['id'];

// Verify book belongs to user
global $pdo;
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? AND user_id = ?");
$stmt->execute([$bookId, $_SESSION['user']]);
$book = $stmt->fetch();

if (!$book) {
    header('Location: dashboard.php');
    exit;
}

$user = getUserById($_SESSION['user']);
$pageTitle = 'Chỉnh sửa sách';
include '../includes/header.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title'] ?? '');
    $author = sanitize($_POST['author'] ?? '');
    $publisher = sanitize($_POST['publisher'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $description = sanitize($_POST['description'] ?? '');

    if (empty($title) || empty($author) || $price <= 0) {
        $errors[] = 'Vui lòng nhập đầy đủ thông tin và giá phải > 0.';
    }

    $imagePath = $book['image_path'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] != 0) {
            $errors[] = 'Lỗi upload file: ' . $_FILES['image']['error'];
        } elseif (!$imagePath = uploadImage($_FILES['image'])) {
            $errors[] = 'Lỗi upload ảnh. Chỉ chấp nhận JPG/PNG, kích thước < 5MB.';
        }
    }

    if (empty($errors)) {
        if (updateBook($bookId, ['title' => $title, 'author' => $author, 'publisher' => $publisher, 'year' => 0, 'price' => $price, 'description' => $description], $imagePath)) {
            $success = true;
            $book = getBookById($bookId);
        } else {
            $errors[] = 'Lỗi cập nhật sách.';
        }
    }
}
?>

<h1 class="mb-4">Chỉnh sửa sách</h1>

<?php if ($success): ?>
    <div class="alert alert-success">Cập nhật sách thành công! <a href="dashboard.php">Quay lại dashboard</a></div>
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

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Tên sách *</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo sanitize($book['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Tác giả *</label>
            <input type="text" class="form-control" id="author" name="author" value="<?php echo sanitize($book['author']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Nhà xuất bản</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo sanitize($book['publisher']); ?>">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá *</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $book['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo sanitize($book['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Ảnh bìa (JPG/PNG)</label>
            <?php if ($book['image_path']): ?>
                <div class="mb-2">
                    <img src="../<?php echo $book['image_path']; ?>" alt="Ảnh hiện tại" style="max-width: 200px; height: auto;">
                </div>
            <?php endif; ?>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật sách</button>
        <a href="dashboard.php" class="btn btn-secondary">Hủy</a>
    </form>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
