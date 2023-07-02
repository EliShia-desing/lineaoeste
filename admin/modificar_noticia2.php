<?php 
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
//conexion
 $mes = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
  $fecha1=$mes[date('n')].",".strftime('%Y',time());
  require_once("conectar/conectar.php"); 
mysql_select_db($database, $base);
$tipo=1;
if (isset($_GET["tipo"]))
{
  $tipo=$_GET["tipo"];	 
}
$id=1;

if (isset($_GET["id"]))
{
  $id=$_GET["id"];	 
}
if (isset($_POST["id"]))
{
  $id=$_POST["id"];	 
}

if($tipo==1)  //busca por edicion
{
   $aux=mysql_query("select * from edicion where id_edicion='$id' ",$base);
   $fila_aux=mysql_fetch_assoc($aux);
   $activa= mysql_query("select * from noticia where fecha='".$fila_aux["fecha"]."' order by titulo desc limit $inicio,$cant_not_pag",$base);
 $resultado_reg=mysql_query("select * from noticia where fecha='".$fila_aux["fecha"]."'",$base) or die (mysql_error());
$total_registro=mysql_num_rows($resultado_reg);
$cantidad_paginas=intval($total_registro/$cant_not_pag);
}
else  //busca por categoria
{
   $aux=mysql_query("select * from categoria where id_cat='$id'",$base);
   $fila_aux=mysql_fetch_assoc($aux);
   $activa= mysql_query("select * from noticia where rubro='".$fila_aux["id_cat"]."'",$base);
   $resultado_reg=mysql_query("select * from noticia where fecha='".$fila_aux["id_cat"]."'",$base) or die (mysql_error());
   $total_registro=mysql_num_rows($resultado_reg);
   $cantidad_paginas=intval($total_registro/$cant_not_pag);
}
//  $res_noticia=mysql_fetch_assoc($ed_activa);  
 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><script type="text/javascript" src="stmenu.js"></script>
<script type="text/javascript" src="wforms.js"></script>
<script type="text/javascript" src="localization-es.js"></script> 
<script src="ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

stm_ai("p0i<?php echo $i;?>0",[0,"<?php echo $i+1;?> ","","",-1,-1,0,"modificar_noticia2.php?tipo=<?php echo $tipo;?>&pactual=<?php echo $i; ?>&id=<?php echo $id; ?>","_self","","","","",0,0,0,"","",0,0,0,0,1,"#DBDDD2",0,"#FFFFFF",0,"","",3,3,2,3,"#000000 #000000 #AAD63E","#000000 #000000 #AAD63E","#333333","#000000","bold 8pt Verdana","bold 8pt Verdana",0,0]);
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
		<table width="953" border="0" align="center" cellpadding="0" cellspacing="3" >
          <tr>
            <th width="47" bgcolor="#FFFFFF" scope="col">ID</th>
            <th width="332" bgcolor="#FFFFFF" scope="col">Titulo</th>
            <th width="317" bgcolor="#FFFFFF" scope="col">Descripcion</th>
            <th width="94" bgcolor="#FFFFFF" scope="col">Portada</th>
            <th bgcolor="#FFFFFF" scope="col">Acciones</th>
          </tr>
          <?php
		  while($regi=mysql_fetch_array($activa))
		  {
		  ?>
		  <tr>
            <td height="31" bgcolor="#B4B4B4"><?php echo $regi["id_noticia"];?> </td>
            <td bgcolor="#B4B4B4"><?php echo utf8_encode($regi["titulo"]);?></td>
            <td bgcolor="#B4B4B4"><?php echo utf8_encode(substr($regi["descripcion"],0,100)."...");?> </td>
            <td bgcolor="#B4B4B4"><?php if ($regi["relevancia"]==1){ echo "Sí";} else
			{echo "No";}?></td>
            <td width="145" bgcolor="#B4B4B4" align="center">
				<a href="modificar_noticia3.php?id=<?php echo $regi["id_noticia"];?>" >
					<img src="img/modificar.gif" alt="Modificar" width="25" height="25" border="0" />				</a>&nbsp;&nbsp;&nbsp;
&nbsp;
						<a href="fotos.php?id=<?php echo $regi["id_noticia"];?>" title="Agregar fotos"  >
					<img src="img/foto.jpg" width="25" alt="Modificar" border="0" />				</a>					</td>
          </tr>
		  <?php }?>
      </table>	</td>
  </tr>
</table>
</div>
</body>
</html>
