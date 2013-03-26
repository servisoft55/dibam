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

$colname_Recordset1 = "-1";
if (isset($_SESSION['usuario'])) {
  $colname_Recordset1 = $_SESSION['usuario'];
}
mysql_select_db($database_anacional, $anacional);
//$query_Recordset1 = sprintf("SELECT * FROM causas WHERE funcionario = %s ORDER BY id_movimiento DESC", GetSQLValueString($colname_Recordset1, "text"));
$query_Recordset1 = sprintf("SELECT causas.*, juzgados.nombre AS glosa_juzgado,  tipo.nombre AS glosa_tipo
              FROM causas 
              INNER JOIN juzgados ON causas.juzgado=juzgados.id_jzgd
              INNER JOIN tipo ON causas.tipo=tipo.id_tipo
              WHERE funcionario = %s ORDER BY id_causas DESC", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $anacional) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<style type="text/css">
#titulo_tabla {
	text-align: center;
	font-weight: bold;
	font-size: 18px;
}
</style>

  <table border="1">
    <tr>
      <td colspan="11" id="titulo_tabla">MIS CAUSAS INGRESADAS<div id="loader_gif"></div><div id="mensaje_del"></div></td>
    </tr>
    <tr>
      <td>Id</td>
      <td>Juzgado</td>
      <td>Competencia</td>
      <td>Caja</td>
      <td>Legajo</td>
      <td>Causa Rol</td>
      <td>Nombre demandado</td>
      <td>Apellido demandado</td>
      <td>Editar</td>
      <td>Borrar</td>
    </tr>
    <?php do { 
        $id2=$row_Recordset1['id_causas'];

      print "  <tr id='id_linea$id2' data='$id2'>\n ";
    ?>
        <td><?php echo $id2; ?></td>
        <td><?php echo $row_Recordset1['glosa_juzgado']; ?></td>
        <td><?php echo $row_Recordset1['glosa_tipo']; ?></td>
        <td><?php echo $row_Recordset1['caja']; ?></td>
        <td><?php echo $row_Recordset1['legajo']; ?></td>
        <td><?php echo $row_Recordset1['rol']; ?></td>
        <td><?php echo $row_Recordset1['nombre_demandado']; ?></td>
        <td><?php echo $row_Recordset1['apellido_demandado']; ?></td>
        <td><div class='editar' id='edit-<?php echo $id2; ?>' data='<?php echo $id2; ?>'>
            <a href='#' data-reveal-id='myModal' class='link_editar'><img src='img/onebit_20.png' width=16 height=16></a>
            </div>
        </td>
        <td><div class='eliminar' id='elim-<?php echo $id2; ?>' data='<?php echo $id2; ?>'>
            <a href='#' class='link_eliminar'><img src='img/onebit_33.png' width=16 height=16></a>
            </div>
        </td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </table>
<div id="myModal" class="reveal-modal">
     <h2>MODIFICAR DATOS DEL REGISTRO</h2>
     <a class="close-reveal-modal">&#215;</a>
</div>  
<?php
mysql_free_result($Recordset1);
?>

<script type="text/javascript">
$(document).ready(function() {
    // FUNCION JQUERY PARA ELIMINAR REGISTRO DE LA BASE DE DATOS
    $('.link_eliminar').click(function(){
          //Recogemos la id del contenedor padre
        var parent = $(this).parent().attr('id');
        //Recogemos el valor del servicio
        var id = $(this).parent().attr('data');
      
        var dataString = 'id='+id;

        $.ajax({
            type: "POST",
            url: "eliminar_registro.php",
            data: dataString,
            beforeSend: function(){
                $("#elim-"+id).html("<a class='link'><img src='img/loader.gif'> </a>");
            },
            success: function(respuesta) { 
//                $("#ajax_loader").html("<br><div class='subtitulo'>Resultado:</div> "+responseText);
//                $('#'+parent).html("<a class='link'><img src='img/PNG/onebit_34.png' width=16 height=16></a>");
 //               $('#'+parent).empty();
//                $('#'+parent).append('<div>Se ha eliminado correctamente el servicio con id='+service+'.</div>').fadeIn("slow");
//                $('#'+parent).remove();
                //elimina visualmente la fila de la tabla
               setTimeout(function(){
                  $('#id_linea'+id).remove(); //elimina la fila
                  $("#elim-"+id).fadeOut("slow"); //desaparece el div de la imagen
                  $('#mensaje_del').html(respuesta).fadeIn("slow"); //aparece mensaje de eliminación exitosa
                }, 3000);
                setTimeout(function(){
                  $("#mensaje_del").toggle(2000); // ocultar después de 2 segundos
                },6000);
 
            }
        });
    });  


    // FUNCION JQUERY PARA EDITAR REGISTRO DE LA BASE DE DATOS
    $('.link_editar').live('click',function(){
          //Recogemos la id del contenedor padre
        var parent = $(this).parent().attr('id');
        //Recogemos el valor del servicio
        var id = $(this).parent().attr('data');
      
        var dataString = 'id='+id;
            $('#myModal h2').append(' N° '+id);
        $.ajax({
            type: "POST",
            url: "modificar_registro.php",
            data: dataString,
            beforeSend: function(){
                $("#edit-"+id).html("<a class='link'><img src='img/loader.gif'></a>");
            },
            success: function(respuesta) { 
//                $("#ajax_loader").html("<br><div class='subtitulo'>Resultado:</div> "+responseText);
//                $('#'+parent).html("<a class='link'><img src='img/PNG/onebit_34.png' width=16 height=16></a>");
 //               $('#'+parent).empty();
//                $('#'+parent).append('<div>Se ha eliminado correctamente el servicio con id='+service+'.</div>').fadeIn("slow");
//                $('#'+parent).remove();
                //elimina visualmente la fila de la tabla
               setTimeout(function(){
                $('#edit-'+id).html("<a href='#' data-reveal-id='myModal' class='link_editar'><img src='img/onebit_20.png' width=16 height=16></a>");
                
            $('#myModal').append(respuesta);
                }, 3000);
                setTimeout(function(){
//                  $("#mensaje_del").toggle(2000); // ocultar después de 2 segundos
                },6000);
 
            }
        });
    });

    $('.close-reveal-modal').live('click',function(){  //FUNCION ELIMINA CONTENIDO PARA PODER EFECTUAR UN 2° CAMBIO
        $('#body2').remove();
        $('#myModal h2').text("MODIFICAR DATOS DEL REGISTRO");

    });

        //FUNCION VENTANA MODAL PARA MODIFICACION DE DATOS
        $('#myButton').click(function(e) {
              e.preventDefault();
              $('#myModal1').reveal();



              
        });
       

});    
</script>