<?php


session_start();

$_SESSION['sess_admin'] = "";
$_SESSION['login'] = "";
$_SESSION['id_user'] = "";
$_SESSION['id_log'] = '';
$_SESSION['stage'] = '';
$_SESSION['start'] = '';

header("Location: index.php");

?>