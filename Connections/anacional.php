<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_anacional = "localhost";
$database_anacional = "anacional";
$username_anacional = "root";
$password_anacional = "";
$anacional = mysql_pconnect($hostname_anacional, $username_anacional, $password_anacional) or trigger_error(mysql_error(),E_USER_ERROR); 
?>