<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=practice;charset=utf8mb4','root','selVa_kiasas11');
   } catch (PDOException $e) {
    echo "データベース接続エラー：".$e->getMessage();

}
?>

<?php
// try {
//     $db = new PDO('mysql:host=localhost;dbname=practice;charset=utf8mb4','root','selVa_kiasas11');
//    } catch (PDOException $e) {
//     echo "データベース接続エラー：".$e->getMessage();

// }
?>