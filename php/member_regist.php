<?php 
  require("dbconnect.php");
//本番環境　require("dbconnect.php");
//開発環境　require("../dbconnect.php");
    session_start();
   
if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['name_sei'] === "") {
        $error['name_sei'] = "blank";
    }
    if (strlen($_POST['name_sei'])> 60) {
        $error['name_sei'] = 'length';
    }
    //文字数制限　20文字にしたいときは×3をして60にする

    if ($_POST['name_mei'] === "") {
        $error['name_mei'] = "blank";
    }
    if (strlen($_POST['name_mei'])> 60) {
        $error['name_mei'] = 'length';
    }

    if (!isset($_POST['gender'])) {
        $_POST['gender'] = 'bar';
    }
    if (!isset($_POST['gender']) || (!($_POST['gender'] == '1')) && (!($_POST['gender'] == '2'))) {
        $error['gender'] = 'not_selected';
    }

if ($_POST['pref_id']) {
    $pref_num = (int)$_POST['pref_id'];
    if ($pref_num == 0) {
        $error['pref_id'] = 'not_selected';
    }

    if ($pref_num > 47) {
        $error['pref_id'] = 'wrong_value';
    }
}

    if (strlen($_POST['address'])> 300) {
        $error['address'] = 'length';
    }

    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }

    if (strlen($_POST['password'])> 20) {
        $error['password'] = 'length';
    }

    if (strlen($_POST['password'])< 8) {
        $error['password'] = 'length';
    }

    if (preg_match('/[^A-Za-z0-9]/', $_POST['password'])) {
        $error['password'] = 'include';
    }

    if ($_POST['password2'] === "") {
        $error['password2'] = "blank";
    }

    if (strlen($_POST['password2'])> 20) {
        $error['password2'] = 'length';
    }

    if (strlen($_POST['password2'])< 8) {
        $error['password2'] = 'length';
    }

    if (($_POST['password'] != $_POST['password2']) && ($_POST['password2'] != "")) {
        $error['password2'] = 'difference';
    }

    if (preg_match('/[^A-Za-z0-9]/', $_POST['password2'])) {
        $error['password2'] = 'include';
    }

    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }

    if (strlen($_POST['email'])> 200) {
        $error['email'] = 'length';
    }

    if (preg_match('/[^a-z0-9._+^~-]+@[^a-z0-9.-]/', $_POST['email'])) {
        $error['email'] = "include";
    }

    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM prdate WHERE email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if ($record['cnt'] > 0) {
    $error['email'] = 'duplicate';
    }   

        /* エラーがなければ次のページへ */
        if (!isset($error)) {
            $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
            header('Location: check.php');   // check.phpへ移動
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>会員登録フォーム</title>
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
            <h1>会員情報登録フォーム</h1>
            <br>
            <div class="control">
                <p>氏名
                    <label for="name_sei">姓</label>
                        <input type="text" name="name_sei" value="<?php if( !empty($_POST['name_sei']) ){ echo $_POST['name_sei']; } ?>">
                            <?php if (!empty($error['name_sei']) && ($error['name_sei'] == "blank")): ?>
                                <p class="error">※氏名(姓)は必須入力です</p>
                            <?php endif ?>
                            <?php if (isset($error['name_sei']) && ($error['name_sei'] == "length")): ?>
                                <p class="error"> ※氏名(姓)は20文字以内で入力してください</p>
                            <?php endif ?>

                    <label for="name_mei">名</label>
                        <input type="text" name="name_mei" value="<?php if( !empty($_POST['name_mei']) ){ echo $_POST['name_mei']; } ?>">
                            <?php if (!empty($error["name_mei"]) && $error['name_mei'] === 'blank'): ?>
                            <p class="error">※氏名（名）は必須入力です</p>
                            <?php endif ?>
                            <?php if (isset($error['name_mei']) && ($error['name_mei'] == "length")): ?>
                            <p class="error"> ※氏名(名)は20文字以内で入力してください</p>
                            <?php endif ?> 
            </div>

            <div class="control">
                <p>性別
                <label for="gender">
                        <input type="radio" name="gender" value="1" <?php if(!empty($_POST['gender'] == "1" )){ echo 'checked="checked"'; } ?>>男性
                        <input type="radio" name="gender" value="2" <?php if(!empty($_POST['gender'] == "2" )){ echo 'checked="checked"'; } ?>>女性
                    </label>
                        <?php if (isset($error['gender']) && ($error['gender'] == 'not_selected')): ?>
                        <p class="error"> ※性別を選択してください</p>
                        <?php endif ?>
                </p>
            </div>
                        
            <div class="control">
                <p>住所<label for="pref_id"> 都道府県</label>
                    <?php
                    $prefecture = array(
                        '1'=>'北海道',
                        '2'=>'青森県',
                        '3'=>'岩手県',
                        '4'=>'宮城県',
                        '5'=>'秋田県',
                        '6'=>'山形県',
                        '7'=>'福島県',
                        '8'=>'茨城県',
                        '9'=>'栃木県',
                        '10'=>'群馬県',
                        '11'=>'埼玉県',
                        '12'=>'千葉県',
                        '13'=>'東京都',
                        '14'=>'神奈川県',
                        '15'=>'新潟県',
                        '16'=>'富山県',
                        '17'=>'石川県',
                        '18'=>'福井県',
                        '19'=>'山梨県',
                        '20'=>'長野県',
                        '21'=>'岐阜県',
                        '22'=>'静岡県',
                        '23'=>'愛知県',
                        '24'=>'三重県',
                        '25'=>'滋賀県',
                        '26'=>'京都府',
                        '27'=>'大阪府',
                        '28'=>'兵庫県',
                        '29'=>'奈良県',
                        '30'=>'和歌山県',
                        '31'=>'鳥取県',
                        '32'=>'島根県',
                        '33'=>'岡山県',
                        '34'=>'広島県',
                        '35'=>'山口県',
                        '36'=>'徳島県',
                        '37'=>'香川県',
                        '38'=>'愛媛県',
                        '39'=>'高知県',
                        '40'=>'福岡県',
                        '41'=>'佐賀県',
                        '42'=>'長崎県',
                        '43'=>'熊本県',
                        '44'=>'大分県',
                        '45'=>'宮崎県',
                        '46'=>'鹿児島県',
                        '47'=>'沖縄県'
                        );
                        ?>
                        <select name="pref_id">
                        <option value='0'>選択してください</option>
                            <?php foreach($prefecture as $key => $value) {
                            if (!empty($_POST['pref_id'])) {
                                        if ($key == $_POST['pref_id']) {
                                            echo '<option value="'. $key.'"selected>'.$value.'</option>';
                                        } else {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                    } else {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                }
                            ?>
                        </select>

                        <?php if (isset($error['pref_id']) && ($error['pref_id'] == 'not_selected')): ?>
                        <p class="error">※都道府県は必須入力です</p>
                        <?php endif ?>

                        <?php if (isset($error['pref_id']) && ($error['pref_id'] = 'wrong_value')): ?>
                        <p class="error">※この値は不正です</p>
                        <?php endif ?>

                <br>
                            <label for="address">それ以降の住所</label>
                            <input type="text" name="address" value="<?php if( !empty($_POST['address']) ){ echo $_POST['address']; } ?>">
                </p>
                    <?php if (isset($error['address']) && ($error['address'] == "length")): ?>
                        <p class="error"> ※100文字以内で入力してください</p>
                    <?php endif ?>      
            </div>

            <div class="control">
                <label for="password">パスワード</label>
                    <input id="password" type="password" name="password" value="<?php if( !empty($_POST['password']) ){ echo $_POST['password']; } ?>">
                        <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
                            <p class="error">※パスワードを入力してください</p>
                        <?php endif ?>
                        <?php if (isset($error['password']) && ($error['password'] == "length")): ?>
                            <p class="error"> ※パスワードは8~20文字以内で入力してください</p>
                        <?php endif ?>
                        <?php if (isset($error['password']) && ($error['password'] == "difference")): ?>
                        <p class="error"> ※パスワードが一致しません</p>
                        <?php endif; ?>
                        <?php if (isset($error['password']) && ($error['password'] == "include")): ?>
                            <p class="error"> ※半角英数字で入力してください</p>
                        <?php endif; ?>     
            </div>

            <div class="control">
                <label for="password2">パスワード確認</label>
                    <input id="password2" type="password" name="password2" value="<?php if( !empty($_POST['password2']) ){ echo $_POST['password2']; } ?>">
                        <?php if (!empty($error["password2"]) && $error['password2'] === 'blank'): ?>
                        <p class="error">※パスワードを入力してください</p>
                        <?php endif ?>
                        <?php if (isset($error['password2']) && ($error['password2'] == "length")): ?>
                        <p class="error"> ※パスワードは8~20文字以内で入力してください</p>
                        <?php endif ?>
                        <?php if (isset($error['password2']) && ($error['password2'] == "difference")): ?>
                        <p class="error"> ※パスワードが一致しません</p>
                        <?php endif; ?>
                        </p>
                        <?php if (isset($error['password2']) && ($error['password2'] == "include")): ?>
                        <p class="error"> ※半角英数字で入力してください</p>
                        <?php endif; ?>
            </div>

            <div class="control">
                <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>">
                        <?php if (!empty($error["email"]) && $error['email'] === 'blank'): ?>
                        <p class="error">※メールアドレスを入力してください</p>
                        <?php endif ?>
                        <?php if (isset($error['email']) && ($error['email'] == "length")): ?>
                        <p class="error"> ※メールアドレスは200文字以内で入力してください</p>
                        <?php endif ?>    
                        <?php if (isset($error['email']) && ($error['email'] == "include")): ?>
                        <p class="error"> ※メールアドレスの形式で入力してください</p>
                        <?php endif; ?>
                        <?php if (isset($error['email']) && ($error['email'] == 'duplicate')): ?>
                        <p class="error"> ※このメールアドレスは既に登録されています</p>
                        <?php endif; ?>
            </div>
            
            <div class="control">
                <button type="submit" class="btn">確認画面へ</button>
                <br>
                <button type="button" onclick="location.href='logout.php'" class="button02">トップに戻る</button> 
            </div>
        </form>
    </div>
</body>
</html>
