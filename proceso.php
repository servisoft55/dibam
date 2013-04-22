<?php require_once('Connections/anacional.php'); 

 session_start();
//session_start();
if (!isset($_SESSION["nombre"])) {
    header("Location: index.htm");   
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

mysql_select_db($database_anacional, $anacional);
$query_Recordset1 = "SELECT * FROM juzgados ORDER BY orden ASC";
$Recordset1 = mysql_query($query_Recordset1, $anacional) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema Archivo Nacional</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
<script src="js/jquery.v1.6.4.js"></script>
<script language="javascript">
  $(document).ready(function(){
     $('#boton1').click(function() {
    // Recargo la página
	alert("hola");
	     document.location.href='ingreso_causas.php';
     });

     $("#juzgado").change(function () {
        $("#juzgado option:selected").each(function () {
           elegido=$(this).val();
           $.post("tipo.php", { elegido: elegido }, function(data){
              $("#competencia").html(data);
/*              $("#cmbciudades").html("");
*/           });
        });
     })

/*     // Este puede ponerse en comentario si no se dispone de un 3er combo:
     $("#cmbestados").change(function () {
        $("#cmbestados option:selected").each(function () {
           elegido=$(this).val();
           $.post("ciudades.php", { elegido: elegido }, function(data){
               $("#cmbciudades").html(data);
           });
        });
     })
*/
  });
</script>
</head>

<body>
<div id="header">
	<div id="logo">Sistema Archivo Nacional</div>
    <div id="usuario">Usuario: <?php echo $_SESSION["nombre"];?></div>
    <div id="cerrar"><a href="cerrar.php">Cerrar Sesión</a></div>
</div>
<table width="200" border="1">
  <tr>
    <th colspan="4" ><input type="button" name="button" id="boton1" value="Ingresar Causa" /></th>
  </tr>
  <tr>
    <td colspan="4" scope="col"><h3>Sistema Archivo Nacional:  <...Busqueda...></h3>
    </td>
  </tr>
  <tr>
    <td>Rol</td>
    <td><input type="text" name="rol" id="rol" /></td>
    <td>Juzgado</td>
    <td><label for="juzgado"></label>
    <select name="juzgado" id="juzgado">
    	<option value="0">Elegir</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset1['id_jzgd']?>"><?php echo $row_Recordset1['nombre']?></option>
      <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td>Carátula</td>
    <td><label for="caratula"></label>
    <input type="text" name="caratula" id="caratula" /></td>
    <td>Competencia</td>
    <td><label for="competencia"></label>
      <select name="competencia" id="competencia"></select></td>
  </tr>
  <tr>
    <td>Demandante</td>
    <td><label for="demandante"></label>
    <input type="text" name="demandante" id="demandante" /></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Demandado</td>
    <td><label for="demandado"></label>
    <input type="text" name="demandado" id="demandado" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><form id="form2" name="form2" method="post" action="">
      <input type="submit" name="button3" id="button3" value="Buscar" />
    </form></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
