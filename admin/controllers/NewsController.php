<?php
session_start();
require_once '../connectDb.php';
require_once '../functions.php';
require_once '../models/News.php';

if (!is_logged_in()) {
    redirect('auth/login.php');
}

$newsModel = new News($conn);
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'index':
        $newsList = $newsModel->getAllNews();
        include '../views/news/index.php';
        break;
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ch = curl_init('http://localhost/news_website/api/news/create.php');
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $_POST,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: multipart/form-data',
                ],
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $responseData = json_decode($response, true);

            if ($httpCode != 201 || $responseData['status'] != 'success') {
                $error = $responseData['message'] ?? "Lỗi không xác định.";
                include '../views/news/create.php';
            } else {
                redirect('NewsController.php');
            }
        } else {
            include '../views/news/create.php';
        }
        break;
    case 'edit':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $news = $newsModel->getNewsOne($id);
            if (!$news) {
                redirect('NewsController.php');
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ch = curl_init('http://localhost/news_website/api/news/update.php?id=' . $id);
                curl_setopt_array($ch, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $_POST,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: multipart/form-data',
                    ],
                ]);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $responseData = json_decode($response, true);

                if ($httpCode != 200 || $responseData['status'] != 'success') {
                    $error = $responseData['message'] ?? "Lỗi không xác định.";
                    include '../views/news/edit.php';
                } else {
                    redirect('NewsController.php');
                }
            } else {
                include '../views/news/edit.php';
            }
        } else {
            redirect('NewsController.php');
        }
        break;
    case 'delete':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $ch = curl_init('http://localhost/news_website/api/news/delete.php?id=' . $id);
            curl_setopt_array($ch, [
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_RETURNTRANSFER => true
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $responseData = json_decode($response, true);
            if ($httpCode == 200 && $responseData['status'] == 'success') {
                redirect('NewsController.php');
            } else {
                die("Xóa thất bại");
            }
        } else {
            redirect('NewsController.php');
        }
        break;
    default:
        $newsList = $newsModel->getAllNews();
        include '../views/news/index.php';
}
?>