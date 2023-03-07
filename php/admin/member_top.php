<?php
session_start();  
require("../dbconnect.php");
//本番環境　require("../dbconnect.php");
//開発環境　require("../../dbconnect.php");

if (!isset($_SESSION)) {
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    header('Location: login.php');
    exit();
} else {
    $id = 1;
    $name = "テスト管理者";
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf8mb4">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <title>管理画面トップページ</title>
        <link rel="stylesheet" href="style05.css">
    </head>
    <body>
        <div class="content">
            <div class="menu">
                <form action="" method="POST">
                    <ul id="nav">
                        <li><a href="http://153.126.213.22/php/admin/login.php">ログアウト</a></li>
                        <li><h3>掲示板管理画面メインメニュー</h3></li>
                        <li>ようこそ<?php echo($name); ?>さん</li>                    
                    </ul>
                    <br>
                    <button type="button" onclick="location.href='member.php'" class="button02">会員一覧</button>
                </form>
            </div>
        </div>    
    </body>
</html>