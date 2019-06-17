<?php


function check_email ($email)
{
	if(preg_match("/^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,6})$/i", $email))
		return false;
	else	
		return true;
}

function get_result_test ($id_log,$test_result)
{
	global $dbh;
	
	$query = "SELECT COUNT(*) FROM ".DB_RESULT." WHERE id_log=".$id_log." AND test_result=".$test_result."";
	$result = $dbh->query($query);

	if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");

	$row = $result->fetch_assoc();
	$total = $row['COUNT(*)'];
	
	$result->close();
	
	return $total;
}

function error ($msg)
{
	echo "<html><head>";
	echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">";
	echo "</head><body>";
	echo "<p>".$msg."</p>";
	echo "<p><a href=javascript:history.go(-1);>".BACK."</a></p>";
	echo "</body></html>";
	exit();
}

?>