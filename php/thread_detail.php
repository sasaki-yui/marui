<?php 
    session_start();
    require("../dbconnect.php");

    $threads_id = substr($_SERVER['REQUEST_URI'],26);

    $login = $db->prepare('SELECT * FROM threads WHERE id=?');
    $login->execute(array($threads_id));
    $threads=$login->fetch();

    $member_id = $threads['member_id'];

    $query = $db->prepare('SELECT * FROM prdate WHERE id=?');
    $query->execute(array($member_id));
    $member=$query->fetch();

if (isset($_POST['message'])) {
    if ($_POST['message'] === "") {
        $error['message'] = "blank";
    }
    if (strlen($_POST['message'])> 500) {
        $error['message'] = 'length';
    }
}

    if (!empty($_POST['message'])) {
        $statement = $db->prepare('INSERT INTO coments SET member_id=?, thread_id=?, comment=?, created_at=NOW(), updated_at=NOW()');
        $statement->execute(array(
            $_SESSION['id'],
            $threads_id,
            $_POST['message']
        ));
    }

    $query = $db->prepare("SELECT * FROM coments WHERE thread_id='".$threads['id']."'");
    $query->execute(array());
    $coments=$query->fetchAll();
// コメント
    define('MAX','5');
    $stmt = $db->prepare("SELECT COUNT(*) FROM coments WHERE thread_id='".$threads['id']."'");
    $stmt->execute();
    $coments_count = $stmt->fetchColumn();

    $totalPage = ceil($coments_count/5);

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

    $disp_data = array_slice($coments, $start_no, MAX, true);

    if (isset($_GET['like'])) {
        $likese_id = (int)$_GET['like'];
    } else {
        $likese_id = 0;
    }
    
    
    ?>


<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf8mb4">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <title>スレッド詳細</title>
        <link href="http://153.126.213.22/php/thread_regist.php" rel="stylesheet"/>
        <link rel="stylesheet" href="style05.css">
    </head>
    <body>
        <div class="content">
                <div class="menu">
                    <ul id="nav">
                    <li><a href="https://ik1-342-31268.vs.sakura.ne.jp/php/thread.php">スレッド一覧に戻る</a></li>
                    </ul>
                </div>

                
                <div class="content">
                    <h2><?php echo htmlspecialchars($threads['title']); ?></h2>
                    <p><?php echo $coments_count; ?>コメント
                    <?php echo htmlspecialchars($threads['created_at']); ?></p>
                </div>
                <br>

                    <div class="pager">
                        <?php if ($page >= 2): ?>
                        <a href="https://ik1-342-31268.vs.sakura.ne.jp/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page-1); ?>"class="page_feed">前へ&raquo;</a>
                        <?php else: ?>
                            <span class="first_last_page">前へ&raquo;</span>
                        <?php endif; ?>
                
                        <?php if($page < $totalPage) : ?>
                        <a href="https://ik1-342-31268.vs.sakura.ne.jp/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page+1); ?>"class="page_feed">次へ&raquo;</a>
                        <?php else : ?>
                            <span class="first_last_page">次へ&raquo;</span>
                        <?php endif; ?>
                    </div>

                    <div class="content">
                        <td>
                        <p>投稿者：<?php echo htmlspecialchars($member['name_sei']).($member['name_mei']); ?>
                        <?php echo htmlspecialchars($threads['created_at']); ?>
                        <br>
                        <?php echo nl2br($threads['comment']); ?></p>
                        </td>
                        </div>
                        <br>

                        <div class="content">
                        <table>
                        <?php foreach ($disp_data as $value) : ?>
                        <tr>
                        <td><h4><?php echo $value['id']; ?></td>
                        <td><?php echo $member['name_sei'].$member['name_mei']; ?></td>
                        <td><?php echo $value['created_at']; ?></h4></td>
                        <td><p><?php echo $value['comment']; ?></p></td>
                        <td><a href="https://ik1-342-31268.vs.sakura.ne.jp/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page+1); ?>&like=<?php echo ($likese_id); ?>">♡</a></td>       
                        <?php endforeach ?>
                        </table>
                    </div>

                    <div class="pager">
                        <?php if ($page >= 2): ?>
                        <a href="https://ik1-342-31268.vs.sakura.ne.jp/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page-1); ?>"class="page_feed">前へ&raquo;</a>
                        <?php else: ?>
                            <span class="first_last_page">前へhu&raquo;</span>
                        <?php endif; ?>
                
                        <?php if($page < $totalPage) : ?>
                        <a href="https://ik1-342-31268.vs.sakura.ne.jp/php/thread_detail.php?id=<?php echo $threads_id; ?>&page=<?php echo ($page+1); ?>"class="page_feed">次へ&raquo;</a>
                        <?php else : ?>
                            <span class="first_last_page">次へ&raquo;</span>
                        <?php endif; ?>
                    </div>
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
            