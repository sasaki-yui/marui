<?php
    session_start();  
    require("../dbconnect.php");
//本番環境　require("../dbconnect.php");
//開発環境　require("../../dbconnect.php");

//会員を表示
if (isset($_POST["search"])) {
    // 空の配列を用意
    $part=[];

    //search要素を取得
    if (isset($_POST['search_id']) && !empty($_POST['search_id'])) {
        $part[] = " id = '".$_POST['search_id']."'";
    }

    //ひとまず男女で検索は掛けられるようになった
    if (isset($_POST['search_gender']) && is_array($_POST['search_gender'])) {
        $search_gender = implode(' OR ', $_POST['search_gender']);

        if ($search_gender == "1" || $search_gender == "2") {
            $part[] = " gender = '".$search_gender."'";
        }
        if ($search_gender == "1 OR 2") {
            $part[] = " (gender = '1' OR gender = '2') ";
        }
    }

    if (isset($_POST['search_pref_id']) && $_POST['search_pref_id'] != "0") {
        $part[] = " pref_id = '".$_POST['search_pref_id']."'";
    }
    if (isset($_POST['search_box']) && !empty($_POST['search_box'])) {
        $part[] = " (name_sei = '".$_POST['search_box']."' || name_mei = '".$_POST['search_box']."' || email LIKE '%".$_POST['search_box']."%') ";
    }

    //要素を配列に入れる
    $result = implode(' AND', $part);

    $query = $db->prepare("SELECT * FROM prdate WHERE deleted_at is null AND $result");
    $query->execute();
    $pre = $query->fetchAll();

    $stmt = $db->prepare("SELECT COUNT(*) FROM prdate WHERE deleted_at is null AND $result");
    $stmt->execute();
    $member_count = $stmt->fetchColumn();

} else {
    //「検索」ボタン押下してないとき
    $query = $db->prepare("SELECT * FROM prdate WHERE deleted_at is null ORDER BY id DESC");
    $query->execute();
    $pre = $query->fetchAll();

    $stmt = $db->prepare("SELECT COUNT(*) FROM prdate WHERE deleted_at is null");
    $stmt->execute();
    $member_count = $stmt->fetchColumn();
}

    //昇順・降順
    if (isset($_POST['up'])) {
        krsort($pre);
    }
    
    if (isset($_POST['down'])) {
        ksort($pre);
    }
    
    if (isset($_POST['upup'])) {
        krsort($pre);
    }
    
    if (isset($_POST['downdown'])) {
        ksort($pre);
    }

    //会員者数を取得
    define('MAX', '10');
    $totalPage = ceil($member_count/10);

    //ページネーション
    if (isset($_GET['id'])) {
        $page = (int)$_GET['id'];
    } else {
        $page = 1;
    }

    if ($page > 1) {
        $start_no = ($page - 1) * MAX;
    } else {
        $start_no = 0;
    }

    //会員表示
    $disp_data = array_slice($pre, $start_no, MAX, true);

        //都道府県の配列
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

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf8mb4">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <title>管理画面トップページ</title>
        <link rel="stylesheet" href="style05.css">
    </head>
    <body>
        <div class="content">
            <div class="menu">
                <form action="" method="POST">
                    <ul id="nav">
                        <li><h3>会員一覧</h3></li>
                        <li>
                            <a href="member_top.php">トップへ戻る
                                <input type="hidden" name="id" value="<?= print $id?>">
                                <input type="hidden" name="name" value="<?= print $name?>">
                            </a>
                        </li>
                    </ul>
                    <button type="button" onclick="location.href='member_regist.php'" class="button">会員登録</button>
                    
                        <br><th>ID</th>
                            <td><input type="text" name="search_id" value="<?php if(!empty($_POST['search_id'])) {
                            echo $_POST['search_id'];
                            } ?>"></td>
                        <br><th>性別</th>
                            <td><label for="gender">
                            <input type="checkbox" name="search_gender[]" value="1" <?php if(!empty($_POST['search_gender']) && $_POST['search_gender'] == "1") {
                                print 'checked';
                            } ?>>男性
                            <input type="checkbox" name="search_gender[]" value="2" <?php if(!empty($_POST['search_gender']) && $_POST['search_gender'] == "2") {
                                print 'checked';
                            } ?>>女性
                            </label></td>
                        <br><th>都道府県</th>
                            <td>
                                <select name="search_pref_id">
                                <option value='0'>選択してください</option>
                                    <?php foreach($prefecture as $key => $value) {
                                    if ( ! empty( $_POST['search_pref_id'] ) ) {
                                                if ( $key == $_POST['search_pref_id']  ) {
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            } else {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                        }
                                    ?>
                                </select> 
                            </td>
                        <br><th>フリーワード</th>
                            <td><input type="text" name="search_box" value="<?php if(!empty($_POST['search_box'])) {
                                echo $_POST['search_box'];
                                } ?>"></td>
                        <br>
                        <br>
                        <button type="submit" name="search" class="button02">検索する</button>
                        <br><br>
                
                        <!-- 会員一覧表示 -->
                        <table width="100%" border="1">
                            <tr>
                                <th scope="col">ID
                                    <input type="submit" name="up" value="▲" <?php if (isset($_POST['up']))  :?>class="hidden-form" <?php endif ;?>>
                                    <input type="submit" name="down" value="▼" <?php if (!isset($_POST['up']))  :?>class="hidden-form" <?php endif ;?>></th>
                                <th scope="col">氏名</th>
                                <th scope="col">性別</th>
                                <th scope="col">住所</th>
                                <th scope="col">登録日時
                                    <input type="submit" name="upup" value="▲" <?php if (isset($_POST['upup']))  :?>class="hidden-form" <?php endif ;?>>
                                    <input type="submit" name="downdown" value="▼" <?php if (!isset($_POST['upup']))  :?>class="hidden-form" <?php endif ;?>></th>
                                <th scope="col">編集</th>
                                <th scope="col">詳細</th>
                                </tr>
                                <?php 
                                    if (isset($disp_data))
                                    foreach ($disp_data as $value) : 
                                    ?>
                            <tr>
                                <td><?php echo $value['id']; ?></td>
                                <td><a href="member_detail.php?id=<?php print($value['id']); ?>"><?php echo $value['name_sei'].$value['name_mei']; ?></a></td>
                                <td><?php if($value['gender'] == "1") {
                                                            print '男性';
                                                        } elseif ($value['gender'] == "2") {
                                                            print '女性';
                                                        };
                                                        ?></td>
                                <td><?php echo $prefecture[$value['pref_id']].$value['address']; ?></td>
                                <td><?php $date = $value['created_at'];
                                echo date('Y/n/j', strtotime($date)); ?></td>
                                <td><a href="member_edit.php?id=<?php print($value['id']); ?>">編集</a></td>
                                <td><a href="member_detail.php?id=<?php print($value['id']); ?>">詳細</a></td>
                            </tr>
                                <?php endforeach ; ?>
                        </table>  
                            <div class="pager">
                            <?php if ($page > 1) : ?>
                                <a href="member.php?id=<?php print($page - 1); ?>"class="page_feed">前へ&raquo;</a>
                            <?php endif; ?>
                            <?php for ($x = 1; $x <= $totalPage; $x++) : ?>
                                <?php if ($x == $page) : ?>
                                    <a href="member.php?id=<?php print($x); ?>" class="now_page"><?php print $x; ?></a>
                                <?php else : ?>
                                    <a href="member.php?id=<?php print($x); ?>"><?php print $x; ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if($page < $totalPage) : ?>
                                <a href="member.php?id=<?php print($page+1); ?>"class="page_feed">次へ&raquo;</a>
                            <?php endif; ?>
                            </div>
                </form>  
            </div>
        </div>
    </body>
</html>