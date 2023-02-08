<?php 
    require("../dbconnect02.php");
    session_start();
    
    if (!empty($_POST)) {
        if ($_POST['title'] === "") {
            $error['title'] = "blank";
        }
        if (strlen($_POST['title'])> 101) {
            $error['title'] = 'length';
        }

if (!empty($_POST)) {
    if ($_POST['comment'] === "") {
        $error['comment'] = "blank";
    }
    if (strlen($_POST['comment'])> 501) {
        $error['comment'] = 'length';
    }

    if (!isset($error)) {
        $_SESSION['join'] = $_POST;
        header('Location: thread_check.php');
        exit();
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>スレッド作成フォーム</title>
    <link href="http://153.126.213.22/php/member_regist.php" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    echo "<div class=content>";
    echo "</div>";
    ?>
    <div class="content">
        <form action="" method="POST">
            <h1>スレッド作成フォーム</h1>
            <br>
            <div class="control">
                <label for="title">スレッドタイトル</label>
                        <input type="text" name="title" value="<?php if( !empty($_POST['title']) ){ echo $_POST['title']; } ?>">
                            <?php if (!empty($error['title']) && ($error['title'] == "blank")): ?>
                                <p class="error">※タイトルを入力してください</p>
                            <?php endif ?>
                            <?php if (isset($error['title']) && ($error['title'] == "length")): ?>
                                <p class="error"> ※タイトルは100文字以内で入力してください</p>
                            <?php endif ?>

                <label for="comment">コメント</label>
                        <textarea rows="10" cols="60"><?php if( !empty($_POST['comment']) ){ echo $_POST['name_mei']; } ?></textarea>
                            <?php if (!empty($error["comment"]) && $error['comment'] === 'blank'): ?>
                                <p class="error">※コメントを入力してください</p>
                            <?php endif ?>
                            <?php if (isset($error['comment']) && ($error['comment'] == "length")): ?>
                                <p class="error"> ※コメントは500文字以内で入力してください</p>
                            <?php endif ?> 
            </div>
        </form>
    </div>
</body>
</html>