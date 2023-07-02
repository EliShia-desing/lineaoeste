<?php require_once("conectar/conectar.php"); 
mysqli_select_db($base, $database);
$mensaje="";
if (isset($_GET["id"]))
{
  $id=$_GET["id"];
  unset($_GET["id"]);
}
if (isset($_POST["id"]))
{
  $id=$_POST["id"];
  unset($_POST["id"]);
}
$cons1="SELECT * FROM categoria where id_cat='$id'";
$res1=mysqli_query($base, $cons1) or die (mysqli_error()) ;
$fila=mysqli_fetch_array($res1);
$id_cat=$fila["id_cat"];
$categoria_cat=$fila["categoria_cat"];
$orden=$fila["orden"];
$xfoto=$fila["foto"];
$detalle_cat=$fila["detalle_cat"];


//calculo de pagina
if(isset($_POST["envia_categoria"]))
{
	$conterror=0;
	$id_cat=$_POST["id_cat"];
	$categoria_cat=$_POST["categoria_cat"];
	$orden=$_POST["orden"];
	$xfoto=$_POST["xfoto"];
	$detalle_cat=$_POST["detalle_cat"];
	if ($_FILES['foto']['name']!='')
 	{
	    if ($xfoto=="")
	   {        
	   	$enlacito1='img/rubro/foto'.$id_cat.'.jpg'; 
	   }
	   else
	   {
	   	   	$enlacito1=$xfoto; 
	   }
	   $nom='../'.$enlacito1; 
	   $tipo_archivo = $_FILES['foto']['type'];
  	   $tamano_archivo = $_FILES['foto']['size'];
	   if (!(strpos($tipo_archivo, "jpeg") && ($tamano_archivo < 1024000)))
		  {
			$conterror++;
			$mensaje="La extensi&oacute;n o el tama&ntilde;o de los archivos de la foto del categoria no es correcta. <br><br>
						Se permiten archivos .jpg<br />
<br />
						Se permiten archivos de 950 Kb m&aacute;ximo";
			
		  }
		else
		  {
 			if ((copy($_FILES['foto']['tmp_name'],'../'.$enlacito1)))
				{
					//parametros iniciales de la fotoas 
					$img_original=$nom;
					$img_nueva=$nom;
					//matriz se obtien el tamaño de la fot original
					$sizes=getimagesize($img_original);
					$alto=$sizes[1];  //este es el q vale de sizes
					$ancho=$sizes[0];
					if($alto<$ancho)//foto acostada
					{
						$img_nueva_anchura="284";
						$img_nueva_altura=round($img_nueva_anchura*$alto/$ancho);  
						$img_nueva_calidad="80";
					}
					else
					{
					  if ($alto>$ancho)//fotoparada
					  {
					  	$img_nueva_altura="213";
						$img_nueva_anchura=round($img_nueva_altura*$ancho/$alto);
						$img_nueva_calidad="80";
					  }
					  else//foto cuadrada
					  {
					  	$img_nueva_anchura="213";
						$img_nueva_altura="213";
						$img_nueva_calidad="80";
					  }
					}
					//crear una nueva imagen a partir de un aexistente
					$img = imagecreatefromjpeg($img_original);	
					//crea una imagen en blanco con el nuevo tamaño determinado en el parametro imagecreatetruecolor ( int anchura, int altura )
					//  devuelve un identificador en blanco
					$thumb = imagecreatetruecolor($img_nueva_anchura,$img_nueva_altura);
					//copia y redimensiona la nueva imagen (destino,origen)
					//imagesx-sy obtiene la altura de la imagen original
					imagecopyresized($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura,imagesx($img),imagesy($img ));
					//crea una imagen a partir de la copia cache - reduciendo la calidad
					imagejpeg($thumb,$img_nueva,$img_nueva_calidad);
				}//fin si copy
	  		  else
		  		{
					$conterror++;
					$mensaje=$mensaje.'<br>Ocurri&oacute; alg&uacute;n error al subir el fichero de la foto de categoria. No pudo guardarse.';
			
				}	
			}	
        }//fin si foto con categoria_cat
	else
	{
	   if ($xfoto=="")
	   {        
	   	$enlacito1=''; 
	   }
	   else
	   {
	   	   	$enlacito1=$xfoto; 
	   }
	}				 
	
if ($conterror==0)
	{
   //$archivof='logo_p.jpg';
	$consulta="update categoria set categoria_cat='$categoria_cat' ,orden='$orden', foto='$enlacito1', detalle_cat='$detalle_cat'  where id_cat='$id_cat'  ";
   $resultado= mysqli_query($base, $consulta)or die(mysqli_error());	
   $mensaje='Registro exitoso';
   $categoria_cat1="";
	   $detalle_cat1="";
	}   
}
/*$consultaSql1="select * from marcas $cadena  order by id desc limit $inicio,$cant_not_pag ";//;
$resultado1 = mysqli_query($consultaSql1,$base) or die(mysqli_error());
$numero=mysqli_num_rows($resultado1);*/

/*$resultado_reg=mysqli_query("select * from marcas $cadena",$base) or die (mysqli_error());
$total_registro=mysqli_num_rows($resultado_reg);
$cantidad_paginas=intval($total_registro/$cant_not_pag);*/


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <td width="800" align="left"><span class="Estilo2">Modificar Categorías</span></td>
  </tr>
  <tr>
      <td>
	  	<?php if (($mensaje!=""))
	  	  {
  			  if ($mensaje=='Registro exitoso')
  		 		 {
				    	unset($_POST["envia_categoria"]);
		     		?>			<div align="left" class="mensaje">
									<?php echo $mensaje; ?>
								</div>
								<br />
					 <script type='text/javascript'>
					document.write('<p class="details"><a href="categorias.php">Volver a la página de inicio.</a></p>');
					</script>
					<script type='text/javascript'>
					  setTimeout('window.location="categorias.php"', 4000);
					</script>
		  		<?php 
				
				}
			else
			{	

		?>
			<div align="left" class="mensaje"><?php echo $mensaje; ?></div>
		<?php 
			}
		}?>	
	</td>
    </tr>
  <tr>
    <td height="19" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td height="19" align="left">
		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
		  <table width="800" border="0" align="center" cellpadding="0" cellspacing="3" >
            <tr>
              <th width="47" height="48" scope="col">&nbsp;</th>
              <th width="250" bgcolor="#DDDDDD" scope="col"><div align="right">
                <input type="hidden" name="id_cat" value="<?php echo $id_cat; ?>" />
                Nombre Categoría: </div></th>
              <th width="426" align="left" bgcolor="#DDDDDD" scope="col"><label>
                <input value="<?php echo $categoria_cat;?>" name="categoria_cat" class="required" type="text" id="categoria_cat" size="55" />
              </label></th>
              <th width="35" scope="col">&nbsp;</th>
              <th width="24" scope="col">&nbsp;</th>
            </tr>
            <tr>
              <td height="45">&nbsp;</td>
              <td bgcolor="#DDDDDD"><div align="right"><strong>Descripción de la Categoría:</strong></div></td>
              <td bgcolor="#DDDDDD"><textarea name="detalle_cat" cols="60" rows="5" class="ckeditor" id="detalle_cat"><?php echo $detalle_cat;?></textarea></td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr>
              <td height="71">&nbsp;</td>
              <td bgcolor="#DDDDDD"><div align="right"><strong>Orden:</strong></div></td>
              <td bgcolor="#DDDDDD"><input value="<?php echo $orden;?>" name="orden" class="required" type="text" id="orden" size="55" /></td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr>
              <td height="45">&nbsp;</td>
              <td bgcolor="#DDDDDD"><div align="right"><strong>Foto de la categoria:</strong></div></td>
              <td bgcolor="#DDDDDD"><img src="../<?php echo $xfoto;?>" width="100" />
                <input name="foto" type="file" id="foto" size="40" />
                <input name="xfoto" type="hidden" id="xfoto" value="<?php echo $xfoto;?>" /></td><td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
            
            <tr>
              <td height="31">&nbsp;</td>
              <td>&nbsp;</td>
              <td><label>
                <div align="right">
                  <input name="envia_categoria" type="submit" id="envia_categoria" value="Modificar Categoría &gt;&gt;" />
                </div>
              </label></td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
          </table>
        </form>	
	
	</td>
  </tr>
</table>
</div>
</body>
</html>
