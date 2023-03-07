<?php
session_start();
require("../dbconnect.php");
//本番環境　require("../dbconnect.php");
//開発環境　require("../../dbconnect.php");

$finish = $_POST['finish'];
$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

if(isset($finish)) {
    $sql = $db->prepare("UPDATE prdate SET name_sei ='".$_POST['name_sei']."' WHERE id='".$_POST['id']."'");
    $sql->execute();

    $sql = $db->prepare("UPDATE prdate SET name_mei ='".$_POST['name_mei']."' WHERE id='".$_POST['id']."'");
    $sql->execute();

    $sql = $db->prepare("UPDATE prdate SET gender ='".$_POST['gender']."' WHERE id='".$_POST['id']."'");
    $sql->execute();

    $sql = $db->prepare("UPDATE prdate SET pref_id ='".$_POST['pref_id']."' WHERE id='".$_POST['id']."'");
    $sql->execute();

    $sql = $db->prepare("UPDATE prdate SET address ='".$_POST['address']."' WHERE id='".$_POST['id']."'");
    $sql->execute();

    $sql = $db->prepare("UPDATE prdate SET password ='".$hash."' WHERE id='".$_POST['id']."'");
    $sql->execute();

    $sql = $db->prepare("UPDATE prdate SET email ='".$_POST['email']."' WHERE id='".$_POST['id']."'");
    $sql->execute();

    header('Location: member.php');
    exit();
}
?>