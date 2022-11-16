<?php
require("./dbconnect.php");
session_start();

/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: entry.php');
    exit();
}

if (!empty($_POST['check'])) {
    // パスワードを暗号化
    $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);

    // 入力情報をデータベースに登録
    $statement = $db->prepare("INSERT INTO prdate SET id=?, name_sei=?, name_mei=?, gender=?,
pref_name=?, address=?, email=?, password=?, created_at=NOW(),  updated_at=NOW(), deleted_at=NOW()");
    $statement->execute(array(
    $_SESSION['join']['name_sei'],
    $_SESSION['join']['name_mei'],
    $_SESSION['join']['gender'],
    $_SESSION['join']['pref_name'],
    $_SESSION['join']['address'],
    $_SESSION['join']['password'],
    $_SESSION['join']['email'],
    $hash
    ));

    header('Location: thanks.php');   // thank.phpへ移動
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>会員情報確認画面</title>
    <link href="http://153.126.213.22/php/member_regist.php" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
            <h1>会員情報確認画面</h1>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>
            <br>

            <div class="control">
                <p>氏名
                <?php echo $name = $_SESSION['join']['name_sei'].$_SESSION['join']['name_mei'];//結合
                echo "<br/>\n"; 
                ?>
                </p>
            </div>

            <div class="control"> 
            <p>性別
		    <?php if($_SESSION['join']['gender'] === "0" ){ echo '男性'; }
		    else{ echo '女性'; } ?></p>
	        </div>

            <div class="control">
                <p>住所
                <?php echo htmlspecialchars($_SESSION['join']['pref_name'].$_SESSION['join']['address']); ?></p>
            </div>

            <div class="control">
            <p>パスワード
    <span class="check">セキュリティのため非表示</span></p>
            </div>

            <div class="control">
                <p>メールアドレス
                <?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></p>
            </div>
            
            <br>
            <button type="submit" class="btn next-btn">登録完了</button>
            <br>
            <input type="button" onclick=history.back() value="前に戻る" class="button02"></button>
            <input type="hidden" name="name_sei" value="<?php echo $_SESSION['join']['name_sei']; ?>">
            <input type="hidden" name="name_mei" value="<?php echo $_SESSION['join']['name_mei']; ?>">
            <input type="hidden" name="gender" value="<?php echo $_SESSION['join']['gender']; ?>">
            <input type="hidden" name="pref_name" value="<?php echo $_SESSION['join']['pref_name']; ?>">
            <input type="hidden" name="address" value="<?php echo $_SESSION['join']['address']; ?>">
	        <input type="hidden" name="email" value="<?php echo $_SESSION['join']['email']; ?>">
        </form>
    </div>
</body>
</html>