<?php
session_start();  
require("../dbconnect.php");
//本番環境　require("../dbconnect.php");
//開発環境　require("../../dbconnect.php");

//入力情報の不備を検知
if (!empty($_POST)) {
    if (isset($_POST['login_id'])) {
        if ($_POST['login_id'] === "") {
            $error['login'] = "blank";
        }
        if (strlen($_POST['login_id'])> 11) {
            $error['login'] = 'failed';
        }
    }

    if (isset($_POST['password'])) {
        if ($_POST['password'] === "") {
            $error['login'] = "blank";
        }
        if (strlen($_POST['password'])> 21) {
            $error['login'] = 'failed';
        }
    }

    if (isset($_POST['login_id']) && $_POST['password']) {
        $login_id = $_POST['login_id'];
        $password = $_POST['password'];

        if (!isset($_POST['login_id']) && $_POST['password']) {
            $login_id = "";
            $password = "";
        }
        $login = $db->prepare("SELECT * FROM administers WHERE login_id='".$login_id."' AND password='".$password."'");
        //WHERE句のANDの使い方に注意
        $login->execute();
        $login_mem=$login->fetch();

    if (!empty($login_mem)) {
        //issetだとboolが起きるので誤りのアイパスでもログインしてしまう
        $_SESSION['id'] = $login_mem['id'];
        $_SESSION['name'] = $login_mem['name'];
        header('Location: member_top.php');
        exit();
    } else {
        $error['login']='failed';
    } 
    } else {
        $error['login']='blank';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>ログインフォーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST">
    <h1>管理画面</h1>
        <br>
                <p>ログインID<input type="text" name="login_id" style="width:150px" value="<?php echo htmlspecialchars($_POST['login_id']??"", ENT_QUOTES); ?>"></p>
                <p>パスワード<input type="password" name="password" style="width:150px" value="<?php echo htmlspecialchars($_POST['password']??"", ENT_QUOTES); ?>"></p>
                    <?php if (isset($error['login']) &&  ($error['login'] =='blank')): ?>
                    <p class="error">IDとパスワードを入力してください</p>
                    <?php endif; ?>

                    <?php if(isset($error['login']) &&  $error['login'] =='failed'): ?>
                    <p class="error">IDもしくはパスワードが間違っています</p>
                    <?php endif; ?>
                <button type="submit" class="btn next-btn">ログイン</button>    
    </form>
</body>
</html>