<?php


require "lib/config.php";

$title = 'Учётные записи';

ob_start();

require "class/class.exception_mysql.php";

try
{
	require_once "lib/function.inc";
	require_once "lib/connect.inc";
	require_once "lib/authenticate.inc";
	
	if($_SESSION['login'] != 'admin') error('Извините, вы не имеете достаточно прав для администратора!');	
	
	include "header.php";
	
?>
<table class="table-hover table table-bordered" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
      <tr>
        <th>Логин</th>
        <th>Имя</th>

		<th>Действие</th>
      </tr>
    </thead>
	<tbody>
<?php

	$query = "SELECT * FROM ".DB_USERS."";
	$result = $dbh->query($query);

	if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Ошибка при выполнении SQL запроса!");

	while($row = $result->fetch_array()){

?>
<tr class="td-middle">
<td><?php echo $row['login']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><a class="btn" href="edit.php?id_user=<?php echo $row['id_user']; ?>"><i class="icon-pencil"></i> Редактировать</a> <?php if($_SESSION['login'] != $row['login']){ ?><a class="btn" href="delete.php?login=<?php echo $row['login']; ?>"><i class="icon-trash"></i> Удалить</a><?php } ?></td>
</tr>
<?php

	}
	
?>
</tbody>
</table>
<?php

	include "footer.php";	
	
	$dbh->close();
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}

?>
