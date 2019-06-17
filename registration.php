<?php
require "admin/lib/config.php";
require "admin/class/class.exception_mysql.php";

try
{
	require_once "admin/lib/function.inc";
	require_once "admin/lib/connect.inc";	

	$error = array();
	$action = "";
	$action = $_POST["action"];	

	if(!empty($action)){
		$_POST['login'] = trim($_POST['login']);
		$_POST['passw'] = trim(htmlspecialchars($_POST['passw']));
		$_POST['name'] = trim(htmlspecialchars($_POST['name']));
	
		if(empty($_POST['login'])){
			$action = "";
			$error[] = "Введите логин!";
		}

		if(!preg_match("/^([0-9a-z]+)$/ui", $_POST['login'])){
			$action = "";
			$error[] = "В логине разрешено использовать только латинские буквы и цыфры!";
		}
	
		if(empty($_POST['passw'])){
			$action = "";
			$error[] = "Введите пароль!";
		}
	
		if(strlen($_POST['passw'])<6) {
			$action = "";
			$error[] = "Количество символов в пароле меньше 6!";
		}
	
		if(!empty($_POST['login'])){
		
			$query = "SELECT * FROM ".DB_USERS." WHERE login LIKE '".$_POST['login']."'";
			$result = $dbh->query($query);
			
			if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!"); 
	
			if($result->num_rows>0){
				$action = "";
				$error[] = "Данный логин уже зарегистрирован. Введите другой!";
			}
		}	

		$_POST['passw'] = md5($_POST['passw']);
	
		if(count($error)== 0){
		
			$_POST['login'] = $dbh->real_escape_string($_POST['login']);
			$_POST['name'] = $dbh->real_escape_string($_POST['name']);
		
			$insert = "INSERT INTO ".DB_USERS." (`id_user`,`login`,`psswd`,`name`) VALUES (0,'".$_POST['login']."','".$_POST['passw']."','".$_POST['name']."')";
			$result = $dbh->prepare($insert);
	
			if($result){
				$result->execute();	
				header("Location: index.php");
				exit();
			}
			else throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!"); 			
		}
	}

	if(empty($action)){
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="StyleSheet" type="text/css" href="style.css">
<title>Регистрация</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body id="start" class="center">
<div class="container">
        <div class="row">
		<div id="main-page" class="col-lg-12">
<h1>Регистрация</h1>
<div id="wrapper">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="text" name="login" placeholder="Логин" value="Логин" size="25"><br> 
<input type="password" name="passw" placeholder="Пароль" value="Password" size="25"><br>
<input type="text" name="name" placeholder="Введите ФИО" value="<?php echo $_POST['name']; ?>" size="25"><br>
<input type="submit" id="but" style=" margin-top: 5px; " value="Регистрация" name="action">
</form>
</div>
</div>
</div>
</div>
<?php

		if(count($error)>0){
			echo "<p class=error>Выявлены следующие ошибки: </p>";
			echo "<UL class=error>";
			
			foreach($error as $item){
				echo "<li>$item</li>";
			}
			
			echo "</UL>";
		}
	}

?>
</body>
</html>
<?php

}
catch(ExceptionMySQL $exc)
{
	require_once("admin/lib/exception_mysql_debug.inc");
}

?>