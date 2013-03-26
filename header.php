<?php require_once('Connections/anacional.php'); 

 session_start();
//session_start();
if (!isset($_SESSION["nombre"])) {
    header("Location: index.htm");   
}
?>
<div id="header">
	<div id="logo">Sistema Archivo Nacional</div>
    <div id="usuario">Usuario: <?php echo $_SESSION["nombre"];?></div>
    <div id="cerrar"><a href="cerrar.php">Cerrar Sesión</a></div>
</div>
<table width="200" border="1">
  <tr>
    <th colspan="4" scope="col">Sistema Archivo Nacional</th>
  </tr>
  <tr>
    <td colspan="4"><input type="button" name="button" id="button" value="Ingresar Causa" />
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
    <td>Estado</td>
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
    <td colspan="3"><form id="form1" name="form1" method="post" action="">
      <input type="submit" name="button3" id="button3" value="Buscar" />
    </form></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
