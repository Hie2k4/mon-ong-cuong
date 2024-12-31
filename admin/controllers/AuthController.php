<?php
session_start();
require_once '../connectDb.php';
require_once '../functions.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = :username AND password = :password"); // Nên sử dụng password_hash
            $stmt->execute(['username' => $username, 'password' => $password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                redirect('../NewsController.php');
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                include '../views/auth/login.php';
            }
        }
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            try {
                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)"); // Nên sử dụng password_hash
                $stmt->execute(['username' => $username, 'password' => $password]);
                redirect('../auth/login.php');
            } catch (PDOException $e) {
                $error = "Lỗi đăng ký: " . $e->getMessage();
                include '../views/auth/register.php';
            }
        }
        break;
    case 'logout':
        session_destroy();
        redirect('../index.php');
        break;
}
?>