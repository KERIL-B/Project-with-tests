<?php


require "lib/config.php";

ob_start();

require "class/class.exception_mysql.php";

$title = 'Добавить тест';

try
{
	require_once "lib/function.inc";
	require_once "lib/connect.inc";
	require_once "lib/authenticate.inc";
	
	if($_SESSION['login'] != 'admin') error('Вам сюда нельзя!');	
	
	if($_POST['action']){
		$_POST['name'] = trim($_POST['name']);
		$_POST['description'] = trim($_POST['description']);
		
		if($_POST['name'] == '') error('Введите назавание!');
		
		$_POST['name'] = $dbh->real_escape_string($_POST['name']);
		$_POST['description'] = $dbh->real_escape_string($_POST['description']);
		
		$insert = "INSERT INTO ".DB_TEST." (`id_test`,`name`,`description`) VALUES (0,'".$_POST['name']."','".$_POST['description']."')";
		$result = $dbh->query($insert);

		if(!$result) throw new ExceptionMySQL($dbh->error,$insert,"Ошибка при выполнении SQL запроса!");

		$dbh->close();
		
		header("Location: index.php");
		exit();	
	}
	else{
	
		include "header.php";
		
?>

<p><a href="index.php">« назад</a></p>
<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="control-group">
    <label for="name" class="control-label">Название:</label>
    <div class="controls">
      <input type="text" class="span3 input-xlarge focused" name="name" value="">
    </div>
  </div>  
  
<div class="control-group">
<label class="control-label" for="textconfirmation">Описание:</label>
<div class="controls">
<textarea class="span5" name="description" rows="5"></textarea>
</div>
  </div>
  
<div class="form-actions">
<input class="btn btn-success" type="submit" value="Добавить" name="action">
</div>  

</form>
<?php
	
		include "footer.php";	
	}	
	
	$dbh->close();
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}

?>
