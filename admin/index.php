<?php



require "lib/config.php";

ob_start();

$title = 'Список тестов';

require "class/class.exception_mysql.php";

try
{
	require_once "lib/connect.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/function.inc";
	
	if(!preg_match("|^[\d]*$|",$_GET['id_test'])) exit();
	
	if($_SESSION['login'] != 'admin') error('Вам сюда нельзя!');
	
	include "header.php";
	
	if($_GET['id_test'] == ''){
		$query = "SELECT * FROM ".DB_TEST." ORDER by id_test";
		$result = $dbh->query($query);
	
		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");
		
				
?>
<table class="table-hover table table-bordered" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
      <tr>
        <th style="text-align: center;" width="30%">Тесты</th>
        <th  style="text-align: center;" width="40%">Описание</th>
        <th  style="text-align: center;">Действие</th>
      </tr>
    </thead>
	<tbody>
<?php
	
		while($row = $result->fetch_array()){	
		
			echo '<tr class="td-middle">
			<td><a href="index.php?id_test='.$row['id_test'].'">'.$row['name'].'</a></td>
			<td>'.$row['description'].'</td>
			<td><a class="btn" href="edittest.php?id_test='.$row['id_test'].'"><i class="icon-pencil"></i> Редактировать</a> <a class="btn" href="deltest.php?id_test='.$row['id_test'].'"><i class="icon-trash"></i> Удалить</a>
			</td></tr>';
		}
	
		echo ' </tbody></table>';
		echo '<a id="but" style="margin-left: 40%;" href="addnewtest.php">добавить тест</a>';
	
		$result->close();	
	}
	else{
		$query = "SELECT * FROM ".DB_QUESTIONS." WHERE id_test=".$_GET['id_test'];
		$result = $dbh->query($query);
	
		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");
		
?>
<table class="table-hover table table-bordered" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
      <tr>
        <th width="50%">Вопросы</th>
        <th>Действие</th>
      </tr>
    </thead>
	<tbody>
<?php
	
		while($row = $result->fetch_array()){
			echo '<tr class="td-middle">
			<td>'.$row['name'].'</td>
			<td><a class="btn" href="editquestion.php?id_question='.$row['id_question'].'"><i class="icon-pencil"></i> Редактировать</a> <a class="btn" href="delquestion.php?id_question='.$row['id_question'].'"><i class="icon-trash"></i> Удалить</a>
			</td></tr>';
		}
	
		echo '</tbody></table>';
		echo '<a class="btn btn-success" href="addquestion.php?id_test='.$_GET['id_test'].'">добавить вопрос</a>';
	
		$result->close();
	}		

	include "footer.php";	
	
	$dbh->close();
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}

?>