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
	
	$title = 'Результат тестирования';
	
	$count = 20;
    $page = $_GET['page'];
    if(empty($page)) $page = 1;
    $begin = ($page - 1)*$count;
	
	$query = "SELECT COUNT(*) FROM ".DB_LOG."";
    $result = $dbh->query($query);

    if(!$result)  throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");

    $total = $result->fetch_assoc();
    $result->close();

    $counter = $total['COUNT(*)'];
    $number = intval(($total['COUNT(*)'] - 1) / $count) + 1;

    if($page != 1) $pervpage = '<a href=results.php?page=1>&lt;&lt;</a>
                                <a href=results.php?page='.($page - 1).'>&lt;</a>';

    if($page != $number) $nextpage = '<a href=results.php?page='.($page + 1).'>&gt;</a>
                                       <a href=results.php?page='.$number.'>&gt;&gt;</a>';

    if($page - 2 > 0) $page2left = '&nbsp;<a href=results.php?page='.($page - 2).'>...'.($page - 2).'</a>';
    if($page - 1 > 0) $page1left = '<a href=results.php?page='.($page - 1).'>'.($page - 1).'</a>';
    if($page + 2 <= $number) $page2right = '<a href=results.php?page='.($page + 2).'>'.($page + 2).'...</a>';
    if($page + 1 <= $number) $page1right = '<a href=results.php?page='.($page + 1).'>'.($page + 1).'</a>';	
	
	include "header.php";	
	
?>
	<table class="table table-striped table-bordered table-hover dataTable" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
    <tr>
	<th>ФИО</th>
	<th>Тест</th>
	<th>Правильно</th>
	<th>Неправильно</th>
	<th>Дата</th></tr>		
	</thead>
    <tbody>
<?php
	
	$query = "SELECT *,c.name AS fio, b.name AS test,DATE_FORMAT(a.time,'%d.%m.%Y %H:%i') as testtime FROM ".DB_LOG." a 
				LEFT JOIN ".DB_TEST." b ON a.id_test=b.id_test
				LEFT JOIN ".DB_USERS." c ON a.id_user=c.id_user
				LIMIT ".$begin.", ".$count."";
				
	$result = $dbh->query($query);
	
	if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");
	
	while($row = $result->fetch_array())
	{
		echo '<tr class="td-middle"><td>'.$row['fio'].'</td><td>'.$row['test'].'</td><td>'.get_result_test ($row['id_log'],1).'</td><td>'.get_result_test ($row['id_log'],0).'</td><td>'.$row['testtime'].'</td></tr>';
	}

	$result->close();	
	
	echo '</tbody></table>';	
	
	echo '<div class="pagination"><ul>';
  
	if($pervpage) echo "<li>$pervpage</li>";
	if($perv) echo "<li>$perv</li>";
	if($page2left) echo "<li>$page2left</li>";
	if($page1left) echo "<li>$page1left</li>";
    if($current_page) echo "<li>$current_page</li>";
	if($page1right) echo "<li>$page1right</li>";
	if($page2right) echo "<li>$page2right</li>";
	if($nextpage) echo "<li>$nextpage</li>";
	if($next) echo "<li>$next</li>";

	echo '</ul></div>';	
	
	include "footer.php";	
	
	$dbh->close();
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}

?>
