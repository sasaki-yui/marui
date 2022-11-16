<?php
try {
    $db = new PDO('mysql:dbname=practice;host=;charset=utf8', 'root', 'selVa_kiasas11');
}   catch (PDOException $e) {
    echo "データベース接続エラー：".$e->getMessage();
}
?>