<?php

$dbh = new mysqli($db_location, $db_user, $db_passwd, $db_name);

if(mysqli_connect_errno())
{
	error("Ошибка подключения к MySQL database: Сервер БД $db_location недоступен!");
}

$versql = $dbh->server_info;
list($major, $minor) = explode(".", $versql);
$ver = $major.".".$minor;

if((float)$ver >= 4.1 AND !empty($db_charset))
{
	$dbh->query("SET NAMES '".$db_charset."'");
}

?>