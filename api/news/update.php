<?php
require_once '../../admin/connectDb.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ.'], JSON_UNESCAPED_UNICODE);
    exit;
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
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin (title, content).'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE news SET title = :title, content = :content, image = :image WHERE id = :id");
    $stmt->execute(['title' => $title, 'content' => $content, 'image' => $imageName, 'id' => $id]);
        if($stmt->rowCount() > 0){
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Cập nhật tin tức thành công.'], JSON_UNESCAPED_UNICODE);
        }else{
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy tin tức'], JSON_UNESCAPED_UNICODE);
        }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi cập nhật tin tức: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>