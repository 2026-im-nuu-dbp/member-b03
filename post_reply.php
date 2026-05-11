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
    die('Invalid request');
}

/*
資料接收
*/
$newsId = isset($_POST['news_id']) ? intval($_POST['news_id']) : 0;
$content = isset($_POST['content']) ? trim($_POST['content']) : '';

$userId = $_SESSION['user']['id'];
$nickname = $_SESSION['user']['nickname'];

/*
驗證
*/
if ($newsId <= 0 || $content == '') {
    die('資料不完整 <a href="index.php">返回</a>');
}

/*
確認討論存在
*/
$stmt = $pdo->prepare("SELECT id FROM news WHERE id=?");
$stmt->execute([$newsId]);

if (!$stmt->fetch()) {
    die('找不到討論 <a href="index.php">返回</a>');
}

/*
限制長度
*/
$content = substr($content, 0, 1000);

/*
寫入留言（改成會員制）
*/
try {

    $stmt = $pdo->prepare("
        INSERT INTO replies (news_id, user_id, content)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $newsId,
        $userId,
        $content
    ]);

    header("Location: show_news.php?id=" . $newsId);
    exit;

} catch (PDOException $e) {

    die("留言失敗：" . $e->getMessage());

}