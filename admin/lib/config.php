<?php

Error_Reporting(E_ALL & ~E_NOTICE);

define("DEBUG", 1);

#$db_location = "www2"; // сервер базы данных
#$db_name = "mihaleva_s_a";           // имя базы данных  
#$db_user = "mihaleva_s_a";          // логин
#$db_passwd = "NewPass16";            // пароль
#db_charset = "utf8";
$db_location = "www2"; // сервер базы данных
$db_name = "korsakov_g_s";           // имя базы данных  
$db_user = "korsakov_g_s";          // логин
$db_passwd = "NewPass19";            // пароль
$db_charset = "utf8";

$version = '1.0.0 beta';

define("DB_USERS","ot_users");
define("DB_ANSWERS","ot_answers");
define("DB_QUESTIONS","ot_questions");
define("DB_TEST","ot_test");
define("DB_LOG","ot_log");
define("DB_RESULT","ot_result");

?>
