<?php
$url_root = "http://www.lineaoeste.com.ar/";
$hostname_web = "localhost";
$database = "oeste_diario";
$username_web = "oeste_oeste";
//$password_web = "Sistema123";
$password_web = "Ser123vicio";
$base = mysql_connect($hostname_web, $username_web, $password_web) or trigger_error(mysql_error(),E_USER_ERROR); 
?>