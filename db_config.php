<?php

$host = 'localhost';
$db = 'group_chat';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {

    $pdo = new PDO($dsn, $user, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    die('資料庫連線失敗：' . $e->getMessage());
}

/*
防止 XSS
*/
function escape($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

/*
Session 啟動（避免重複）
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>