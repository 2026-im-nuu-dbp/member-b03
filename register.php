<?php
require "db_config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $pdo->prepare("INSERT INTO users(username,password,nickname,color,avatar)
    VALUES(?,?,?,?,?)")->execute([
        $_POST['username'],
        password_hash($_POST['password'],PASSWORD_DEFAULT),
        $_POST['nickname'],
        $_POST['color'],
        $_POST['avatar']
    ]);

    header("Location: login.php");
}
?>

<link rel="stylesheet" href="style.css">

<div class="card">

<h2>🧁 註冊會員</h2>

<form method="post">

帳號<input name="username">
密碼<input type="password" name="password">
暱稱<input name="nickname">

顏色<input type="color" name="color">

頭貼
<select name="avatar">
<option>🍰</option>
<option>🧁</option>
<option>🍩</option>
<option>🍪</option>
<option>🍓</option>
</select>

<button class="btn pink">註冊</button>

</form>

</div>