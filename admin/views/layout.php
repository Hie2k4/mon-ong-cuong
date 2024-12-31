<!DOCTYPE html>
<html>
<head>
    <title>Quản lý Tin Tức</title>
</head>
<body>
    <nav>
        <a href="NewsController.php">Tin Tức</a> |
        <?php if (is_logged_in()): ?>
            <a href="logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="auth/login.php">Đăng nhập</a> |
            <a href="auth/register.php">Đăng ký</a>
        <?php endif; ?>
    </nav>
    <hr>
    <div>
        <?php if (isset($_SESSION['message'])): ?>
            <p style="color: green;"><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
        <?= isset($content) ? $content : '' ?>
    </div>
</body>
</html>