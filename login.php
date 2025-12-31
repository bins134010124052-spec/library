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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $account = sanitize($_POST['account'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($account) || empty($password)) {
        $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        if (strpos($account, '@') !== false) {
            // Treat as email, check users
            $user = loginUser($account, $password);
            if ($user) {
                $_SESSION['user'] = $user['id'];
                $redirect = $_GET['redirect'] ?? 'index.php';
                header('Location: ' . $redirect);
                exit;
            } else {
                $errors[] = 'Tài khoản hoặc mật khẩu không đúng.';
            }
        } else {
            // Treat as username, check admins
            global $pdo;
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$account]);
            $admin = $stmt->fetch();
            if ($admin && verifyPassword($password, $admin['password'])) {
                $_SESSION['admin'] = $admin['id'];
                header('Location: admin/dashboard.php');
                exit;
            } else {
                $errors[] = 'Tài khoản hoặc mật khẩu không đúng.';
            }
        }
    }
}

$pageTitle = 'Đăng nhập';
include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Đăng nhập</h4>
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
                <form method="POST">
                    <input type="hidden" name="login" value="1">
                    <div class="mb-3">
                        <label for="account" class="form-label">Tài khoản đăng nhập</label>
                        <input type="text" class="form-control" id="account" name="account" value="<?php echo htmlspecialchars($_POST['account'] ?? ''); ?>" required>
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
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
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
</script>

<?php include 'includes/footer.php'; ?>