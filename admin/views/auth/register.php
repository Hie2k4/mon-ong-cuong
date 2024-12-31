<?php include '../layout.php'; ?>
<h1>Đăng ký</h1>
<?php if (isset($error)) : ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>
<form method="post" action="../controllers/AuthController.php?action=register">
    <label for="username">Tên đăng nhập:</label><br>
    <input type="text" name="username" id="username" required><br><br>

    <label for="password">Mật khẩu:</label><br>
    <input type="password" name="password" id="password" required><br><br>

    <button type="submit">Đăng ký</button>
</form>
<?php include '../layout.php'; ?>