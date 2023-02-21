<?php
session_start();
require("dbconnect.php");
//本番環境　require("dbconnect.php");
//開発環境　require("../dbconnect.php");

    //deleted_atデータを挿入する
    if(isset($_POST["deleted"])) {
        if (isset($_SESSION['id'])) {
            $sql = $db->prepare("UPDATE prdate SET deleted_at =NOW() WHERE id='".$_SESSION['id']."'");
            $sql->execute();

            $sql = $db->prepare("UPDATE threads SET deleted_at =NOW() WHERE member_id='".$_SESSION['id']."'");
            $sql->execute();
        
            $sql = $db->prepare("UPDATE coments SET deleted_at =NOW() WHERE member_id='".$_SESSION['id']."'");
            $sql->execute();
            
            header('Location: logout.php');
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>トップページ</title>
    <link href="http://153.126.213.22/php/top.php" rel="stylesheet"/>
    <link rel="stylesheet" href="style05.css">
</head>
<body>
    <div class="menu">
        <ul id="nav">
            <li><a href="http://153.126.213.22/php/login.php">トップに戻る</a></li>
        </ul>
    </div>    
    <div class="content">
        <h2>退会</h2>
        <p>退会しますか？</p>
    </div>
    <form action="" method="POST">
    <button type="submit" name= "deleted" class="btn next-btn" value="<?=$_SESSION['id']?>">退会</button>
    </form>
</body>
</html>