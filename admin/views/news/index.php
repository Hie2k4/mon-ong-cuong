<?php include '../layout.php'; ?>
<h1>Danh sách Tin Tức</h1>

<a href="NewsController.php?action=create">Thêm Tin Tức</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Nội dung</th>
            <th>Hình ảnh</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($newsList as $news): ?>
            <tr>
                <td><?= escape($news['id']) ?></td>
                <td><?= escape($news['title']) ?></td>
                <td><?= escape(substr($news['content'], 0, 100)) ?>...</td>
                <td>
                    <?php if ($news['image']): ?>
                        <img src="../uploads/<?= escape($news['image']) ?>" width="50">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="NewsController.php?action=edit&id=<?= escape($news['id']) ?>">Sửa</a> |
                    <a href="NewsController.php?action=delete&id=<?= escape($news['id']) ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../layout.php'; ?>