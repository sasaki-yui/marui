<?php 
    session_start();
    require("dbconnect.php");
//本番環境　require("dbconnect.php");
//開発環境　require("../dbconnect.php");

    //threadsテーブルより$threadsを取得
    $url = $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $results);
    $threads_id = $results['id'];

    $login = $db->prepare('SELECT * FROM threads WHERE id=?');
    $login->execute(array($threads_id));
    $threads=$login->fetch();

    //prdateテーブルより$memberを取得
    $member_id = $threads['member_id'];

    $query = $db->prepare('SELECT * FROM prdate WHERE id=?');
    $query->execute(array($member_id));
    $member=$query->fetch();

    //コメント欄のエラーを察知
    if (isset($_POST['message'])) {
        if ($_POST['message'] === "") {
            $error['message'] = "blank";
        }
        if (strlen($_POST['message'])> 1540) {
            $error['message'] = 'length';
        }
    }

    //コメントのデータをcomentsテーブルに挿入
    if (!isset($error['message'])) {
        if (!empty($_POST['message'])) {
            $coments = $db->prepare('INSERT INTO coments SET member_id=?, thread_id=?, comment=?, created_at=NOW(), updated_at=NOW()');
            $coments->execute(array(
                $_SESSION['id'],
                $threads_id,
                $_POST['message']
            ));
        }
    }

    //コメント数を取得
    define('MAX','5');
    $stmt = $db->prepare("SELECT COUNT(*) FROM coments WHERE thread_id='".$threads['id']."'");
    $stmt->execute();
    $coments_count = $stmt->fetchColumn();

    $totalPage = ceil($coments_count/5);

    //ページネーション
    if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    } else {
        $page = 1;
    }
  
    if ($page > 1) {
        $start_no = ($page - 1) * MAX;
    } else {
        $start_no = 0;
    }
    $_SESSION['page'] = $page;

    //コメント表示
    $sql =  $db->prepare("SELECT * FROM prdate INNER JOIN coments ON prdate.id=coments.member_id WHERE coments.thread_id='".$threads['id']."'");
    $sql->execute(array());
    $pre=$sql->fetchAll();

    $disp_data = array_slice($pre, $start_no, MAX, true);
    
    //いいねの重複チェック
if (isset($_SESSION['id'])) {
    if (isset($_POST['like']) && isset($_POST['member_id']) && isset($_POST['coments_id'])) {
        $mem_id = (int)$_POST['member_id'];
        $com_id = (int)$_POST['coments_id'];

        $like_mem = $db->prepare("SELECT id FROM likese WHERE coments_id='".$com_id."' AND member_id='".$_SESSION['id']."'");
        $like_mem->execute();
        $like_id=$like_mem->fetchColumn();

        //重複していたらいいね削除・それ以外はデータ挿入
        if (isset($_SESSION['id'])) {
            $id = $like_id;

            if (!empty($like_id)) {
                $delete = $db->prepare("DELETE FROM likese WHERE id=?");
                $delete->bindValue(1, $id);
                $delete->execute();
            } else {
                $like = $db->prepare("INSERT INTO likese SET member_id=?, coments_id=?");
                $like->execute(array(
                    $_SESSION['id'],
                    $com_id
                ));
            }
        }
    }
} else {
    if (isset($_POST['like']) && isset($_POST['member_id']) && isset($_POST['coments_id'])) {
        header('Location: member_regist.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf8mb4">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <title>スレッド詳細</title>
        <link rel="stylesheet" href="style05.css">
    </head>
    <body>
        <div class="content">
                <div class="menu">
                    <ul id="nav">
                    <li><a href="/php/thread.php">スレッド一覧に戻る</a></li>
                    </ul>
                </div>   
                <div class="content">
                    <h2><?php echo htmlspecialchars($threads['title']); ?></h2>
                    <p><?php echo $coments_count; ?>コメント
                    <?php $date = $threads['created_at'];
                          echo date('n/j/y/G:i', strtotime($date)); ?></p>
                </div>
                <br>
                    <div class="pager">
                        <?php if ($page >= 2): ?>
                        <a href="/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page-1); ?>"class="page_feed">前へ&raquo;</a>
                        <?php else: ?>
                            <span class="first_last_page">前へ&raquo;</span>
                        <?php endif; ?>
                        <?php if($page < $totalPage) : ?>
                        <a href="/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page+1); ?>"class="page_feed">次へ&raquo;</a>
                        <?php else : ?>
                            <span class="first_last_page">次へ&raquo;</span>
                        <?php endif; ?>
                    </div>
                    <div class="content">
                        <div class="box">
                            <p>投稿者：<?php echo htmlspecialchars($member['name_sei']).($member['name_mei']); ?>
                                <?php $date = $threads['created_at'];
                                echo date('Y.n.j G:i', strtotime($date)); ?>
                                <br>
                                <?php echo nl2br($threads['comment']); ?>
                            </p>
                        </div>
                    </div>
                        <br>
                        <div class="content">
                            <div>
                                <?php foreach ($disp_data as $value) : ?>
                                    <div><?php echo $value['id']; ?>
                                        <?php 
                                        $like_query = $db->prepare("SELECT COUNT(*) FROM likese WHERE coments_id='".$value['id']."'");
                                        $like_query->execute();
                                        $like_count = $like_query->fetchColumn();
                                        ?>
                                    </div>
                                    <div><?php echo $value['name_sei'].$value['name_mei']; ?></div>
                                    <div><?php $date = $value['created_at'];
                                        echo date('Y.n.j G:i', strtotime($date)); ?></div>
                                    <br>
                                    <div><?php echo $value['comment']; ?></div>
                                    <br>

                                    <?php 
                                        if (isset($_SESSION['id'])) {
                                            $like_master = $db->prepare("SELECT COUNT(*) FROM likese WHERE coments_id='".$value['id']."' AND member_id='".$_SESSION['id']."'");
                                            $like_master->execute();
                                            $master_count = $like_master->fetchColumn();
                                        }
                                        ?>
                                    
                                    <form action="" method="POST">
                                        <input type="hidden" value="<?=$member_id?>" name="member_id">
                                        <input type="hidden" value="<?=$value['id']?>" name="coments_id">
                                        <button type="submit" name="like" class="heart">
                                        <?php if (isset($master_count) && $master_count > 0): ?>
                                        ♥
                                        <?php else: ?>
                                        ♡
                                        <?php endif; ?>
                                        </button>
                                    </form>
                                    <?php echo $like_count; ?>
                            </div>
                                    <br>
                                <?php endforeach ; ?>
                        </div>
                        <div class="pager">
                            <?php if ($page >= 2): ?>
                            <a href="/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page-1); ?>"class="page_feed">前へ&raquo;</a>
                            <?php else: ?>
                                <span class="first_last_page">前へ&raquo;</span>
                            <?php endif; ?>
                            <?php if($page < $totalPage) : ?>
                            <a href="/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page+1); ?>"class="page_feed">次へ&raquo;</a>
                            <?php else : ?>
                                <span class="first_last_page">次へ&raquo;</span>
                            <?php endif; ?>
                        </div>

                        <form action="" method="POST" <?php if (!isset($_SESSION['id']))  :?>class="hidden-form" <?php endif ;?>>
                            <input type="hidden" value="<?=$member_id?>" name="member_id">
                            <textarea name="message" rows="10" cols="50" wrap="hard"></textarea>
                            <br>
                            <button type="submit" class="btn">コメントする</button>

                            <?php if (isset($error['message']) && ($error['message'] == "blank")): ?>
                                    <p class="error">コメントを入力してください</p>
                                    <?php endif; ?>
                            <?php if (isset($error['message']) && ($error['message'] == "length")): ?>
                                    <p class="error"> ※コメントは500文字以内で入力してください</p>
                                    <?php endif; ?>
                        </form>

        </div>
    </body>
</html>
            