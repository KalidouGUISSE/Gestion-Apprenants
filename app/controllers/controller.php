<?php
namespace App\Controllers;

require_once "../app/enums/enum.link.php";
use App\Enums\Includes;


function render($view, $data = []) {
    extract($data);
    require_once Includes::BASE_LAYOUT->value;
}

function redirect($route) {
    header("Location: index.php?route=$route");
    exit;
}

function getPostData($key = null) {
    if ($key === null) {
        return $_POST;
    }
    return $_POST[$key] ?? null;
}

function handleImageUpload(): ?string {
    $uploadDir = 'uploads/promotions/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileTmp = $_FILES['image']['tmp_name'];
    $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
    $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
    $uploadPath = $uploadDir . $fileName;

    $fileType = mime_content_type($fileTmp);
    $allowedTypes = ['image/jpeg', 'image/png'];

    if (in_array($fileType, $allowedTypes) && move_uploaded_file($fileTmp, $uploadPath)) {
        return $uploadPath;
    } else {
        return null;
    }
}


