﻿<?php

if(DEBUG == 1){
	echo "<html><head>";
	echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">";
	echo "</head><body>";
	echo "<p>An error occurred while accessing the MySQL database .</p>";
	echo "<p>{$exc->getMySQLError()}<br>".nl2br($exc->getSQLQuery())."</p>";
	echo "<p>Error in file {$exc->getFile()} at line {$exc->getLine()}.</p>";
	echo "</body></html>";
	exit();
}
else{
	header('HTTP/1.1 500 Internal Server Error');
	header("Location: error.php");
	exit();
}

?>
