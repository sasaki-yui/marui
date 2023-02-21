<?php
    session_start();
    require("dbconnect.php");
//本番環境　require("dbconnect.php");
//開発環境　require("../dbconnect.php");

    if (!isset($_POST["word"])) {
        $_POST['word'] = "";
        }

    if (isset($_POST["word"])) {
        $word = $_POST['word'];
        $sql = $db->prepare(" SELECT * FROM threads WHERE comment LIKE '%".$word."%' OR title LIKE '%".$word."%'");
        $sql->execute(array());
        $statement=$sql->fetchAll();
        }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf8mb4">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <title>スレッド検索フォーム</title>
        <link href="http://153.126.213.22/php/thread_regist.php" rel="stylesheet"/>
        <link rel="stylesheet" href="style04.css">
    </head>
    <body>
        
        <div class="content">
            <form action="" method="POST">
                <div class="menu">
                    <ul id="nav">
                    <li><a href="http://153.126.213.22/php/thread_regist.php">新規スレッド作成</a></li>
                    </ul>
                </div>
                <div class="content">
                    <input type="text" name="word">
                    <input type="submit" name="search" value="スレッド検索">
                </div>
            </form>
                <table>
                    <?php 
                        if (isset($statement)) 
                        foreach ($statement as $row): 
                        ?>
                        <tr>
                            <td><a href="thread_detail.php?id=<?php echo $row[0]; ?>">ID:<?php echo $row[0]?>
                            <?php echo $row[2]?>
                            <?php echo $row[4]?></a></td>
                        </tr>
                            <?php endforeach; ?>
                </table>
            <br>
            <button type="button" onclick="location.href='top.php'" class="button02">トップに戻る</button> 
        </div>
    </body>
</html>