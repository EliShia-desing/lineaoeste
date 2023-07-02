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
$tipo=1;
if (isset($_GET["tipo"]))
{
  $tipo=$_GET["tipo"];	 
}
if($tipo==1)  //busca por edicion
{
$activa= mysqli_query($base, "select id_edicion as id, edicion as nombre, fecha as detalle  from edicion order by edicion desc limit $inicio,$cant_not_pag ");
$resultado_reg=mysqli_query($base, "select * from edicion ") or die (mysqli_error());
$total_registro=mysqli_num_rows($resultado_reg);
$cantidad_paginas=intval($total_registro/$cant_not_pag);
$col1="numero de edicion";
$col2="Edicion";

}
else // busca por categoria
{
$activa= mysqli_query($base, "select id_cat as id,categoria_cat as nombre , detalle_cat as detalle from categoria order by categoria_cat asc limit $inicio,$cant_not_pag ");
$resultado_reg=mysqli_query($base, "select * from categoria") or die (mysqli_error());
$total_registro=mysqli_num_rows($resultado_reg);
$cantidad_paginas=intval($total_registro/$cant_not_pag);
$col1="Nombre";
$col2="Descripcion";
}


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
    <td width="800" align="left"><span class="Estilo2">Modificar Noticia </span></td>
  </tr>
  <tr>
    <td height="48" align="left" class="Estilo2">&nbsp;</td>
  </tr>
  <tr>
    <td><script type="text/javascript">
<!--
stm_bm(["menu674b",820,"","blank.gif",0,"","",0,0,0,50,500,1,0,0,"","",0,0,1,1,"default","hand",""],this);
stm_bp("p0",[0,4,0,0,8,4,0,0,100,"",-2,"",-2,85,0,0,"#7F7F7F","transparent","",2,0,0,"#959ACC"]);
<?php
for ($i=0;$i<=$cantidad_paginas;$i++)
{
?>

stm_ai("p0i<?php echo $i;?>0",[0,"<?php echo $i+1;?> ","","",-1,-1,0,"modificar_noticia.php?tipo=<?php echo $tipo;?>&pactual=<?php echo $i; ?>","_self","","","","",0,0,0,"","",0,0,0,0,1,"#DBDDD2",0,"#FFFFFF",0,"","",3,3,2,3,"#000000 #000000 #AAD63E","#000000 #000000 #AAD63E","#333333","#000000","bold 8pt Verdana","bold 8pt Verdana",0,0]);
<?php
}
?>
stm_ep();
stm_em();
//-->
</script></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
		<table width="962" border="0" align="center" cellpadding="0" cellspacing="3" >
          <tr>
            <th width="50" bgcolor="#FFFFFF" scope="col">ID</th>
            <th width="331" bgcolor="#FFFFFF" scope="col"><?php echo $col1;?></th>
            <th width="283" bgcolor="#FFFFFF" scope="col"><?php echo $col2;?></th>
            <th bgcolor="#FFFFFF" scope="col">Acciones</th>
          </tr>
          <?php
		  while($regi=mysqli_fetch_assoc($activa))
		  {
		  ?>
		  <tr>
            <td height="31" bgcolor="#B4B4B4"><?php echo $regi["id"];?> </td>
            <td bgcolor="#B4B4B4"><?php echo $regi["nombre"];?> </td>
            <td bgcolor="#B4B4B4"><?php echo $regi["detalle"];?></td>
            <td width="58" bgcolor="#B4B4B4" align="center">
				<a href="modificar_noticia2.php?tipo=<?php echo $tipo;?>&id=<?php echo $regi["id"];?>" >
					<img src="img/habilta.jpg" alt="Modificar" border="0" />				</a>			</td>
          </tr>
		  <?php }?>
      </table>	</td>
  </tr>
</table>
</div>
</body>
</html>
