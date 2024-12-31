<?php
function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function uploadImage($file) {
    $targetDir = "../uploads/";
    $fileName = basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Kiểm tra xem có phải là ảnh thật hay không
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        return false;
    }

    // Kiểm tra kích thước file
    if ($file["size"] > 5000000) {
        return false;
    }

    // Chỉ cho phép một số định dạng file nhất định
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        return false;
    }

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $fileName;
    } else {
        return false;
    }
}
?>