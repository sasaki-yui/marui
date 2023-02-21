<?php
session_start();
    $token = isset($_POST["token"]) ? $_POST["token"] : "";
    $session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";

        // POSTされたトークンとセッション変数のトークンの比較
        if($token != "" && $token == $session_token) {
            // 登録画面送信データの登録を行う
            echo"";
        } else {
            echo"";
        }

        // セッションに保存しておいたトークンの削除
        unset($_SESSION['token']);
        // セッションの保存
        session_write_close();
        // セッションの再開
        session_start();

        // ↓ここにフォームで行う処理を書く

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>会員登録完了</title>
    <link href="http://153.126.213.22/php/member_regist.php" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        <h1>会員登録完了</h1>
        <p>会員登録が完了しました。</p>
<br>
        <button type="button" onclick="location.href='top.php'" class="button">トップに戻る</button> 
    </div>
</body>
</html>