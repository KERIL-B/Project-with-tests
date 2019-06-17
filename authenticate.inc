<?php


session_start();

$_POST['login'] = trim($_POST['login']);
$_POST['password'] = trim($_POST['password']);
$_POST['login'] = $dbh->real_escape_string($_POST['login']);

if(!empty($_POST['admin']))
{
	if(empty($_POST['login'])) ErrorAut("Введите логин!");
	if(empty($_POST['password'])) ErrorAut("Введите пароль!");

	$query = "SELECT * FROM ".DB_USERS." WHERE login LIKE '".$_POST['login']."'";
	$result = $dbh->query($query);

	if($result) { $aut = $result->fetch_array(); 
	}
	$result->close();

	if($_SESSION['sess_admin'] != "ok"){
		$_SESSION['login'] = $_POST['login'];
	}

	$hash = md5($_POST['password']);

	if($hash == $aut['psswd']){
		$_SESSION['sess_admin'] = "ok";
		$_SESSION['login'] = $aut['login'];
		$_SESSION['id_user'] = $aut['id_user'];
		
		if($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];
	}
	else{
		ErrorAut("Извините, но Вы не прошли авторизацию.\\nДоступ закрыт!");
	}
}
else
{
	if($_SESSION['sess_admin'] != "ok"){
		ShowAdmin();
	}
}

function ShowAdmin()
{

?>
<!DOCTYPE html>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<link rel="stylesheet" href="bower_components/normalize.css/normalize.css">
    <link rel="stylesheet" href="bower_components/bootstrap-grid-css/grid.css">
<link rel="StyleSheet" type="text/css" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<title>Авторизация</title>
<head>
<body id="start">
<div class="container">
        <div class="row">
		<div id="main-page" class="col-lg-12, center">
                <h1>Онлайн тестирование</h1>
                <div id="wrapper">
<form method="post">
<input name="login" type="text" value="Логин"><br> 
<input name="password" type="password" value="Пароль"><br> 
<input name="admin" type="submit" id="but" style=" margin-top: 5px; " value="Войти"> 
<p></p>
<a id="reg" href="registration.php">Регистрация</a>
</form>
</div>
</div>
</div>
</div>
</body>
</html>
<?php

	exit();
}

function ErrorAut($msg)
{

?>
<!DOCTYPE html>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<title>Ощибка авторизации!</title>
</head>
<body>
<script type='text/javascript'>
window.alert('<?php echo $msg; ?>');
window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>';
</script>
</body>
</html>
<?php

	exit();
}

?>