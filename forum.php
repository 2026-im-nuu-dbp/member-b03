<?php
require "db_config.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user=$_SESSION['user'];

if($_SERVER['REQUEST_METHOD']=="POST"){
    $pdo->prepare("INSERT INTO news(title,content,user_id)
    VALUES(?,?,?)")->execute([
        $_POST['title'],
        $_POST['content'],
        $user['id']
    ]);
}

$news=$pdo->query("
SELECT n.*,u.nickname,u.avatar,u.color
FROM news n
JOIN users u ON n.user_id=u.id
ORDER BY n.id DESC
")->fetchAll();
?>

<link rel="stylesheet" href="style.css">

<div class="card">

<h2>🍓 甜點討論區</h2>

<form method="post">

標題<input name="title">
內容<textarea name="content"></textarea>

<button class="btn green">發文</button>

</form>

<a class="btn blue" href="logout.php">登出</a>

</div>

<?php foreach($news as $n): ?>

<div class="post" style="background:<?= $n['color'] ?>20">

<div class="avatar">
<?= $n['avatar'] ?> <b><?= $n['nickname'] ?></b>
</div>

<h3><?= $n['title'] ?></h3>
<p><?= $n['content'] ?></p>

</div>

<?php endforeach; ?>