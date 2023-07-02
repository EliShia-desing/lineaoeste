<?php require_once("conectar/conectar.php"); 
mysqli_select_db($base, $database);

  
//calculo de pagina
if(!isset($_GET["pactual"]))
{
$pgactual=0;//donde empieza 
}
else
{
$pgactual=$_GET["pactual"];
}
$cant_not_pag=10;//cantidad de noticias por paginas
$inicio=$pgactual * $cant_not_pag;

$cadena="";
if (isset($_POST["nombre"]))
{ 
$cadena="where upper( fecha ) LIKE upper( '%".$_POST["nombre"]."%' )";
unset($_POST["nombre"]);
} 
$consultaSql1="select * from edicion $cadena  order by id_edicion desc limit $inicio,$cant_not_pag ";//;

$resultado1 = mysqli_query($base, $consultaSql1) or die(mysqli_error());
$numero=mysqli_num_rows($resultado1);

$resultado_reg=mysqli_query($base, "select * from edicion $cadena") or die (mysqli_error());
$total_registro=mysqli_num_rows($resultado_reg);
$cantidad_paginas=intval($total_registro/$cant_not_pag);

$resultado_act=mysqli_query($base, "select * from edicion where activo=1") or die (mysqli_error());
$fila_act=mysqli_fetch_assoc($resultado_act);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><script type="text/javascript" src="stmenu.js"></script>
<script type="text/javascript">
function elimina(id)
{
  if (confirm("esta seguro de eliminar esta edicion?"))
     {
	    setTimeout('window.location="eliminar_edicion.php?id='+id+'"', 500);
		return true;
	 }
  else
  {
    return false;
  }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1 " />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo2 {
	font-size: 36px;
	font-weight: bold;
	font-style: italic;
}
.Estilo3 {font-size: 18px}
.Estilo2 .Estilo3 {
}
-->
</style>
</head>

<body>
<?php include("arriba.php");?>
<div align="center">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr>
    <td colspan="2" align="left"><span class="Estilo2">Edicion</span></td>
  </tr>
  <tr>
    <td height="48" colspan="2" align="left" class="Estilo2"><span class="Estilo3">La Edicion Activa es la <?php echo $fila_act["edicion"];?>: <?php echo $fila_act["fecha"];?></span></td>
  </tr>
  <tr>
    <td height="39" colspan="2" align="left"><a href="nuevo_edicion.php"><img src="imagenes/nuevo_edicion.png"  border="0" /></a></td>
  </tr>
  <tr>
    <td width="447" height="47"  align="left"><span class="Estilo3">Cantidad de Ediciones:</span> <?php echo $total_registro;?></td>
    <td width="353" align="right"><form id="form1" name="form1" method="post" action="">
      <span class="Estilo3">Edici&oacute;n n&ordm;</span>
      <input type="text" name="nombre" />
        <input type="image" height="28" name="imageField" src="imagenes/buscar_edicion.png" />
    </form>    </td>
  </tr>
  <tr>
    <td colspan="2"><script type="text/javascript">
<!--
stm_bm(["menu674b",820,"","blank.gif",0,"","",0,0,0,50,500,1,0,0,"","",0,0,1,1,"default","hand",""],this);
stm_bp("p0",[0,4,0,0,8,4,0,0,100,"",-2,"",-2,85,0,0,"#7F7F7F","transparent","",2,0,0,"#959ACC"]);
<?php
for ($i=0;$i<=$cantidad_paginas;$i++)
{
?>

stm_ai("p0i<?php echo $i;?>0",[0,"<?php echo $i+1;?> ","","",-1,-1,0,"ediciones.php?pactual=<?php echo $i; ?>","_self","","","","",0,0,0,"","",0,0,0,0,1,"#DBDDD2",0,"#FFFFFF",0,"","",3,3,2,3,"#000000 #000000 #AAD63E","#000000 #000000 #AAD63E","#333333","#000000","bold 8pt Verdana","bold 8pt Verdana",0,0]);
<?php
}
?>
stm_ep();
stm_em();
//-->
</script></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
		<table width="962" border="0" align="center" cellpadding="0" cellspacing="3" >
          <tr>
            <th width="50" bgcolor="#FFFFFF" scope="col">ID</th>
            <th width="331" bgcolor="#FFFFFF" scope="col">Edici&oacute;n</th>
            <th width="283" bgcolor="#FFFFFF" scope="col">Fecha</th>
            <th width="160" bgcolor="#FFFFFF" scope="col">Activo</th>
            <th colspan="2" bgcolor="#FFFFFF" scope="col">Acciones</th>
          </tr>
          <?php
		  while($regi=mysqli_fetch_array($resultado1))
		  {
		  ?>
		  <tr>
            <td height="31" bgcolor="#B4B4B4"><?php echo $regi["id_edicion"];?> </td>
            <td bgcolor="#B4B4B4"><?php echo $regi["edicion"];?> </td>
            <td bgcolor="#B4B4B4"><?php echo $regi["fecha"];?></td>
            <td bgcolor="#B4B4B4"><?php echo $regi["activo"];?></td>
            <td width="58" bgcolor="#B4B4B4" align="center">
				<a href="activar_edicion.php?id=<?php echo $regi["id_edicion"];?>" >
					<img src="img/habilta.jpg" alt="Modificar" border="0" />				</a>			</td>

            <td width="59" bgcolor="#B4B4B4" align="center">
				<a href="#" onclick="return(elimina(<?php echo $regi["id_edicion"];?>))">
					<img src="img/borrar.gif" alt="Borrar" border="0" />				</a>			</td>
          </tr>
		  <?php }?>
        </table>	
	</td>
  </tr>
</table>
</div>
</body>
</html>
