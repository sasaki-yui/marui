<?php
session_start();
require("dbconnect.php");
//本番環境　require("dbconnect.php");
//開発環境　require("../dbconnect.php");

    if(!empty($_POST)) {
        if(($_POST['email'] != '') && ($_POST['password'] != '')) {
            $login = $db->prepare("SELECT * FROM prdate WHERE email=? AND deleted_at is null");
            //deleted_at is nullの前にANDを足してなかった
            $login->execute(array($_POST['email']));
            $member=$login->fetch();

            if(password_verify($_POST['password'],$member['password'])) {
                $_SESSION['id'] = $member['id'];
                $_SESSION['time'] =time();
                $_SESSION['name_sei'] = $member['name_sei'];
                $_SESSION['name_mei'] = $member['name_mei'];
                header('Location: top.php');
                exit();
            } else {
                $error['login']='failed';
            } 
            } else {
            $error['login'] ='blank';
            } 
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>ログインフォーム</title>
    <link href="http://153.126.213.22/php/login.php" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST">
    <h1>ログイン</h1>
        <br>
                <p>メールアドレス(ID)<input type="text" name="email" style="width:150px" value="<?php echo htmlspecialchars($_POST['email']??"", ENT_QUOTES); ?>"></p>
                    <?php if (isset($error['login']) &&  ($error['login'] =='blank')): ?>
                    <p class="error">IDとパスワードを入力してください</p>
                    <?php endif; ?>

                    <?php if( isset($error['login']) &&  $error['login'] =='failed'): ?>
                    <p class="error">IDもしくはパスワードが間違っています</p>
                    <?php endif; ?>

                <p>パスワード<input type="password" name="password" style="width:150px"></p>

                <button type="submit" class="btn next-btn">ログイン</button>
            <br>
                <button type="button" onclick="location.href='logout.php'" class="button02">トップに戻る</button>
        
    </form>
 
</body>
</html>