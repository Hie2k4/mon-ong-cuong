<?php
require_once '../../admin/connectDb.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM news WHERE id = :id");
    $stmt->execute(['id' => $id]);
    if($stmt->rowCount() > 0){
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Xóa tin tức thành công.'], JSON_UNESCAPED_UNICODE);
    }else{
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy tin tức'], JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi xóa tin tức: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>