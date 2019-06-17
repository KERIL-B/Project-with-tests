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
	
	$error = array();
	$action = "";
	$action = $_POST["action"];
	
	if(!empty($action)){
		$_POST['name'] = trim(htmlspecialchars($_POST['name']));
		$_POST["psswd"] = trim($_POST["psswd"]);
	
		if(!empty($_POST['email']) and check_email($_POST['email'])){
			$action = "";
			$error[] = "Неверно введен email!";
		}
		
		if(count($error) == 0){
		
			$psswd = md5($_POST["psswd"]);

			$_POST['login'] = $dbh->real_escape_string($_POST['login']);
			$_POST['name'] = $dbh->real_escape_string($_POST['name']);
			$_POST['id_user'] = $dbh->real_escape_string($_POST['id_user']);
		
			if($_POST["psswd"]){
				$update = "UPDATE ".DB_USERS." SET psswd='".$psswd."',
												name='".$_POST['name']."' 
						WHERE id_user=".$_POST['id_user'];
			}
			else{
				$update = "UPDATE ".DB_USERS." SET name='".$_POST['name']."'
							WHERE id_user=".$_POST['id_user'];
			}		
		
			if($dbh->query($update)){
				header("Location: users.php");
				exit();
			}
			else{
				throw new ExceptionMySQL($dbh->error,$update,"Ошибка при выполнении SQL запроса!");		
			}	
		}
	}

	if(empty($action)){
	
		$title = 'Редактирование учетной записи';

		include "header.php";
	
		if(!preg_match("|^[\d]*$|",$_REQUEST['id_user'])) exit();
	
		$query = "SELECT * FROM ".DB_USERS." WHERE id_user=".$_REQUEST['id_user'];
		$result = $dbh->query($query);
		
		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");	 
		
		$row = $result->fetch_array();	

		if(count($error)>0){
			echo '<div class="alert alert-error">';
			echo '<h4 class="alert-heading">Выявлены следующие ошибки:</h4>';
			echo '<ul>';

			foreach($error as $item){
				echo '<li>'.$item.'</li>';
			}
 
			echo '</ul></div>';		
		}	
  
?>
<h2>Редактирование учетной записи</h2>
<p><a href="users.php">« назад</a></p>
<form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="id_user" value="<?php echo $_REQUEST['id_user']; ?>">

<div class="control-group">
    <label for="psswd" class="control-label">Пароль:</label>
    <div class="controls">
      <input type="text" class="span3 input-xlarge focused" name="psswd" value="">
    </div>
  </div>  

<div class="control-group">
    <label for="name" class="control-label">Имя:</label>
    <div class="controls">
      <input type="text" class="span3 input-xlarge focused" name="name" value="<?php echo $row['name']; ?>">
    </div>
</div>  

<div class="form-actions">
<input class="btn btn-success" type="submit" value="редактировать" name="action">
</div>

</form>
<?php

		$dbh->close();

		include "footer.php";
	}	
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}

?>