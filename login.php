<?php require_once('Connections/cbr.php'); 
session_start();

if (isset($_POST['usuario'])) {
  $colname1= $_POST['usuario'];
}
if (isset($_POST['password'])) {
  $colname2= md5($_POST['password']);
}
mysql_select_db($database_cbr, $cbr);
$query_Recordset1 = sprintf("SELECT usuario, nombre, iniciales, password2, nivel FROM funcionarios WHERE usuario = '$colname1' AND password2 = '$colname2'");
$Recordset1 = mysql_query($query_Recordset1, $cbr) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$nombre = $row_Recordset1['nombre'];
$usuario = $row_Recordset1['usuario'];
	if($totalRows_Recordset1 == 1) {
		$_SESSION["nombre"] = $nombre;
		$_SESSION["usuario"] = $usuario;
		echo "valid";
	} else {
		echo "invalid";
	}

//mysql_free_result($Recordset1);
?>
