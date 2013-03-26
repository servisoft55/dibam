<?php require_once('../Connections/anacional.php'); 

 session_start();
//session_start();
if (!isset($_SESSION["nombre"])) {
    header("Location: index.htm");   
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Sistema Archivo Nacional</title>
<!-- TemplateEndEditable -->
<link rel="stylesheet" type="text/css" href="../css/estilos.css" />
<script src="../js/jquery.v1.6.4.js"></script>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<!-- TemplateParam name="id" type="text" value="header" -->
</head>

<body>
<div id="header">
	<div id="logo">Sistema Archivo Nacional</div>
    <div id="usuario">Usuario: <?php echo $_SESSION["nombre"];?></div>
    <div id="cerrar"><a href="../cerrar.php">Cerrar Sesión</a></div>
</div>
<!-- TemplateBeginEditable name="body" -->
<div id="body">

</div>
<!-- TemplateEndEditable -->
<div id="fooder">RSP Computación 2012 - Todos los derechos Reservados &copy;</div>
</body>
</html>
