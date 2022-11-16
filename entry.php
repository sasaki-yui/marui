<?php 
require("./dbconnect.php");
session_start();
 
if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }
    if ($_POST['name_sei'] === "") {
        $error['name_sei'] = "blank";
    }
    if ($_POST['name_mei'] === "") {
        $error['name_mei'] = "blank";
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if (empty($_POST['gender'])){
      $err['gender'] = true;
   }
}
    if ($_POST['pref_name'] === "") {
        $error['pref_name'] = "blank";
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
    <meta charset="utf-8">
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
            <p>氏名<label for="name_sei">
                姓</label>
                <input id="name_sei" type="name_sei" name="name_sei">
                <?php if (!empty($error["name_sei"]) && $error['name_sei'] === 'blank'): ?>
                    <p class="error">※氏名（姓）は必須入力です</p>
                <?php endif ?>
                <label for="name_mei">名</label>
                <input id="name_mei" type="name_mei" name="name_mei">
                <?php if (!empty($error["name_mei"]) && $error['name_mei'] >= 20): ?>
                <p class="error">※氏名（名）は２０文字以内で入力してください</p>
                <?php endif ?>
                </p>
            </div>

            <div class="control">
                <label for="gender">性別</label>
                <input id="gender" type="radio" name="gender" value="male">男性
                <input id="gender" type="radio" name="gender" value="female">女性
                <?php if(isset($_POST['gender'])) {  
                 echo htmlspecialchars($_POST['gender'], ENT_QUOTES, 'utf-8');
                 }
                ?>
            </div>
            
            <div class="control">
            <p>住所<label for="pref_name"> 都道府県</label>
            <?php
             $prefecture = array
('blank'      => '選択下さい。',
'hokkai'     => '北海道',
'aomori'     => '青森県',
'iwate'      => '岩手県',
'miyagi'     => '宮城県',
'akita'      => '秋田県',
'yamagata'   => '山形県',
'fukushima'  => '福島県',
'ibaraki'    => '茨城県',
'tochigi'    => '栃木県',
'gunma'      => '群馬県',
'saitama'    => '埼玉県',
'chiba'      => '千葉県',
'tokyo'      => '東京都',
'kanagawa'   => '神奈川県',
'yamanashi'  => '山梨県',
'nagano'     => '長野県',
'nigata'     => '新潟県',
'toyama'     => '富山県',
'ishikawa'   => '石川県',
'hukui'      => '福井県',
'gihu'       => '岐阜県',
'shizuoka'   => '静岡県',
'aichi'      => '愛知県',
'mie'        => '三重県',
'shiga'      => '滋賀県',
'kyouto'     => '京都府',
'osaka'      => '大阪府',
'hyogo'      => '兵庫県',
'nara'       => '奈良県',
'wakayama'   => '和歌山県',
'totori'     => '鳥取県',
'shimane'    => '島根県',
'okayama'    => '岡山県',
'hiroshima'  => '広島県',
'yamaguchi'  => '山口県',
'tokushima'  => '徳島県',
'kagawa'     => '香川県',
'ehime'      => '愛媛県',
'kouchi'     => '高知県',
'fukuoka'    => '福岡県',
'saga'       => '佐賀県',
'nagasaki'   => '長崎県',
'kumamoto'   => '熊本県',
'oita'       => '大分県',
'miyazaki'   => '宮崎県',
'kagoshima'  => '鹿児島県',
'okinawa'    => '沖縄県'
);
?>
            <select name="pref_name">
            <?php foreach($prefecture as $key => $value){ ?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php } ?>
            </select>
            <br>
            <label for="address">それ以降の住所</label>
            <input id="address" type="address" name="address">
            </p>      
            </div>

            <div class="control">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password">
            <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
            <p class="error">※パスワードを入力してください</p>
            <?php endif ?>
            </div>

            <div class="control">
            <label for="password">パスワード確認</label>
            <input id="password" type="password" name="password">
            <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
            <p class="error">※パスワードを入力してください</p>
            <?php endif ?>
            </div>

            <div class="control">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email">
            <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
            <p class="error">※メールアドレスを入力してください</p>
            <?php endif ?>
            </div>
 
            <div class="control">
                <button type="submit" class="btn">確認画面へ</button>
            </div>
        </form>
    </div>
</body>
</html>
