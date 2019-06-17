<?php

require "lib/config.php";

ob_start();

$title = 'Редактирование теста';

require "class/class.exception_mysql.php";

try
{
	require_once "lib/function.inc";
	require_once "lib/connect.inc";
	require_once "lib/authenticate.inc";
	
	if(!preg_match("|^[\d]*$|",$_GET['id_test'])) exit();	
	
	if($_POST['action'] != ''){
		
		$_POST['name'] = trim($_POST['name']);
		$_POST['description'] = trim($_POST['description']);
		
		if($_POST['name'] == '') exit('Укажите название!');
		
		$_POST['id_test'] = $dbh->real_escape_string($_POST['id_test']);
		$_POST['name'] = $dbh->real_escape_string($_POST['name']);
		$_POST['description'] = $dbh->real_escape_string($_POST['description']);
		
		$update = "UPDATE ".DB_TEST." SET name='".$_POST['name']."',description='".$_POST['description']."' WHERE id_test=".$_POST['id_test'];
		
		if($dbh->query($update)) {
			header("Location: index.php");
			exit();
		}
		else{
			throw new ExceptionMySQL($dbh->error,$update,"Ошибка при выполнении SQL запроса!");		
		}	
	}
	else{
	
		include "header.php";
	
		$query = "SELECT * FROM ".DB_TEST." WHERE id_test=".$_GET['id_test'];
		$result = $dbh->query($query);
	
		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");
	
		$row = $result->fetch_array();
		
?>
<p><a href="index.php">« назад</a></p>
<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" value="<?php echo $_GET['id_test']; ?>" name="id_test">

<div class="control-group">
    <label for="name" class="control-label">Название:</label>
    <div class="controls">
      <input type="text" class="span3 input-xlarge focused" name="name" value="<?php echo $row['name']; ?>">
    </div>
  </div>  
  
<div class="control-group">
<label class="control-label" for="textconfirmation">Описание:</label>
<div class="controls">
<textarea class="span5" name="description" rows="5"><?php echo $row['description']; ?></textarea>
</div>
  </div>

  
  <div class="form-actions">
<input class="btn btn-success" type="submit" value="Редактипровать" name="action">
</div>

</form>
<?php
	
		$result->close();
	
		include "footer.php";	
	}	
	
	$dbh->close();
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}
	
?>