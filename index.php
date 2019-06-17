<?php

require "admin/lib/config.php";
require "admin/class/class.exception_mysql.php";

try
{
	require_once "admin/lib/function.inc";
	require_once "admin/lib/connect.inc";
	require_once "authenticate.inc";
	
	if(!preg_match("|^[\d]*$|",$_GET['id_test'])) exit();
	
	if($_POST['action'] != '' and $_SESSION['id_log'] != ''){
		if($_POST['reply']){
			$_POST['id_question'] = $dbh->real_escape_string($_POST['id_question']);
			$_POST['rightanswer1'] = ($_POST['rightanswer1'] == 'on' ? 1 : 0);
			$_POST['rightanswer2'] = ($_POST['rightanswer2'] == 'on' ? 1 : 0);
			$_POST['rightanswer3'] = ($_POST['rightanswer3'] == 'on' ? 1 : 0);
			$_POST['rightanswer4'] = ($_POST['rightanswer4'] == 'on' ? 1 : 0);
			$_POST['rightanswer5'] = ($_POST['rightanswer5'] == 'on' ? 1 : 0);
			
			$query = "SELECT * FROM ".DB_QUESTIONS." WHERE id_question=".$_POST['id_question'];
			$result = $dbh->query($query);

			if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");

			$row = $result->fetch_array();	
			
			if($row['rightanswer1'] == $_POST['rightanswer1'] and $row['rightanswer2'] == $_POST['rightanswer2'] and $row['rightanswer3'] == $_POST['rightanswer3'] and $row['rightanswer4'] == $_POST['rightanswer4'] and $row['rightanswer5'] == $_POST['rightanswer5']){
				$test_result = 1;
			}
			else{
				$test_result = 0;
			}
		
			$result->close();				
		}
		else if($_POST['ignore']){
			$test_result = 0;
		}
		else if($_POST['complete']){
			$_SESSION['stage'] = '';
			$_SESSION['start'] = '';
			$_SESSION['id_log'] = '';
			header("Location: ".$_SERVER["PHP_SELF"]."");
			exit;
		}
		
		$insert = "INSERT INTO ".DB_RESULT." (`id_result`,`time`,`test_result`,`id_question`,`id_log`) VALUE (0,now(),".$test_result.",".$_POST['id_question'].",".$_SESSION['id_log'].")";
		$result=$dbh->prepare($insert);
			
		if($result){
			$_SESSION['stage']=$_SESSION['stage']+1;
			$result->execute();
		}else throw new ExceptionMySQL($dbh->error,$insert,"Ошибка при выполнении SQL запроса!");
		
		header("Location: ".$_SERVER["PHP_SELF"]."?id_test=".$_POST['id_test']);
		exit();
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="StyleSheet" type="text/css" href="style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<title><?php echo $title; ?></title>
</head>
<body id="results" class="center">
<?php 

	if($_GET['id_test'] == ''){
	
?>
<h1 style="text-align: center;">Тесты</h1>
<p style="text-al	ign: center;">Выберите тест из списка</p>
<?php

	$query = "SELECT * FROM ".DB_TEST."";
	$result = $dbh->query($query);

	if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!"); 

	echo '<ul id="my-ul">';
	
	while($row = $result->fetch_array())
	{
		echo '<li id="my-li"><a href="index.php?id_test='.$row['id_test'].'" title="пройти этот тест">'.$row['name'].'</a><br>'.$row['description'].'</li>';
	}
	
	echo '</ul>';
	echo '	<a id="but" style="margin-left: 45%;" href="exit.php">Выйти</a></span>';

?>
</body>
</html>
<?php

	}
	else{
	
		$query = "SELECT * FROM ".DB_TEST." WHERE id_test=".$_GET['id_test'];
		$result = $dbh->query($query);

		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");

		$row = $result->fetch_array();	
		$result->close();
	
		echo '<h1 style="text-align: center;">'.$row['name'].'</h1>';
		echo '<p class="answer" style="text-align: center;"">'.$row['description'].'</p>';
		
		if(!isset($_GET['start'])){		
			if($_SESSION['start'] != 'on') echo '<a id="but" style="margin-left: 43%;" href="'.$_SERVER['PHP_SELF'].'?id_test='.$_GET['id_test'].'&start">Пройти тест</a>';
		}
		else{
			$_SESSION['stage'] = 1;
			$_SESSION['start'] = 'on';
			
			$insert = "INSERT INTO ".DB_LOG." (id_log,time,id_user,id_test) VALUES (0,now(),".$_SESSION['id_user'].",".$_GET['id_test'].")";
			$result = $dbh->prepare($insert);
			$result->execute();
	
			$_SESSION['id_log'] = $result->insert_id;			
		}	
			
		if($_SESSION['start'] == 'on' and isset($_SESSION['stage'])){
			
			$begin = $_SESSION['stage'] - 1;
			
			$query = "SELECT COUNT(*) FROM ".DB_QUESTIONS." WHERE id_test=".$_GET['id_test'];
			$result = $dbh->query($query);

			if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");

			$row = $result->fetch_assoc();
			$total = $row['COUNT(*)'];
			$result->close();
			
			if($total >= $_SESSION['stage']){
			
				echo '<a>Вопрос '.$_SESSION['stage'].' из '.$total.'</a>';
			
				$query = "SELECT * FROM ".DB_QUESTIONS." WHERE id_test=".$_GET['id_test']." LIMIT ".$begin.", 1";
				$result = $dbh->query($query);
				//echo $query;
	
				if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");

				$row = $result->fetch_array();
				$id_question = $row['id_question'];
			
				$result->close();
		
				echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
				echo '<input type="hidden" name="id_test" value="'.$_GET['id_test'].'">';
				echo '<input type="hidden" name="id_question" value="'.$id_question.'">';
				echo '<input type="hidden" name="id_log" value="'.$_SESSION['id_log'].'">';
				echo '<input type="hidden" name="action" value="post">';
				
								
				if($row['name']) echo '<h4>'.$row['name'].' </h4>';
				
				if($row['answer1']) echo '<p class="answer"><input type="checkbox" class="filled-in" name="rightanswer1"><label for="test5">'.$row['answer1'].'</label></p>';
				if($row['answer2']) echo '<p class="answer"><input type="checkbox" class="filled-in" name="rightanswer2">'.$row['answer2'].' </p>';
				if($row['answer3']) echo '<p class="answer"><input type="checkbox" class="filled-in" name="rightanswer3">'.$row['answer3'].' </p>';
				if($row['answer4']) echo '<p class="answer"><input type="checkbox" class="filled-in" name="rightanswer4">'.$row['answer4'].' </p>';
				if($row['answer5']) echo '<p class="answer"><input type="checkbox" class="filled-in" name="rightanswer5">'.$row['answer5'].' </p>';	
			
				echo '<input id="but" type="submit" name="reply" value="ответить"> ';
				echo '</form>';
			}
			else{
				
				echo '<p class="answer">Правильных ответов: '.get_result_test ($_SESSION['id_log'],1).'</p>';
				echo '<p class="answer">Неправильных ответов: '.get_result_test ($_SESSION['id_log'],0).'</p>';	

				echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
				echo '<input type="hidden" name="action" value="post">';
				echo '<input id="but" style="margin-left: 45%;" type="submit" name="complete" value="выйти"> ';
				echo '</form>';
			}	
		}		
	}
	
	$dbh->close();
	
}
catch(ExceptionMySQL $exc)
{
	require_once("admin/lib/exception_mysql_debug.inc");
}

?>