<?php
require_once('Connections/anacional.php');

$id = $_POST['id'];

mysql_query("DELETE FROM causas WHERE id_causas='$id'", $anacional);
echo "<img src='img/onebit_38.png' width=16 height=16> La eliminación fue exitosa...";
?>
