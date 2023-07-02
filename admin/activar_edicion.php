<?php
require_once("conectar/conectar.php");
mysql_select_db($database,$base);
if(isset($_GET["id"])&&($_GET["id"]!=""))
{
$id=$_GET["id"];

 $consulta="update edicion set activo=0";
 $resultado=mysql_query($consulta,$base) or die (mysql_error());
  $consulta1="update edicion set activo=1 where id_edicion='$id'";

$resultado1=mysql_query($consulta1,$base) or die (mysql_error());
header("Location: ediciones.php");
}
?>