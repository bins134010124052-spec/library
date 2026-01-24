    <?php
    session_start();
    
    // Clear any previous session data before checking
    if (isset($_SESSION['admin']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Already logged in, redirect
        header('Location: dashboard.php');
        exit;
    }

    require_once '../includes/functions.php';

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Logout any previous session
        $_SESSION = [];
        
        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
        } else {
            global $pdo;
            if (!$pdo) {
                $errors[] = 'Lỗi kết nối database. Vui lòng liên hệ admin.';
            } else {
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
                $stmt->execute([$username]);
                $admin = $stmt->fetch();

                if ($admin && verifyPassword($password, $admin['password'])) {
                    // Successful login - regenerate session
                    session_regenerate_id(true);
                    $_SESSION['admin'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['login_time'] = time();
                    header('Location: dashboard.php');
                    exit;
                } else {
                    // Clear session on failed login
                    $_SESSION = [];
                    $errors[] = 'Tên đăng nhập hoặc mật khẩu không đúng.';
                }
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đăng nhập Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Đăng nhập Admin</h4>
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
                                <div class="mb-3">
                                    <label for="username" class="form-label">Tên đăng nhập</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>