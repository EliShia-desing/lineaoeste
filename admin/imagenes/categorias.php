<?php require_once("conectar/conectar.php"); 
mysql_select_db($database, $base);

  
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
$cadena="where upper( categoria_cat  ) LIKE upper( '%".$_POST["nombre"]."%' )";
unset($_POST["nombre"]);
}
$consultaSql1="select * from categoria $cadena  order by categoria_cat desc limit $inicio,$cant_not_pag ";//;
$resultado1 = mysql_query($consultaSql1,$base) or die(mysql_error());
$numero=mysql_num_rows($resultado1);

$resultado_reg=mysql_query("select * from categoria $cadena",$base) or die (mysql_error());
$total_registro=mysql_num_rows($resultado_reg);
$cantidad_paginas=intval($total_registro/$cant_not_pag);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><script type="text/javascript" src="stmenu.js"></script>
<script type="text/javascript">
function elimina(id)
{
  if (confirm("esta seguro de eliminar este categoria?"))
     {
	    setTimeout('window.location="eliminar_categoria.php?id='+id+'"', 500);
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
-->
</style>
</head>

<body>
<?php include("arriba.php");?>
<div align="center">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr>
    <td colspan="2" align="left"><span class="Estilo2">Categor&iacute;as</span></td>
  </tr>
  <tr>
    <td height="39" colspan="2" align="left"><a href="nuevo_categoria.php"><img src="imagenes/nuevo_categoria.png"  border="0" /></a></td>
  </tr>
  <tr>
    <td width="447" height="47"  align="left"><span class="Estilo3">Cantidad de Categor&iacute;as:</span> <?php echo $total_registro;?></td>
    <td width="353" align="right"><form id="form1" name="form1" method="post" action="">
      <input type="text" name="nombre" />
        <input type="image" height="28" name="imageField" src="imagenes/buscar_categoria.png" />
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

stm_ai("p0i<?php echo $i;?>0",[0,"<?php echo $i+1;?> ","","",-1,-1,0,"categorias.php?pactual=<?php echo $i; ?>","_self","","","","",0,0,0,"","",0,0,0,0,1,"#DBDDD2",0,"#FFFFFF",0,"","",3,3,2,3,"#000000 #000000 #AAD63E","#000000 #000000 #AAD63E","#333333","#000000","bold 8pt Verdana","bold 8pt Verdana",0,0]);
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
		<table width="953" border="0" align="center" cellpadding="0" cellspacing="3" >
          <tr>
            <th width="46" bgcolor="#FFFFFF" scope="col">ID</th>
            <th width="292" bgcolor="#FFFFFF" scope="col">Nombre Categor&iacute;a</th>
            <th width="381" bgcolor="#FFFFFF" scope="col">Descripcion</th>
            <th width="108" bgcolor="#FFFFFF" scope="col">Orden</th>
            <th colspan="2" bgcolor="#FFFFFF" scope="col">Acciones</th>
          </tr>
          <?php
		  while($regi=mysql_fetch_array($resultado1))
		  {
		  ?>
		  <tr>
            <td height="31" bgcolor="#B4B4B4"><?php echo $regi["id_cat"];?> </td>
            <td bgcolor="#B4B4B4"><?php echo $regi["categoria_cat"];?> </td>
            <td bgcolor="#B4B4B4"><?php echo substr($regi["detalle_cat"],0,100);?> </td>
            <td bgcolor="#B4B4B4"><?php echo $regi["orden"];?></td>
            <td width="50" bgcolor="#B4B4B4" align="center">
				<a href="modificar_categoria.php?id=<?php echo $regi["id_cat"];?>" >
					<img src="img/modificar.gif" alt="Modificar" border="0" />				</a>			</td>
			
            <td width="55" bgcolor="#B4B4B4" align="center">
				<a href="#" onclick="return(elimina(<?php echo $regi["id_cat"];?>))">
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
