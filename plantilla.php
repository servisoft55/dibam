<?php require_once('Connections/anacional.php'); 

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
<title>Sistema Archivo Nacional</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
  <link rel="stylesheet" type="text/css" href="css/vader/jquery-ui.css" />
  <link rel="stylesheet" type="text/css" href="css/estilos.css" />
  <link rel="stylesheet" type="text/css" href="css/reveal.css">

  <script src="js/jquery-1.8.3.js" type="text/javascript"></script>
  <script src="js/jquery-ui-1.9.2.custom.js" type="text/javascript"></script>
  <script src="js/modernizr.custom.89711.js" type="text/javascript"></script>
  <script src="js/jquery.reveal.js" type="text/javascript"></script>
</head>

<body>
<div id="header">
	<div id="logo">Sistema Archivo Nacional</div>
    <div id="usuario">Usuario: <?php echo $_SESSION["nombre"];?></div>
    <div id="cerrar"><a href="cerrar.php">Cerrar Sesión</a></div>
</div>
<div id="fooder">RSP Computación 2012 - Todos los derechos Reservados &copy;</div>
</body>
</html>
