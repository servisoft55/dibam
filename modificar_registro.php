<?php
require_once('Connections/anacional.php'); 
$id=$_POST['id'];
//TRAE LOS JUZGADOS PARA EL SELECT
mysql_select_db($database_anacional, $anacional);
$query_Recordset1 = "SELECT * FROM juzgados ORDER BY orden ASC";
$Recordset1 = mysql_query($query_Recordset1, $anacional) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//TRAE LAS COMPETENCIAS PARA EL SELECT
$query_Recordset2 = "SELECT * FROM tipo ORDER BY id_tipo ASC";
$Recordset2 = mysql_query($query_Recordset2, $anacional) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//TRAE LOS CAMPOS DEL REGISTRO SELECCIONADO CON EL ID
$query_Recordset3 = "SELECT * FROM causas WHERE id_causas='$id'";
$Recordset3 = mysql_query($query_Recordset3, $anacional) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
//$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$juzgado=$row_Recordset3['juzgado'];
$tipo=$row_Recordset3['tipo'];
$ciudad=$row_Recordset3['ciudad'];
$caja=$row_Recordset3['caja'];
$legajo=$row_Recordset3['legajo'];
$rol=$row_Recordset3['rol'];
$fecha_inicio=strftime("%d-%m-%Y", strtotime($row_Recordset3['fecha_inicio']));
$fecha_termino=strftime("%d-%m-%Y", strtotime($row_Recordset3['fecha_termino']));
$nombre_demandado=$row_Recordset3['nombre_demandado'];
$apellido_demandado=$row_Recordset3['apellido_demandado'];
$nombre_demandante=$row_Recordset3['nombre_demandante'];
$apellido_demandante=$row_Recordset3['apellido_demandante'];
$tipo_de_juicio=$row_Recordset3['tipo_de_juicio'];
$notas=$row_Recordset3['notas'];


?>
<div id="body2" >
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table >
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Juzgado:
          <select name="juzgado" id="juzgado" >
          <option value="0" >Elegir</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['id_jzgd']?>"<?php if (!(strcmp($juzgado, $row_Recordset1['id_jzgd']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['nombre']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select></td>
      
        <td nowrap="nowrap" align="left">Competencia:
          <select name="competencia" id="competencia">
          <option value="0" >Elegir</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['id_tipo']?>"<?php if (!(strcmp($tipo, $row_Recordset2['id_tipo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['nombre']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
    $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>

        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Ciudad:</td>
        <td><input type="text" name="ciudad" value="<?php echo $ciudad;?>" size="20" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Caja N°:</td>
        <td><input type="text" name="caja" value="<?php echo $caja;?>" size="10" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Legajo N°:</td>
        <td><input type="text" name="legajo" value="<?php echo $legajo;?>" size="10" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Causa Rol N°:</td>
        <td><input type="text" name="rol" value="<?php echo $rol;?>" id="rol" size="20" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Fecha de Inicio:</td>
        <td><input type="text" class="datepicker" name="fecha_inicio" value="<?php echo $fecha_inicio;?>" size="10" readonly/></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Fecha de Término:</td>
        <td><input type="text" class="datepicker" name="fecha_termino" value="<?php echo $fecha_termino;?>" size="10" readonly/></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Nombre del demandado:</td>
        <td><input type="text" name="nombre_demandado" value="<?php echo $nombre_demandado;?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Apellido del demandado:</td>
        <td><input type="text" name="apellido_demandado" value="<?php echo $apellido_demandado;?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Nombre del demandante:</td>
        <td><input type="text" name="nombre_demandante" value="<?php echo $nombre_demandante;?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Apellido del demandante:</td>
        <td><input type="text" name="apellido_demandante" value="<?php echo $apellido_demandante;?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Tipo de juicio:</td>
        <td><input type="text" name="tipo_de_juicio" value="<?php echo $tipo_de_juicio;?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Notas:</td>
        <td><input type="text" name="notas" value="<?php echo $notas;?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">&nbsp;</td>
        <td><input id="submit" type="submit" value="Grabar" /><input id="volver" type="button" value="Volver" onclick="window.open('proceso.php')"/></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  <p>&nbsp;</p>
</div>

<script language="javascript">

  $(document).ready(function(){
    //Funcion calendario
      $(function() {
          $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '&#x3c;Ant',
            nextText: 'Sig&#x3e;',
            currentText: 'Hoy',
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
            'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
            'Jul','Ago','Sep','Oct','Nov','Dic'],
            dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
            dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
            weekHeader: 'Sm',
            dateFormat: 'dd-mm-yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
          $.datepicker.setDefaults($.datepicker.regional['es']);
          $(".datepicker").datepicker({
             appendText: '(dd-mm-aaaa)',
             showOn: 'both',
             yearRange: "1900:getFullYear(date())",
             changeMonth: true,
             changeYear: true,
             buttonImageOnly: true,
             gotoCurrent: true,
             buttonImage: 'img/calendar_icon.jpg',
          });
      });



  });

</script>

