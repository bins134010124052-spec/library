<?php
session_start();
require_once 'includes/functions.php';

if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    if (isset($_SESSION['user'])) {
        header('Location: user/dashboard.php');
    } else {
        header('Location: admin/dashboard.php');
    }
    exit;
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
    } elseif (!isValidEmail($email)) {
        $errors[] = 'Email không hợp lệ.';
    } elseif (!isValidPhone($phone)) {
        $errors[] = 'Số điện thoại không hợp lệ.';
    } elseif ($password !== $confirm_password) {
        $errors[] = 'Mật khẩu xác nhận không khớp.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    } elseif (getUserByEmail($email)) {
        $errors[] = 'Email đã được sử dụng.';
    } else {
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password
        ];
        if (registerUser($data)) {
            // Auto login after registration
            $user = loginUser($data['email'], $data['password']);
            if ($user) {
                $_SESSION['user'] = $user['id'];
                header('Location: user/dashboard.php');
                exit;
            } else {
                $errors[] = 'Đăng ký thành công nhưng không thể đăng nhập tự động. Vui lòng đăng nhập thủ công.';
            }
        } else {
            $errors[] = 'Có lỗi xảy ra. Vui lòng thử lại.';
        }
    }
}

$pageTitle = 'Đăng ký';
include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Đăng ký tài khoản</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="showPassword">
                            <label class="form-check-label" for="showPassword">
                                Hiển thị mật khẩu
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="showConfirmPassword">
                            <label class="form-check-label" for="showConfirmPassword">
                                Hiển thị mật khẩu
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('showPassword').addEventListener('change', function() {
    var passwordField = document.getElementById('password');
    passwordField.type = this.checked ? 'text' : 'password';
});

document.getElementById('showConfirmPassword').addEventListener('change', function() {
    var passwordField = document.getElementById('confirm_password');
    passwordField.type = this.checked ? 'text' : 'password';
});
</script>

<?php include 'includes/footer.php'; ?>