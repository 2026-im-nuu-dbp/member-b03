<?php

header('Content-Type: text/html; charset=utf-8');

require_once 'db_config.php';

$newsId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($newsId <= 0) {
    die('無效 ID <a href="index.php">返回</a>');
}

/*
讀取主文章 + 發文者資訊
*/
$stmt = $pdo->prepare("
    SELECT n.*,
           u.nickname,
           u.avatar,
           u.color
    FROM news n
    JOIN users u ON n.user_id = u.id
    WHERE n.id = ?
");
$stmt->execute([$newsId]);
$news = $stmt->fetch();

if (!$news) {
    die('找不到文章 <a href="index.php">返回</a>');
}

/*
讀取回覆 + 回覆者資訊
*/
$stmt = $pdo->prepare("
    SELECT r.*,
           u.nickname,
           u.avatar,
           u.color
    FROM replies r
    JOIN users u ON r.user_id = u.id
    WHERE r.news_id = ?
    ORDER BY r.created_at ASC
");
$stmt->execute([$newsId]);
$replies = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
<meta charset="utf-8">
<title><?= escape($news['title']) ?></title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
    margin:0;
}

.container{
    width:90%;
    max-width:900px;
    margin:auto;
    padding:20px;
}

.box{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

.user{
    display:inline-block;
    padding:5px 10px;
    border-radius:8px;
    color:#000;
    font-weight:bold;
}

.title{
    font-size:24px;
    margin:15px 0;
}

.content{
    white-space:pre-wrap;
    line-height:1.8;
}

.reply{
    background:#fff;
    padding:15px;
    border-radius:10px;
    margin-bottom:10px;
    border-left:5px solid #2196f3;
}

.time{
    font-size:12px;
    color:#777;
}

input,textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
    box-sizing:border-box;
}

button{
    background:#4caf50;
    color:white;
    border:none;
    padding:10px 15px;
    margin-top:10px;
    cursor:pointer;
    border-radius:5px;
}

button:hover{
    background:#43a047;
}

</style>

</head>

<body>

<div class="container">

    <a href="index.php">← 返回</a>

    <!-- 主文章 -->
    <div class="box">

        <div class="user" style="background:<?= $news['color'] ?>">

            <?= $news['avatar'] ?>
            <?= escape($news['nickname']) ?>

        </div>

        <div class="title">
            <?= escape($news['title']) ?>
        </div>

        <div class="content">
            <?= nl2br(escape($news['content'])) ?>
        </div>

    </div>

    <!-- 回覆 -->
    <div class="box">

        <h3>留言區</h3>

        <?php foreach($replies as $r): ?>

            <div class="reply">

                <div class="user" style="background:<?= $r['color'] ?>">

                    <?= $r['avatar'] ?>
                    <?= escape($r['nickname']) ?>

                </div>

                <div>
                    <?= nl2br(escape($r['content'])) ?>
                </div>

                <div class="time">
                    <?= $r['created_at'] ?>
                </div>

            </div>

        <?php endforeach; ?>

        <!-- 留言 -->
        <form action="post_reply.php" method="post">

            <input type="hidden" name="news_id" value="<?= $newsId ?>">

            <textarea name="content" placeholder="輸入留言..." required></textarea>

            <button>送出</button>

        </form>

    </div>

</div>

</body>
</html>