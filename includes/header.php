<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Cửa hàng sách online'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/wepsach/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/wepsach/index.php">Cửa hàng sách</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/wepsach/index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/wepsach/books.php">Sách</a></li>
                    <li class="nav-item"><a class="nav-link" href="/wepsach/search.php">Tìm kiếm</a></li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['admin'])): ?>
                        <li class="nav-item"><a class="nav-link" href="/wepsach/cart.php">Giỏ hàng (<?php echo getCartCount(); ?>)</a></li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user']) || isset($_SESSION['admin'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                if (isset($_SESSION['user'])) {
                                    $user = getUserById($_SESSION['user']);
                                    echo sanitize($user['name']);
                                } elseif (isset($_SESSION['admin'])) {
                                    echo 'Admin';
                                }
                                ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <?php if (isset($_SESSION['user'])): ?>
                                    <li><a class="dropdown-item" href="/wepsach/user/dashboard.php">Dashboard</a></li>
                                <?php elseif (isset($_SESSION['admin'])): ?>
                                    <li><a class="dropdown-item" href="/wepsach/admin/dashboard.php">Dashboard Admin</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/wepsach/logout.php">Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <button class="btn btn-outline-primary ms-2 login-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</button>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<!-- Login/Register Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Đăng nhập / Đăng ký</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="authTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Đăng nhập</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Đăng ký</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="authTabsContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form action="/wepsach/login.php" method="POST">
                            <input type="hidden" name="login" value="1">
                            <div class="mb-3">
                                <label for="account" class="form-label">Tài khoản đăng nhập</label>
                                <input type="text" class="form-control" id="account" name="account" value="<?php echo htmlspecialchars($_POST['account'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="loginPassword" name="password" required>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="showLoginPassword">
                                    <label class="form-check-label" for="showLoginPassword">
                                        Hiển thị mật khẩu
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form action="/wepsach/register.php" method="POST">
                            <div class="mb-3">
                                <label for="regName" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="regName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="regEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="regEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="regPhone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="regPhone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="regPassword" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="regPassword" name="password" required>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="showRegPassword">
                                    <label class="form-check-label" for="showRegPassword">
                                        Hiển thị mật khẩu
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="regConfirmPassword" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="regConfirmPassword" name="confirm_password" required>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="showRegConfirmPassword">
                                    <label class="form-check-label" for="showRegConfirmPassword">
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
    </div>
</div>

<script>
document.getElementById('showLoginPassword').addEventListener('change', function() {
    var passwordField = document.getElementById('loginPassword');
    passwordField.type = this.checked ? 'text' : 'password';
});

document.getElementById('showRegPassword').addEventListener('change', function() {
    var passwordField = document.getElementById('regPassword');
    passwordField.type = this.checked ? 'text' : 'password';
});

document.getElementById('showRegConfirmPassword').addEventListener('change', function() {
    var passwordField = document.getElementById('regConfirmPassword');
    passwordField.type = this.checked ? 'text' : 'password';
});
</script>

    <div class="container mt-4">