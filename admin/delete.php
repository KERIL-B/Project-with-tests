<?php


require "lib/config.php";

ob_start();

require "class/class.exception_mysql.php";

try
{
	require_once "lib/function.inc";
	require_once "lib/connect.inc";
	require_once "lib/authenticate.inc";
	
	if($_SESSION['login'] != 'admin') error('Вам сюда нельзя!');
	
	if($_GET['login'] == $_SESSION['login']){
		exit('Вы не можете удалить учетную запись под которой находитесь!');
	}
	else{
		$_GET['login'] = $dbh->real_escape_string($_GET['login']);
	
		$delete = "DELETE FROM ".DB_USERS." WHERE login LIKE '".$_GET['login']."'";
	
		if($dbh->query($delete)){
			header("Location: ".$_SERVER["HTTP_REFERER"]."");
			exit();
		}
		else{
			throw new ExceptionMySQL($dbh->error,$delete,"Ошибка при выполнении SQL запроса!");	
		}		
	}	
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}
	
?>