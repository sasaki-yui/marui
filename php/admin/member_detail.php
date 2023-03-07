<?php
session_start();
require("../dbconnect.php");
//本番環境　require("../dbconnect.php");
//開発環境　require("../../dbconnect.php");

    $url = $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $results);
    $master_id = $results['id'];

    $login = $db->prepare('SELECT * FROM prdate WHERE id=?');
    $login->execute(array($master_id));
    $master = $login->fetch();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8mb4">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>会員詳細</title>
    <link rel="stylesheet" href="style05.css">
</head>
<body>
<div class="menu">
        <ul id="nav">
            <li><h3>会員詳細</h3></li>
            <li><a href="member.php">一覧へ戻る</a></li>
        </ul>
        <p>ID<?php if(empty($_POST['id']) ) {echo $master["id"]; } ?></p>

        <div class="control">
            <p>氏名
                <?php echo $name = $master['name_sei'].$master['name_mei'];//結合
                    echo "<br/>\n"; 
                ?>
            </p>
        </div>

            <div class="control"> 
                <p>性別
                <?php 
                    if($master['gender'] == "1" ){
                    print '男性';
                        }elseif ($master['gender'] == "2" ) {
                        print '女性';
                    } 
                    ?>
                </p>
            </div>

            <div class="control">
                <?php
                    $prefecture = array(
                    '0'=>'選択してください',
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
                <p>住所
                <?php echo $prefecture[$master['pref_id']].$master['address']; ?></p>
            </div>

                <div class="control">
                    <p>パスワード
                        <span class="check">セキュリティのため非表示</span></p>
                </div>

                <div class="control">
                    <p>メールアドレス
                        <?php echo htmlspecialchars($master['email'], ENT_QUOTES); ?></p>
                </div>
            
                <br>
                    <input type="hidden" name="token" value="<?php echo $token;?>">
                    <button type="submit" onclick="location.href='member_edit.php?id=<?php echo $master_id; ?>'" class="bottun02">編集</button>
                    <button type="submit" onclick="location.href='member_delete.php?id=<?php echo $master_id; ?>'" class="bottun02">削除</button>
                <br>
    </div>
</body>
</html>