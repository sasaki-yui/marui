<?php
session_start();
require("../dbconnect.php");

if (isset($_SESSION['id']) && isset($_SESSION['name_sei']) || isset($_SESSION['name_mei'])) {
    $name_sei = $_SESSION['name_sei'];
    $name_mei = $_SESSION['name_mei'];
} else {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>トップページ</title>
    <link href="http://153.126.213.22/php/member_regist.php" rel="stylesheet"/>
    <link rel="stylesheet" href="style03.css">
</head>
<body>
    <div class="menu">
        <ul id="nav">
            <li><a href="http://localhost/php/logout.php">ログアウト</a></li>
            <li><a href="http://localhost/php/thread_regist.php">新規スレッド作成</a></li>
            <li>ようこそ、<?php echo ($name_sei).($name_mei); ?>様</li>
        </ul>
    </div>    
    <div class="content">
        <h1>○○掲示板</h1>
    </div>
</body>
</html>