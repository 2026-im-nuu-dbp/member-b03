<?php

header('Content-Type: text/html; charset=utf-8');

require_once 'db_config.php';

/*
必須登入
*/
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

/*
只允許 POST
*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method');
}

/*
抓登入者
*/
$userId = $_SESSION['user']['id'];

/*
資料接收
*/
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$content = isset($_POST['content']) ? trim($_POST['content']) : '';

/*
驗證
*/
if ($title == '' || $content == '') {
    die('請填寫完整 <a href="index.php">返回</a>');
}

/*
長度限制
*/
$title = substr($title, 0, 200);
$content = substr($content, 0, 2000);

/*
寫入資料
*/
try {

    $stmt = $pdo->prepare("
        INSERT INTO news (user_id, title, content)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $userId,
        $title,
        $content
    ]);

    header("Location: index.php");
    exit;

} catch (PDOException $e) {

    die('發表失敗：' . $e->getMessage());

}