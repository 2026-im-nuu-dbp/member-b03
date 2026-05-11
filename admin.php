<?php
require "db_config.php";

if($_SESSION['user']['role']!='admin'){
    die("無權限");
}

if(isset($_GET['del'])){
    $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$_GET['del']]);
}

$users=$pdo->query("SELECT * FROM users")->fetchAll();
?>

<link rel="stylesheet" href="style.css">

<div class="card">

<h2>👑 管理員</h2>

<?php foreach($users as $u): ?>

<p>
<?= $u['avatar'] ?> <?= $u['username'] ?>
<a href="?del=<?= $u['id'] ?>">刪除</a>
</p>

<?php endforeach; ?>

</div>
