<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cbr = "localhost";
$database_cbr = "cbr";
$username_cbr = "root";
$password_cbr = "";
$cbr = mysql_pconnect($hostname_cbr, $username_cbr, $password_cbr) or trigger_error(mysql_error(),E_USER_ERROR); 
?>