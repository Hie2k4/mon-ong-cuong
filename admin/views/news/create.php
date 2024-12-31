<?php include '../layout.php'; ?>
<h1>Thêm Tin Tức</h1>
<?php if (isset($error)) : ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
    <label for="title">Tiêu đề:</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="content">Nội dung:</label><br>
    <textarea name="content" id="content" rows="4" required></textarea><br><br>

    <label for="image">Hình ảnh:</label><br>
    <input type="file" name="image" id="image"><br><br>

    <button type="submit">Lưu</button>
</form>
<?php include '../layout.php'; ?>