<?php



require "lib/config.php";

$title = 'Добавить вопрос';

ob_start();

require "class/class.exception_mysql.php";

try
{
	require_once "lib/function.inc";
	require_once "lib/connect.inc";
	require_once "lib/authenticate.inc";
	
	if($_SESSION['login'] != 'admin') error('Вам сюда нельзя!');	
	
	if($_POST['action']){
		$_POST['name'] = trim($_POST['name']);
		$_POST['answer1'] = trim(htmlspecialchars($_POST['answer1']));
		$_POST['answer2'] = trim(htmlspecialchars($_POST['answer2']));
		$_POST['answer3'] = trim(htmlspecialchars($_POST['answer3']));
		$_POST['answer4'] = trim(htmlspecialchars($_POST['answer4']));
		$_POST['answer5'] = trim(htmlspecialchars($_POST['answer5']));
		
		if($_POST['name'] == '') error('Введите вопрос!');
		
		$_POST['name'] = $dbh->real_escape_string($_POST['name']);
		$_POST['id_test'] = $dbh->real_escape_string($_POST['id_test']);
		
		$_POST['answer1'] = $dbh->real_escape_string($_POST['answer1']);
		$_POST['answer2'] = $dbh->real_escape_string($_POST['answer2']);
		$_POST['answer3'] = $dbh->real_escape_string($_POST['answer3']);
		$_POST['answer4'] = $dbh->real_escape_string($_POST['answer4']);
		$_POST['answer5'] = $dbh->real_escape_string($_POST['answer5']);
		
		$_POST['rightanswer1'] = ($_POST['rightanswer1'] == 'on' ? 1 : 0);
		$_POST['rightanswer2'] = ($_POST['rightanswer2'] == 'on' ? 1 : 0);
		$_POST['rightanswer3'] = ($_POST['rightanswer3'] == 'on' ? 1 : 0);
		$_POST['rightanswer4'] = ($_POST['rightanswer4'] == 'on' ? 1 : 0);
		$_POST['rightanswer5'] = ($_POST['rightanswer5'] == 'on' ? 1 : 0);
		
		$insert = "INSERT INTO ".DB_QUESTIONS." (`id_question`,`name`,`answer1`,`answer2`,`answer3`,`answer4`,`answer5`,`rightanswer1`,`rightanswer2`,`rightanswer3`,`rightanswer4`,`rightanswer5`,`id_test`) 
		VALUES (0,'".$_POST['name']."','".$_POST['answer1']."','".$_POST['answer2']."','".$_POST['answer3']."','".$_POST['answer4']."','".$_POST['answer5']."',".$_POST['rightanswer1'].",".$_POST['rightanswer2'].",".$_POST['rightanswer3'].",".$_POST['rightanswer4'].",".$_POST['rightanswer5'].",".$_POST['id_test'].")";
		$result = $dbh->query($insert);

		if(!$result) throw new ExceptionMySQL($dbh->error,$insert,"Ошибка при выполнении SQL запроса!");
		
		$dbh->close();
		
		header("Location: index.php?id_test=".$_POST['id_test']."");
		exit();	
	}
	else{	
	
		include "header.php";
		
?>
<p><a href="index.php?id_test=<?php echo $_GET['id_test']; ?>">« назад</a></p>
<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" value="<?php echo $_GET['id_test']; ?>" name="id_test">

<div class="control-group">
    <label for="name" class="control-label-large">Вопрос:</label>
    <div class="controls-large">
      <input type="text" class="span5 input-xlarge focused" name="name" value="">
    </div>
</div>  
  
<div class="control-group">
<label class="control-label-large" for="answer1">Вариант ответа №1:</label>
<div class="controls-large">
<input class="span5 focused" type="text" name="answer1" value="">
<input type="checkbox" name="rightanswer1">
</div>
</div>  
  
<div class="control-group">
<label class="control-label-large" for="answer2">Вариант ответа №2:</label>
<div class="controls-large">
<input class="span5 focused" type="text" name="answer2" value="">
<input type="checkbox" name="rightanswer2">
</div>
</div> 
  
<div class="control-group">
<label class="control-label-large" for="answer3">Вариант ответа №3:</label>
<div class="controls-large">
<input class="span5 focused" type="text" name="answer3" value="">
<input type="checkbox" name="rightanswer3">
</div>
</div> 

<div class="control-group">
<label class="control-label-large" for="answer4">Вариант ответа №4:</label>
<div class="controls-large">
<input class="span5 focused" type="text" name="answer4" value="">
<input type="checkbox" name="rightanswer4">
</div>
</div> 

<div class="control-group">
<label class="control-label-large" for="answer5">Вариант ответа №5:</label>
<div class="controls-large">
<input class="span5 focused" type="text" name="answer5" value="">
<input type="checkbox" name="rightanswer5">
</div>
</div> 

<div class="form-actions">
<input class="btn btn-success" type="submit" value="Добавить" name="action">
</div>  
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
