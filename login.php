<?php
require "db_config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $stmt=$pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$_POST['username']]);
    $u=$stmt->fetch();

    if($u && password_verify($_POST['password'],$u['password'])){
        $_SESSION['user']=$u;
        header("Location: forum.php");
    }else{
        $error="登入失敗";
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="card">

<h2>🍪 會員登入</h2>

<form method="post">

帳號<input name="username">
密碼<input type="password" name="password">

<button class="btn blue">登入</button>

</form>

<?php if(isset($error)) echo "<p class='small'>$error</p>"; ?>

</div>