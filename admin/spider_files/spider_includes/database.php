<?php

$server_add="localhost";
$username="root";
$password="";
$database_name="urdu_search_engine_db";
/*
$server_add="eydiouscom.ipagemysql.com";
$username="use";
$password="Talha123!@#";
$database_name="use";
*/
//$database_name="urdu_search_engine_temp";

//////connecting to mysql database///////
mysql_connect($server_add,$username,$password);
mysql_select_db($database_name) or die("Database Selection FAILED");

mysql_set_charset('utf8');
//the above line is for support for urdu in mysql


?>