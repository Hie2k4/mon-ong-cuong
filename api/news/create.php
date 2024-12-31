<?php
require_once '../../admin/connectDb.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}
$data = [];
if(isset($_POST)){
    $data = $_POST;
}
$title = $data['title'] ?? null;
$content = $data['content'] ?? null;

$imageName = null;
if(isset($_FILES['image'])){
    require_once '../../admin/functions.php';
    $imageName = uploadImage($_FILES['image']);
    if(!$imageName){
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Lỗi upload ảnh'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}


if (empty($title) || empty($content)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin (title, content).'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO news (title, content, image) VALUES (:title, :content, :image)");
    $stmt->execute(['title' => $title, 'content' => $content, 'image' => $imageName]);
    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'Tạo tin tức thành công.', 'id' => $conn->lastInsertId()], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi tạo tin tức: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>