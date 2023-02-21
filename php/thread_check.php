<?php
session_start();
require("dbconnect.php");
//本番環境　require("dbconnect.php");
//開発環境　require("../dbconnect.php");

    if (!isset($_SESSION['join'])) {
        header('Location: thread_regist.php');
        exit();
    }

    if (!empty($_POST)) {
        $statement = $db->prepare("INSERT INTO threads SET member_id=?, title=?, comment=?, created_at=NOW(),  updated_at=NOW()");
        $statement->execute(array(
                $_SESSION['id'],
                $_SESSION['join']['title'],
                $_SESSION['join']['comment']
            ));
            header('Location: thread.php');
            exit();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>スレッド作成確認画面</title>
    <link href="http://153.126.213.22/php/thread_regist.php" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
            <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
            <h1>スレッド作成確認画面</h1>

            <div class="control">
                    <p>スレッドタイトル
                        <?php echo htmlspecialchars($_SESSION['join']['title']); ?></p>
                    <br>
                    <p>コメント
                        <?php echo nl2br(htmlspecialchars($_SESSION['join']['comment'])); ?></p>
            </div>

            <br>
                <button type="submit" class="btn next-btn">スレッドを作成する</button>
            <br>
                <button type="button" onclick=history.back() class="button02">前に戻る</button>
            </form>
    </div>
</body>
</html>
