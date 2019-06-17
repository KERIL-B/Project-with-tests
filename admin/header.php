<?php


$url_name = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="styles/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="styles/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="styles/styles.css" rel="stylesheet" media="screen">
<link href="styles/DT_bootstrap.css" rel="stylesheet" media="screen">
<title><?php echo $title; ?></title>
</head>
<body>

<div class="container-fluid">
<div class="row-fluid">
<div class="span3" id="sidebar">
	<span class="logo">РЕДАКТИРОВАНИЕ ТЕСТОВ</span>

	<span class="exit"><?php echo $_SESSION['login']; ?> <a id="but" href="exit.php">Выйти</a></span>
  <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
<li <?php if($url_name == 'index.php') echo 'class="active"'; ?>><a href="index.php" title="Список тестов"><i class="icon-list-alt<?php if($url_name == 'index.php') echo ' icon-white'; ?>"></i> Список тестов</a></li>
<li <?php if($url_name == 'users.php') echo 'class="active"'; ?>><a href="users.php" title="Учетные записи"><i class="icon-user<?php if($url_name == 'users.php') echo ' icon-white'; ?>"></i> Учетные записи</a></li>
<li <?php if($url_name == 'results.php') echo 'class="active"'; ?>><a href="results.php" title="Результаты тестирования"><i class="icon-info-sign<?php if($url_name == 'results.php') echo ' icon-white'; ?>"></i> Результаты тестирования</a></li>
</ul>
</div>
<div class="span9" id="content">

<div class="row-fluid">
<div class="block">
<div class="navbar navbar-inner block-header">
  <div class="muted pull-left"><strong><?php echo $title; ?></strong></div>
</div>
<div class="block-content collapse in">
<div class="span12">
