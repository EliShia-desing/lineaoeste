<?php
require_once("conectar/conectar.php");
mysqli_select_db($base,$database);
if(isset($_GET["id"])&&($_GET["id"]!=""))
{
$id=$_GET["id"];

 $consulta="delete from edicion where id_edicion='$id'";
 $resultado=mysqli_query($base, $consulta) or die (mysqli_error());
header("Location: ediciones.php");
}
?>