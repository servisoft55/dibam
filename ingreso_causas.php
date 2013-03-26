<?php require_once('Connections/anacional.php'); 

 session_start();
//session_start();
if (!isset($_SESSION["nombre"])) {
    header("Location: index.htm");   
}
$_SESSION['juzgado']=0;
$_SESSION['competencia']=0; 
date_default_timezone_set("Chile/Continental");

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$_SESSION['juzgado']=$_POST['juzgado'];
	$_SESSION['competencia']=$_POST['competencia'];
	$fecha=date("Y-m-d H:i:s");
  $fecha_inicio=strftime("%Y-%m-%d", strtotime($_POST['fecha_inicio']));
  $fecha_termino=strftime("%Y-%m-%d", strtotime($_POST['fecha_termino']));
  $insertSQL = sprintf("INSERT INTO causas (juzgado, tipo, ciudad, caja, legajo, rol, fecha_inicio, fecha_termino, nombre_demandado, apellido_demandado, nombre_demandante, apellido_demandante, tipo_de_juicio, notas, funcionario, fecha) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['juzgado'], "int"),
                       GetSQLValueString($_POST['competencia'], "int"),
                       GetSQLValueString($_POST['ciudad'], "text"),
                       GetSQLValueString($_POST['caja'], "int"),
                       GetSQLValueString($_POST['legajo'], "int"),
                       GetSQLValueString($_POST['rol'], "text"),
                       GetSQLValueString($fecha_inicio, "date"),
                       GetSQLValueString($fecha_termino, "date"),
                       GetSQLValueString($_POST['nombre_demandado'], "text"),
                       GetSQLValueString($_POST['apellido_demandado'], "text"),
                       GetSQLValueString($_POST['nombre_demandante'], "text"),
                       GetSQLValueString($_POST['apellido_demandante'], "text"),
                       GetSQLValueString($_POST['tipo_de_juicio'], "text"),
                       GetSQLValueString($_POST['notas'], "text"),
                       GetSQLValueString($_SESSION['usuario'], "text"),
                       GetSQLValueString($fecha, "date"));

  mysql_select_db($database_anacional, $anacional);
  $Result1 = mysql_query($insertSQL, $anacional) or die(mysql_error());
}
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantilla.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema Archivo Nacional --> Ingreso Causas</title>
<!-- InstanceEndEditable -->
  <link rel="stylesheet" type="text/css" href="css/vader/jquery-ui.css" />
  <link rel="stylesheet" type="text/css" href="css/estilos.css" />
  <link rel="stylesheet" type="text/css" href="css/reveal.css">
  <link rel="stylesheet" type="text/css" href="/resources/demos/style.css">

  <script src="js/jquery-1.8.3.js" type="text/javascript"></script>
  <script src="js/jquery-ui-1.9.2.custom.js" type="text/javascript"></script>
  <script src="js/modernizr.custom.89711.js" type="text/javascript"></script>
  <script src="js/jquery.reveal.js" type="text/javascript"></script>

<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<!-- InstanceParam name="id" type="text" value="header" -->
</head>

<body>
<div id="header">
	<div id="logo">Sistema Archivo Nacional</div>
    <div id="usuario">Usuario: <?php echo $_SESSION["nombre"];?></div>
    <div id="cerrar"><a href="cerrar.php">Cerrar Sesión</a></div>
</div>
<!-- InstanceBeginEditable name="body" -->
<div id="body1" >
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table >
      <tr valign="baseline"><h3>Ingreso de Nueva Causa</h3>
        <td nowrap="nowrap" align="right">Juzgado:
          <select name="juzgado" id="juzgado" >
          <option value="0" >Elegir</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['id_jzgd']?>"<?php if (!(strcmp($_SESSION['juzgado'], $row_Recordset1['id_jzgd']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['nombre']?></option>
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
          <option value="<?php echo $row_Recordset2['id_tipo']?>"<?php if (!(strcmp($_SESSION['competencia'], $row_Recordset2['id_tipo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['nombre']?></option>
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
        <td><input type="text" id="ciudad" name="ciudad" value="Chillán" size="20" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Caja N°:</td>
        <td><input type="text" id="caja" name="caja" value="" size="10" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Legajo N°:</td>
        <td><input type="text" id="legajo" name="legajo" value="" size="10" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Causa Rol N°:</td>
        <td><input type="text" id="rol" name="rol" value="" id="rol" size="20" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Fecha de Inicio:</td>
        <td><input type="text" class="datepicker" id="fecha_inicio" name="fecha_inicio" value="" size="10" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Fecha de Término:</td>
        <td><input type="text" class="datepicker" id="fecha_termino" name="fecha_termino" value="" size="10" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Nombre del demandado:</td>
        <td><input type="text" name="nombre_demandado" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Apellido del demandado:</td>
        <td><input type="text" name="apellido_demandado" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Nombre del demandante:</td>
        <td><input type="text" name="nombre_demandante" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Apellido del demandante:</td>
        <td><input type="text" name="apellido_demandante" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Tipo de juicio:</td>
        <td><input type="text" name="tipo_de_juicio" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">Notas:</td>
        <td><input type="text" name="notas" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="left">&nbsp;</td>
        <td><input class='boton' id="submit" type="submit" value="Grabar" /><input id="volver" type="button" value="Volver" onclick="window.open('proceso.php')"/></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  <p>&nbsp;</p>
</div>
<div id="mostrar_dato" ></div>

<!-- InstanceEndEditable -->
<div id="fooder">RSP Computación 2012 - 2013 &copy; Todos los derechos Reservados </div>
</body>
<!-- InstanceEnd -->
<script language="javascript">

  $(document).ready(function(){
               $( "#rol" ).focus();

              $('form').keypress(function(e) {
                if(e.which == 13) return false;
              });  //desactivar tecla ENTER

              $.post("mostrar_dato.php", function(data){
                $("#mostrar_dato").fadeIn('slow').html(data);       //mostrar
             });

	  //Función select conectados
     $("#juzgado").change(function () {
              $("#competencia").val('0');
     })
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

  $(function() {
    $('#ciudad').blur(function() {
        if( $("#ciudad").val() != "" ) {
          $(".error").fadeOut('slow',function() {
            $(".error").remove(); 
          });  
        }      
      if( $("#ciudad").val() == "" ) {
          $("#ciudad").focus().after("<span class='error'>El campo es requerido</span>");
          $(".error").fadeIn('slow');        
      }
    }); 
    $('#caja').blur(function() {
        if( $("#caja").val() != "" ) {
          $(".error").fadeOut('slow',function() {
            $(".error").remove(); 
          });  
        }      
      if( $("#caja").val() == "" ) {
          $("#caja").focus().after("<span class='error'>El campo es requerido</span>");
          $(".error").fadeIn('slow');        
      }
    }); 
    $('#legajo').blur(function() {
        if( $("#legajo").val() != "" ) {
          $(".error").fadeOut('slow',function() {
            $(".error").remove(); 
          });  
        }      
      if( $("#legajo").val() == "" ) {
          $("#legajo").focus().after("<span class='error'>El campo es requerido</span>");
          $(".error").fadeIn('slow');        
      }
    }); 
    $('#rol').blur(function() {
        if( $("#rol").val() != "" ) {
          $(".error").fadeOut('slow',function() {
            $(".error").remove(); 
          });  
        }      
      if( $("#rol").val() == "" ) {
          $("#rol").focus().after("<span class='error'>El campo es requerido</span>");
          $(".error").fadeIn('slow');        
      }
    }); 





        //valida solo entrada de dato numerico
    $("#caja,#legajo").keydown(function(event){
        if((event.keyCode < 48 || event.keyCode > 57) && event.keyCode != 08 && event.keyCode != 09){
            return false;
        }
    });


    //valida fechas
    $('#fecha_inicio').blur(function() {
        if( validarFecha($("#fecha_inicio").val())==true) {
          $(".error").fadeOut('slow',function() {
            $(".error").remove(); 
          });  
        }      
      if(validarFecha($("#fecha_inicio").val())==false) {
          $("#fecha_inicio").focus().after("<span class='error'>Es una fecha inválida</span>");
          $(".error").fadeIn('slow');        
      }
    }); 
    $('#fecha_termino').blur(function() {
        if( validarFecha($("#fecha_termino").val())==true) {
          $(".error").fadeOut('slow',function() {
            $(".error").remove(); 
          });  
        }      
      if(validarFecha($("#fecha_termino").val())==false) {
          $("#fecha_termino").focus().after("<span class='error'>Es una fecha inválida</span>");
          $(".error").fadeIn('slow');        
      }
    }); 

    var validarFecha = function(fecha){
     //Funcion validarFecha 
     //Escrita por Buzu feb 18 2010. (FELIZ CUMPLE BUZU!!!
     //valida fecha en formato aaaa-mm-dd
     var fechaArr = fecha.split('-');
     var aho = fechaArr[2];
     var mes = fechaArr[1];
     var dia = fechaArr[0];
     
     var plantilla = new Date(aho, mes - 1, dia);//mes empieza de cero Enero = 0

     if(!plantilla || plantilla.getFullYear() == aho && plantilla.getMonth() == mes -1 && plantilla.getDate() == dia){
     return true;
     }else{
     return false;
     }
    }    




  });   // fin función validad formulario     




});

</script>

</html>
<?php
mysql_free_result($Recordset1);
?>
