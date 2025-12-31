<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: books.php');
    exit;
}

$book = getBookById($_GET['id']);
if (!$book) {
    header('Location: books.php');
    exit;
}

$pageTitle = 'Sửa sách';
include 'header.php';

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

    $imagePath = $book['image_path'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $newImage = uploadImage($_FILES['image']);
        if ($newImage) {
            $imagePath = $newImage;
        } else {
            $errors[] = 'Lỗi upload ảnh.';
        }
    }

    if (empty($errors)) {
        if (updateBook($book['id'], ['title' => $title, 'author' => $author, 'publisher' => $publisher, 'year' => $year, 'price' => $price, 'description' => $description], $imagePath)) {
            $success = true;
            $book = getBookById($book['id']); // Refresh data
        } else {
            $errors[] = 'Lỗi cập nhật sách.';
        }
    }
}
?>

<h1 class="mb-4">Sửa sách</h1>

<?php if ($success): ?>
    <div class="alert alert-success">Cập nhật sách thành công!</div>
<?php endif; ?>

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
        <label for="year" class="form-label">Năm xuất bản</label>
        <input type="number" class="form-control" id="year" name="year" value="<?php echo $book['year']; ?>">
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
        <label for="image" class="form-label">Ảnh bìa (JPG/PNG) - Để trống nếu không đổi</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <?php if ($book['image_path']): ?>
            <img src="<?php echo $book['image_path']; ?>" alt="Current image" style="width: 100px; margin-top: 10px;">
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="books.php" class="btn btn-secondary">Hủy</a>
</form>

<?php include 'footer.php'; ?>