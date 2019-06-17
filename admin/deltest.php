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
	
	if(!preg_match("|^[\d]*$|",$_GET['id_test'])) exit();
	
	$query = "SELECT * FROM ".DB_QUESTIONS." WHERE id_test=".$_GET['id_test'];
	$result = $dbh->query($query);
	
	if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");
	
	while($row = $result->fetch_array()){
		$delete = "DELETE FROM ".DB_ANSWERS." WHERE id_question=".$row['id_question'];
		$dbh->query($delete);
	}
	
	$delete1 = "DELETE FROM ".DB_TEST." WHERE id_test=".$_GET['id_test'];
	$delete2 = "DELETE FROM ".DB_QUESTIONS." WHERE id_test=".$_GET['id_test'];
	
	if($dbh->query($delete1) and $dbh->query($delete2)){
		$dbh->close();

		header("Location: ".$_SERVER["HTTP_REFERER"]."");
		exit();
	}
	else throw new ExceptionMySQL($dbh->error,'',"Ошибка при выполнении SQL запроса!");
	
	$dbh->close();
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}

?>