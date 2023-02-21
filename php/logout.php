<?php
require("dbconnect.php");
//本番環境　require("dbconnect.php");
//開発環境　require("../dbconnect.php");
session_start();

$_SESSION = array();//セッションの中身をすべて削除
session_destroy();//セッションを破壊
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>トップページ</title>
    <link href="http://153.126.213.22/php/member_regist.php" rel="stylesheet"/>
    <link rel="stylesheet" href="style02.css">
</head>
<body>
    <div class="header">
        <ul id="nav">
                    <li><a href="http://153.126.213.22/php/login.php">ログイン</a></li>
                    <li><a href="http://153.126.213.22/php/member_regist.php">新規会員登録</a></li>
                    <li><a href="http://153.126.213.22/php/thread.php">スレッド一覧</a></li>
                </ul>
    </div>            
            <div class="content">
        <h1>○○掲示板</h1>
    </div>
</body>
</html>