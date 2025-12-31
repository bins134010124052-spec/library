<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

$user = getUserById($_SESSION['user']);
$pageTitle = 'Đăng sách bán';
include '../includes/header.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title'] ?? '');
    $author = sanitize($_POST['author'] ?? '');
    $publisher = sanitize($_POST['publisher'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);
    $description = sanitize($_POST['description'] ?? '');

    if (empty($title) || empty($author) || $price <= 0) {
        $errors[] = 'Vui lòng nhập đầy đủ thông tin và giá phải > 0.';
    }

    $imagePath = null;
    if (isset($_FILES['image'])) {
        if ($_FILES['image']['error'] != 0) {
            $errors[] = 'Lỗi upload file: ' . $_FILES['image']['error'] . ' (0=ok, 1=too big, 2>max, 3=partial, 4=no file)';
        } elseif (!$imagePath = uploadImage($_FILES['image'])) {
            $errors[] = 'Lỗi upload ảnh. Chỉ chấp nhận JPG/PNG, kích thước < 5MB.';
        }
    }

    if (empty($errors)) {
        if (addBook(['title' => $title, 'author' => $author, 'publisher' => $publisher, 'year' => $year, 'price' => $price, 'description' => $description], $imagePath, $_SESSION['user'], 'pending')) {
            $success = true;
        } else {
            $errors[] = 'Lỗi đăng sách.';
        }
    }
}
?>

<h1 class="mb-4">Đăng sách bán</h1>

<?php if ($success): ?>
    <div class="alert alert-success">Đăng sách thành công! Chờ admin phê duyệt. <a href="dashboard.php">Quay lại dashboard</a></div>
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
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Tác giả *</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Nhà xuất bản</label>
            <input type="text" class="form-control" id="publisher" name="publisher">
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Năm xuất bản</label>
            <input type="number" class="form-control" id="year" name="year">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá *</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Ảnh bìa (JPG/PNG)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Đăng sách</button>
        <a href="dashboard.php" class="btn btn-secondary">Hủy</a>
    </form>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>