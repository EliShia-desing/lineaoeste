<?php 
$mensaje="";
$mensaje2="";
$conterror2=0;
$conterror=0;
//calculo de pagina
if(!isset($_GET["id"]))
{
	if(!isset($_POST["id"]))
	{
		$idNoticia=0;//donde empieza 
	}else{
		$idNoticia=$_POST["id"];//donde empieza 
	}
}
else
{
$idNoticia=$_GET["id"];
}
require_once("conectar/conectar.php"); 
mysql_select_db($database, $base);
//nuevo foto
if(isset($_POST["nuevo"]))

{

	$conterror=0;
	$descripcion=utf8_decode($_POST["descripcion"]);
    if ($_FILES['foto']['name']!='')
 	 {
		$foto=$idNoticia."_".rand(0,9).rand(100,9999).rand(100,9999).".jpg";  		
		$nom='img/adjunto/'.$foto; 

		$tipo_archivo = $_FILES['foto']['type'];

  	    	$tamano_archivo = $_FILES['foto']['size'];
		if (!(strpos($tipo_archivo, "jpeg") && ($tamano_archivo < 1024000)))

		  {

			$conterror++;

			$mensaje=

			"La extensi&oacute;n o el tama&ntilde;o de los archivos de la foto del equipo no es correcta. <br><br>

			Se permiten archivos .jpg<br /><br />

			Se permiten archivos de 950 Kb m&aacute;ximo";

		  }

		else

		  {

		     if ((copy($_FILES['foto']['tmp_name'],'../img/adjunto/'.$foto)))

				{

					//parametros iniciales de la fotoas 

					$img_original="../".$nom;

					$img_nueva="../".$nom;

					//matriz se obtien el tamaño de la fot original

					$sizes=getimagesize($img_original);

					$alto=$sizes[1];  //este es el q vale de sizes

					$ancho=$sizes[0];



					if($alto<$ancho)//foto acostada

					{

						$img_nueva_anchura="600";

						$img_nueva_altura=round($img_nueva_anchura*$alto/$ancho);  

						$img_nueva_calidad="80";
					}

					else

					{

					  if ($alto>$ancho)//fotoparada
					  {
					  	$img_nueva_altura="400";

						$img_nueva_anchura=round($img_nueva_altura*$ancho/$alto);
						$img_nueva_calidad="80";
					  }

					  else//foto cuadrada
					  {
					  	$img_nueva_anchura="600";

						$img_nueva_altura="600";

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



				    	$archivofoto=$nom;

				}//fin si copy

	  		  else

		  		{

			    	$conterror++;

				$mensaje=$mensaje.'<br>Ocurri&oacute; alg&uacute;n error al subir el fichero de la foto de equipo. No pudo guardarse.';

			

				}	

			}//fin else 	tipo de archivo

	 }//fin si foto con nombre

	 else

	 {

		 	$conterror++;
			$mensaje="Debe elegir una foto";
		 
		 	$archivofoto="";
		

	 }

	 if ($conterror==0)

		{

		  $query_links = "insert into fotos(noticia,descripcion, foto) values('$idNoticia', '$descripcion', '$archivofoto')";

		  

		  $salida = mysql_query($query_links, $base) or die(mysql_error());

		unset($_POST["nuevo"]);

		$mensaje="Registro Exitoso";

	    }
 

}

?>
<?php

//elimina banner

if(isset($_POST["eliminar"]))

{

$idFoto=$_POST['idFoto'];
$query_links = "delete from fotos where id=".$idFoto;
$salida = mysql_query($query_links, $base) or die(mysql_error());
unset($_POST["eliminar"]);
}

//modifica banner
if(isset($_POST["modificar"]))

{ 
		unset($_POST["modificar"]);

$mensaje2=0;
$idFoto=$_POST['idFoto'];
	$conterror2=0;
	$descripcion2=utf8_decode($_POST["descripcion2"]);
	$foto=$_POST["xfoto"];
    if ($_FILES['foto2']['name']!='')
 	 {
		$foto=$_POST["xfoto"];
		$nom=$foto; 
		$foto=end(explode("/",$foto));
		$nom='img/adjunto/'.$foto; 

		$tipo_archivo = $_FILES['foto2']['type'];

  	    $tamano_archivo = $_FILES['foto2']['size'];
		if (!(strpos($tipo_archivo, "jpeg") && ($tamano_archivo < 1024000)))
		  {
			$conterror2++;
			$mensaje2=
			"La extensi&oacute;n o el tama&ntilde;o de los archivos de la foto del equipo no es correcta. <br><br>
			Se permiten archivos .jpg<br /><br />
			Se permiten archivos de 950 Kb m&aacute;ximo";
		  }
		else
		  {
		     if ((copy($_FILES['foto2']['tmp_name'],'../img/adjunto/'.$foto)))
			{
			//parametros iniciales de la fotoas 
					$img_original="../".$nom;
					$img_nueva="../".$nom;
					//matriz se obtien el tamaño de la fot original
					$sizes=getimagesize($img_original);
					$alto=$sizes[1];  //este es el q vale de sizes
					$ancho=$sizes[0];
					if($alto<$ancho)//foto acostada
					{
						$img_nueva_anchura="600";
						$img_nueva_altura=round($img_nueva_anchura*$alto/$ancho);  
						$img_nueva_calidad="80";
					}
					else
					{
					  if ($alto>$ancho)//fotoparada
					  {
					  	$img_nueva_altura="400";
						$img_nueva_anchura=round($img_nueva_altura*$ancho/$alto);
						$img_nueva_calidad="80";
					  }
					  else//foto cuadrada
					  {
					  	$img_nueva_anchura="600";
						$img_nueva_altura="600";
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
				    	$archivofoto=$nom;
				}//fin si copy
	  		  else
		  		{
			    	$conterror2++;

				$mensaje2=$mensaje2.'<br>Ocurri&oacute; alg&uacute;n error al subir el fichero de la foto de equipo. No pudo guardarse.';

				}	
			}//fin else 	tipo de archivo

	 }//fin si foto con nombre
	 else
	 {
		 $archivofoto=$foto;
	 }

	 if ($conterror2==0)

		{

		  $query_links = "update fotos set  descripcion ='$descripcion2' , foto = '$archivofoto' where id =".$idFoto;

		  

		  $salida = mysql_query($query_links, $base) or die(mysql_error());



		$mensaje2="Registro Exitoso";

	    }
 

}



$query_links = "SELECT * FROM fotos where noticia='$idNoticia' order by id asc ";

$consulta = mysql_query($query_links, $base) or die(mysql_error());
/*
   $aux=mysql_query("select * from edicion where id_edicion='$id' ",$base);
   $fila_aux=mysql_fetch_assoc($aux);
   $activa= mysql_query("select * from noticia where fecha='".$fila_aux["fecha"]."' order by titulo desc limit $inicio,$cant_not_pag",$base);
 $resultado_reg=mysql_query("select * from noticia where fecha='".$fila_aux["fecha"]."'",$base) or die (mysql_error());
$total_registro=mysql_num_rows($resultado_reg);
$cantidad_paginas=intval($total_registro/$cant_not_pag);
 */
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><script type="text/javascript" src="stmenu.js"></script>
<script type="text/javascript" src="wforms.js"></script>
<script type="text/javascript" src="localization-es.js"></script> 
<script src="ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
 
<script type="text/javascript">
function elimina(id)
{
  if (confirm("esta seguro de eliminar esta noticia?"))
     {
	    setTimeout('window.location="eliminar_noticia3.php?id='+id+'"', 500);
		return true;
	 }
  else
  {
    return false;
  }
}
</script>


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
    <td width="800" colspan="2" align="left">
		<form action="fotos.php" method="post" enctype="multipart/form-data">
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
          <tbody><tr>
            <td colspan="3"><label><span class="Estilo1">NUEVA FOTO </span> </label></td>
          </tr>
          <tr>
            <td colspan="3"><hr>
			
			</td>
          </tr>
		    <tr>
            <td width="12%" bgcolor="#CCCCCC"><span class="Estilo1">Descripción Foto</span></td> 
            <td width="75%" bgcolor="#CCCCCC"><label>
            <textarea name="descripcion" cols="78" rows="3" id="descripcion"></textarea>
            </label>
              <input name="id" type="hidden" id="id" value="<?php echo $idNoticia;?>" /></td> 
            <td width="13%" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
			 <tr>
            <td width="12%" bgcolor="#CCCCCC"><span class="Estilo1">Imagen</span></td> 
            <td width="75%" bgcolor="#CCCCCC"><input name="foto" type="file" id="foto" size="60"></td>
            <td width="13%" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
			<tr><td width="12%" bgcolor="#CCCCCC">&nbsp;</td> 
              <td width="75%" bgcolor="#CCCCCC"><div align="right"></div></td>
              <td width="13%" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
			<tr><td width="12%" bgcolor="#CCCCCC">&nbsp;</td> 
              <td width="75%" bgcolor="#CCCCCC"><div align="right"><span class="Estilo2">
			  		 </span>
                <input name="nuevo" type="submit" id="nuevo" value="Subir Banner">
              </div></td>
              <td width="13%" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
			
			<td colspan="3">
			<?php if (($mensaje!=""))
			{

  			  if ($mensaje=='Registro Exitoso')
	 		 {
		?>			<div align="left" class="mensaje">
								<?php echo $mensaje; ?>
								</div>
								<br />

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
        </tbody></table>
      </form>
	  
	    <table width="559">
	  <tr>

	  <td colspan="2">&nbsp; </td> 

	  </tr>

	  <tr>

	  <td colspan="2">Fotos de la Noticia id = <?php  echo $idNoticia;?> </td> 

	  </tr>

<td colspan="2">&nbsp;  
			<?php if (($mensaje2!=""))
			{

  			  if ($mensaje2=='Registro Exitoso')
	 		 {
		?>			<div align="left" class="mensaje">
								<?php echo $mensaje2; ?>
								</div>
								<br />

		  		<?php 
				}
			else
			{	
		?>
			<div align="left" class="mensaje"><?php echo $mensaje2; ?></div>
		<?php
			}
		}?>
		
		</td>
	  </tr>

	  <td colspan="2">&nbsp; </td> 

	  </tr>

	  <?php 

	  

	  while($datos=mysql_fetch_array($consulta))

	  {

	  ?>

	  <form action="fotos.php?id=<?php echo $idNoticia;?>" method="post" enctype="multipart/form-data">

      

	  <?php 

	  $foto1=$datos["foto"];

	$ext=explode(".",$foto1);

	  ?>

	<TR>

		<td width="201" rowspan="4">  
		<div align="center"><img src="/<?php echo $datos['foto'];?>" width="150" /></div></td> 
		<td width="346" valign="top">	  <div align="left">
		<textarea name="descripcion2" cols="48" rows="3"><?php echo utf8_encode($datos["descripcion"]);  ?></textarea>

	  </div></td> 

	  </tr>

	   <tr>

	  <td><?php echo $datos["banner"];  ?>-

	    <input type="hidden"  name="idFoto" value="<?php echo $datos["id"]; ?>"/>
	    <input type="hidden"  name="xfoto" value="<?php echo $datos["foto"]; ?>"/>

	  </tr>

	   <tr>

	  <td><input name="foto2" type="file" size="35"  /></td>

	  </tr>

	  <tr>

	  <td >	 

	    <div align="center">

	      <input type="submit" value="Eliminar Banner" name="eliminar"  />

	      <input type="submit" value="Modificar Banner" name="modificar"  />

	      </div></td>

	  </tr>

      

	  <tr>
	  <tD colspan="2">
	  <hr>
	  </tD>
	  </tr>
	  </form>
	  <?php } ?>
	  </table>

	</td>
  </tr>
  </table>
</div>
</body>
</html>
