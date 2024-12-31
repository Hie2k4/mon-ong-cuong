<?php
$host = 'localhost';
$dbname = 'news_website';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    // Nếu kết nối thất bại, trả về lỗi 500 Internal Server Error dưới dạng JSON
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    $response = ['status' => 500, 'message' => 'Lỗi kết nối CSDL: ' . mysqli_connect_error()];// Tạo mảng chứa thông tin lỗi
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

mysqli_set_charset($conn, "utf8");//tieng viet
?>