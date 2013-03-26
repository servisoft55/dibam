<?php require_once('Connections/anacional.php'); 
 session_start();
//session_start();
if (!isset($_SESSION["competencia"])) {
    $_SESSION["competencia"]=0;   
}
if (!isset($_SESSION["juzgado"])) {
    $_SESSION["juzgado"]=0;   
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//if ($_SESSION['juzgado']<>0) { // Verifica primera selección o conserva el JUZGADO
//	$elegido=$_SESSION['juzgado'];
//}else{
	$elegido=$_POST['elegido'];
//}
mysql_select_db($database_anacional, $anacional);
$query_Recordset2 = "SELECT * FROM tipo WHERE id_juzgado='$elegido'";
$Recordset2 = mysql_query($query_Recordset2, $anacional) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
//$competencia=9999990; //$_SESSION['competencia'];
echo $elegido."<br/>";
echo $_SESSION['competencia']."<br/>";
echo $totalRows_Recordset2."<br/>";
do { 
      ?>
      <option value="<?php echo $row_Recordset2['id_tipo']?>"<?php if (!(strcmp($competencia, $row_Recordset2['id_tipo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['nombre']?></option>
      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
  mysql_free_result($Recordset2);
?>
