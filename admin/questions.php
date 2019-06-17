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
	
	if(!preg_match("|^[\d]*$|",$_GET['id_question'])) exit();
	
	if($_POST['action']){
		$_POST['id_question'] = $dbh->real_escape_string($_POST['id_question']);
		$delete = "DELETE FROM ".DB_ANSWERS." WHERE id_question=".$_POST['id_question'];
		
		if(!$dbh->query($delete)) throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");
		
		if(count($_POST['name']) > 0)
		{
			for($i=0; $i<count($_POST['name']); $i++)
			{
				$name = trim($_POST['name'][$i]);
				$name = $dbh->real_escape_string($name);
				if($_POST['correct'][$i] == 'on') $correct = 1;
				else $correct = 2;
				
				if($name != '') {
					$result=$dbh->prepare("INSERT INTO ".DB_ANSWERS." (id_answer,name,correct,id_question) VALUE (0,'".$name."',".$correct.",".$_POST['id_question'].")");
					$result->execute();
				}
				
			}			
		}	
		
		header("Location: ".$_SERVER["HTTP_REFERER"]."");
		exit();
	}
	else{
	
		$title = "Ответы к вопросу: ";
	
		include "top.php";
?>
<script type=text/javascript>

function dropInputform(btn)
{
	if(document.getElementById)
	{
		while(btn.tagName != 'TR') btn = btn.parentNode;
		btn.parentNode.removeChild(btn);
	}
}

function addInputform(btn)
{
	if(document.getElementById)
	{
		while(btn.tagName != 'TR') btn = btn.parentNode;
		var newTr = btn.parentNode.insertBefore(btn.cloneNode(true), btn.nextSibling);
	}
}

</script>
<?php	
	
		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
		echo '<table borde="0"><tr><td width="350">Ответ</td><td width="100">Верный</td><tr></table>';
		echo '<table border="0">';

		$query = "SELECT * FROM ".DB_ANSWERS." WHERE id_question=".$_GET['id_question'];
		$result = $dbh->query($query);

		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

		if($result->num_rows == 0){
			echo '<tr><td width="350"><input class="input" type="text" size="50" value="" name="name[]"></td>'; 
			echo '<td width="100"><input type="checkbox" size="40" name="correct[]"></td>';
			echo '</tr>';
			
			echo '<tr><td width="350"><input class="input" type="text" size="50" value="" name="name[]"></td>'; 
			echo '<td width="100"><input type="checkbox" size="40" name="correct[]"></td>';
			echo '</tr>';
			
			echo '<tr><td width="350"><input class="input" type="text" size="50" value="" name="name[]"></td>'; 
			echo '<td width="100"><input type="checkbox" size="40" name="correct[]"></td>';
			echo '</tr>';
			
			echo '<tr><td width="350"><input class="input" type="text" size="50" value="" name="name[]"></td>'; 
			echo '<td width="100"><input type="checkbox" size="40" name="correct[]"></td>';
			echo '</tr>';
		}
		else{
			while($row = $result->fetch_array())
			{
				echo '<tr><td width="350"><input class="input" type="text" size="50" value="'.$row['name'].'" name="name[]"></td>'; 
				echo '<td width="100"><input type="checkbox" size="40" '.($row['correct'] == 1?'checked="checked"':'').' name="correct[]"></td>';
				echo '</tr>';
			}
		}	

		$result->close();

		echo '</tr></table>';
		echo '<input type="hidden" name="id_question" value="'.$_GET['id_question'].'">';
		echo '<input type="hidden" name="action" value="post">';
		echo '<input type="submit" value="добавить">';
		echo '</form>';
	
		include "bottom.php";
	}
	
	$dbh->close();
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}

?>