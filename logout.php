<?php

require_once "db_config.php";

/*
清除 session
*/
session_destroy();

/*
回登入頁
*/
header("Location: login.php");
exit;

?>