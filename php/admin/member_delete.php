<?php
session_start();
require("../dbconnect.php");
//本番環境　require("../dbconnect.php");
//開発環境　require("../../dbconnect.php");

    $url = $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $results);
    $delete_id = $results['id'];

    $login = $db->prepare('SELECT * FROM prdate WHERE id=?');
    $login->execute(array($delete_id));
    $delete=$login->fetch();

    //deleted_atデータを挿入する
        if (isset($delete_id)) {
            $sql = $db->prepare("UPDATE prdate SET deleted_at =NOW() WHERE id='".$delete['id']."'");
            $sql->execute();

            $sql = $db->prepare("UPDATE threads SET deleted_at =NOW() WHERE member_id='".$delete['id']."'");
            $sql->execute();
        
            $sql = $db->prepare("UPDATE coments SET deleted_at =NOW() WHERE member_id='".$delete['id']."'");
            $sql->execute();
            
            header('Location: member.php');
            exit();
        }

?>