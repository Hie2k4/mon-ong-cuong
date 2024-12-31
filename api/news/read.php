<?php
require_once '../../admin/connectDb.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM news WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $news = $stmt->fetch();

        if ($news) {
            echo json_encode(['status' => 'success', 'data' => $news], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy tin tức.'], JSON_UNESCAPED_UNICODE);
        }
    } else {
        $stmt = $conn->query("SELECT * FROM news");
        $newsList = $stmt->fetchAll();
        echo json_encode(['status' => 'success', 'data' => $newsList], JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi lấy dữ liệu tin tức: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>