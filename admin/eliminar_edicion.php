<?php
require_once("conectar/conectar.php");
mysql_select_db($database,$base);
if(isset($_GET["id"])&&($_GET["id"]!=""))
{
$id=$_GET["id"];

 $consulta="delete from edicion where id_edicion='$id'";
 $resultado=mysql_query($consulta,$base) or die (mysql_error());
header("Location: ediciones.php");
}
?>