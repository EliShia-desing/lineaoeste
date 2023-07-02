<?php 
//conexion
 $mes = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
  $fecha1=$mes[date('n')].",".strftime('%Y',time());
  require_once("conectar/conectar.php"); 
mysql_select_db($database, $base);
$mensaje="";
$id=1;

if (isset($_GET["id"]))
{
  $id=$_GET["id"];	 
}
if (isset($_POST["id"]))
{
  $id=$_POST["id"];	 
}
$ed_activa= mysql_query("select * from noticia where id_noticia=$id",$base);
$res_noticia=mysql_fetch_assoc($ed_activa);

    $mes = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
 $titulo=utf8_encode($res_noticia["titulo"]);
 $descripcion=utf8_encode($res_noticia["descripcion"]);
 $periodista=utf8_encode($res_noticia["autor"]);
$xfoto="../".$res_noticia["foto"];
$xfoto1="../".$res_noticia["foto1"];
$rubro=$res_noticia["rubro"];
$relevancia=$res_noticia["relevancia"];
 $fecha=$res_noticia["fecha"]; //edicion
$orden=$res_noticia["orden"];
  $fecha_act=$mes[date('n')].",".strftime('%Y',time());
  $fecha_act12=date("d").'/'.date('m')."/".strftime('%Y',time());

 $desc_foto=$res_noticia["desc_foto"];
 $fec_not=$res_noticia["fecha_not"]; //fecha de noticia


 $epigrafe=$res_noticia["titular"];


  $video=$res_noticia["video"];




$cons_not_actual=mysql_query("SELECT * FROM categoria where id_cat='$rubro'",$base);
$not_actual=mysql_fetch_assoc($cons_not_actual);

$SQLrubro = "SELECT * FROM categoria order by categoria_cat asc"; 
  $res_rubro= mysql_query($SQLrubro,$base)or die(mysql_error()); 
     
 
?> 

<?php if(isset($_POST["envia_noticia"]))
{
	$conterror=0;
	$titulo=utf8_decode($_POST["titulo"]);
	$descripcion=utf8_decode($_POST["descripcion"]);
	$periodista=utf8_decode($_POST["periodista"]);
	$xfoto= $_POST["xfoto"];
	$xfoto1= $_POST["xfoto1"];
	
	$rubro=$_POST["rubro"];
    $relevancia=$_POST["relevancia"];
	$fecha=$_POST["fecha"]; //edicion
	$epigrafe=$_POST["epigrafe"];
	$orden= $_POST["orden"];	
	$desc_foto=$_POST["desc_foto"];
	$fec_not=$_POST["fec_not"]; //fecha de noticia	
	$video=$_POST["video"];

  	if( !(file_exists('../img/'.$fecha)))
		{
 			mkdir("../img/".$fecha);
		}

    if ($_FILES['foto']['name']!='')
 	 {
 		if ($xfoto!="")
		{
		   $nom= $xfoto;
		   $nom1= $xfoto1;	
		}
		else
		{
  	    $nom='../img/'.$fecha.'/foto'.$id.'.jpg'; 
		$nom1='../img/'.$fecha.'/foto'.$id.'-1.jpg';
		}
	    $tipo_archivo = $_FILES['foto']['type'];
  	    $tamano_archivo = $_FILES['foto']['size'];
	    if (!(strpos($tipo_archivo, "jpeg") && ($tamano_archivo < 1024000)))
		  {
			$conterror++;
			$mensaje=
			"La extensi&oacute;n o el tama&ntilde;o de los archivos de la foto del equipo no es correcta. <br><br>
			Se permiten archivos .jpg<br /><br />
			Se permiten archivos de 950 Kb m&aacute;ximo";
		    $periodista=($_POST["periodista"]);
			$titulo=($_POST["titulo"]);
			$epigrafe=$_POST["epigrafe"];
			$descripcion=($_POST["descripcion"]);
			$desc_foto=$_POST["desc_foto"];
			$relevancia=$_POST["relevancia"];
			$video=$_POST["video"];
			$fecha=$_POST["fecha"]; //edicion
			$fec_not=$_POST["fec_not"]; //fecha de noticia
		  }
		else
		  {
		     if ((copy($_FILES['foto']['tmp_name'],'../img/'.$fecha.'/foto'.$num_foto.'.jpg'))&&(copy($_FILES['foto']['tmp_name'],'../img/'.$fecha.'/foto'.$num_foto.'-1.jpg')))
				{
					//parametros iniciales de la fotoas 
					$img_original=$nom;
					$img_nueva=$nom;
					$img_nueva1=$nom1;
					//matriz se obtien el tamaño de la fot original
					$sizes=getimagesize($img_original);
					$alto=$sizes[1];  //este es el q vale de sizes
					$ancho=$sizes[0];

					if($alto<$ancho)//foto acostada
					{
						$img_nueva_anchura="600";
						$img_nueva_altura=round($img_nueva_anchura*$alto/$ancho);  
						$img_nueva_calidad="80";
						$img_nueva_anchura1="900";
						$img_nueva_altura1=round($img_nueva_anchura1*$alto/$ancho);}
					else
					{
					  if ($alto>$ancho)//fotoparada
					  {
					  	$img_nueva_altura="400";
						$img_nueva_anchura=round($img_nueva_altura*$ancho/$alto);
						$img_nueva_calidad="80";
						$img_nueva_altura1="600";
						$img_nueva_anchura1=round($img_nueva_altura1*$ancho/$alto); 

						
					  }
					  else//foto cuadrada
					  {
					  	$img_nueva_anchura="600";
						$img_nueva_altura="600";
						$img_nueva_calidad="80";
						$img_nueva_anchura1="900";
						$img_nueva_altura1="900";
					  }
					}
					//crear una nueva imagen a partir de un aexistente
					$img = imagecreatefromjpeg($img_original);	
					$img1 = imagecreatefromjpeg($img_original);						
					//crea una imagen en blanco con el nuevo tamaño determinado en el parametro imagecreatetruecolor ( int anchura, int altura )
					//  devuelve un identificador en blanco
					$thumb = imagecreatetruecolor($img_nueva_anchura,$img_nueva_altura);
  				    $thumb1 = imagecreatetruecolor($img_nueva_anchura1,$img_nueva_altura1);
					//copia y redimensiona la nueva imagen (destino,origen)
					//imagesx-sy obtiene la altura de la imagen original
					imagecopyresized($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura,imagesx($img),imagesy($img ));
				imagecopyresized($thumb1,$img1,0,0,0,0,$img_nueva_anchura1,$img_nueva_altura1,imagesx($img1),imagesy($img1));

					//crea una imagen a partir de la copia cache - reduciendo la calidad
					imagejpeg($thumb,$img_nueva,$img_nueva_calidad);
					imagejpeg($thumb1,$img_nueva1,$img_nueva_calidad);

				    $archivofoto=substr($nom,3,255);
					$archivofoto1=substr($nom1,3,255);

					$nombre1='';
					$descripcion1='';

//ddddddddddddddddddddddddddddddddddddddddddddddddddddd
				}//fin si copy
	  		  else
		  		{
			    $periodista=($_POST["periodista"]);
				$titulo=($_POST["titulo"]);
				$epigrafe=$_POST["epigrafe"];
				$descripcion=($_POST["descripcion"]);
				$desc_foto=$_POST["desc_foto"];
				$relevancia=$_POST["relevancia"];
				$video=$_POST["video"];
				$fecha=$_POST["fecha"]; //edicion
				$fec_not=$_POST["fec_not"]; //fecha de noticia
				$conterror++;
				$mensaje=$mensaje.'<br>Ocurri&oacute; alg&uacute;n error al subir el fichero de la foto de equipo. No pudo guardarse.';
			
				}	
			}//fin else 	tipo de archivo
	 }//fin si foto con nombre
	 else
	 {
		 $archivofoto=substr($xfoto,3,255);
		 $archivofoto1= substr($xfoto1,3,255);
	 }
	 if ($conterror==0)
		{
		  $query_links = "update noticia set titulo='$titulo', descripcion='$descripcion', autor='$periodista', foto='$archivofoto', rubro='$rubro', relevancia='$relevancia' , fecha='$fecha' ,fecha_not='$fec_not', desc_foto='$desc_foto', foto1='$archivofoto1', orden='$orden', titular='$epigrafe', video='$video' where id_noticia='$id'";
		  
		  $salida = mysql_query($query_links, $base) or die(mysql_error());
		unset($_POST["envia_noticia"]);
		$mensaje="Registro Exitoso";
	    }
       




 
 
}


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
    <td width="800" align="left"><span class="Estilo2">Modificar Noticia</span></td>
  </tr>
  <tr>
      <td>
	  	<?php if (($mensaje!=""))
	  	  {
  			  if ($mensaje=='Registro Exitoso')
  		 		 {
				    	unset($_POST["envia_noticia"]);
		     		?>			<div align="left" class="mensaje">
									<?php echo $mensaje; ?>
								</div>
								<br />
					 <script type='text/javascript'>
					document.write('<p class="details"><a href="index.php">Volver a la página de inicio.</a></p>');
					</script>
					<script type='text/javascript'>
					  setTimeout('window.location="index.php"', 4000);
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
		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return (confirma())">
		  <table width="800" border="0" align="center" cellpadding="0" cellspacing="3" >
            <tr>
              <th width="49" height="48" scope="col">&nbsp;</th>
              <th width="172" bgcolor="#DDDDDD" scope="col"><div align="right">Seccion de la Noticia : </div></th>
              <th width="504" bgcolor="#DDDDDD" scope="col"><label>
                <div align="left">
                  <label>
                  <select name="rubro" id="rubro">
                  <option value="<?php echo $not_actual["id_cat"];?>" selected="selected"><?php echo utf8_encode($not_actual["categoria_cat"]);?></option>
				    <?php while ($fila_cat=mysql_fetch_assoc($res_rubro))
					{
					?>
                    <option value="<?php echo $fila_cat["id_cat"];?>"><?php echo utf8_encode($fila_cat["categoria_cat"]);?></option>
					<?php }
					?>
                  </select>
                  </label>
                </div>
              </label></th>
              <th width="36" scope="col">&nbsp;</th>
              <th width="21" scope="col">&nbsp;</th>
            </tr>
             <tr>
               <th height="69" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right">Periodista : </div></th>
               <th bgcolor="#DDDDDD" scope="col"><label>
                 <div align="left">
                   <textarea name="periodista" cols="60" rows="3" id="periodista" class="ckeditor" ><?php echo $periodista;?></textarea>
                   </div>
               </label></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
             <tr>
               <th height="48" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right">Titulo de la Noticia  : </div></th>
               <th bgcolor="#DDDDDD" scope="col"><label>
                 <div align="left">
                   <input value="<?php echo $titulo;?>" name="titulo" class="required" type="text" id="titulo" size="55" />
                   </div>
               </label></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
             <tr>
               <th height="48" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right">Epígrafe de la Noticia : </div></th>
               <th bgcolor="#DDDDDD" scope="col"><label>
                 <div align="left">
                   <input value="<?php echo $epigrafe;?>" name="epigrafe" class="required" type="text" id="epigrafe" size="55" />
                   </div>
               </label></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
             <tr>
               <th height="103" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right">Cuerpo de la Noticia : </div></th>
               <th bgcolor="#DDDDDD" scope="col"><label>
                 <div align="left">
                   <textarea name="descripcion" cols="60" rows="5" id="descripcion" class="ckeditor" ><?php echo $descripcion;?></textarea>
                   </div>
               </label></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
             <tr>
               <th height="48" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right">Foto Principal  : </div></th>
               <th bgcolor="#DDDDDD" scope="col"><label>
                 <div align="left">
                  <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
                  <input name="xfoto" id="xfoto" type="hidden" value="<?php echo $xfoto;?>" />
                  <input name="orden" id="orden" type="hidden" value="<?php echo $orden;?>" />
                  <input name="xfoto1" id="xfoto1" type="hidden" value="<?php echo $xfoto1;?>" />
                  <img src="<?php echo $xfoto;?>" border="0" />
                  <input name="foto" id="foto" type="file" size="45" />
                 </div>
               </label></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
             <tr>
               <th height="48" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right">Descripcion de foto : </div></th>
               <th bgcolor="#DDDDDD" scope="col"><label>
                 <div align="left">
                   <textarea name="desc_foto" cols="60" rows="3" id="desc_foto" class="ckeditor" ><?php echo $desc_foto;?></textarea>
                   </div>
               </label></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
             <tr>
               <th height="48" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right">Noticia en Portada : </div></th>
               <th bgcolor="#DDDDDD" scope="col"><label>
                 <div align="left">
                   <select name="relevancia" id="relevancia">
                   <?php if ($relevancia==1)
				   {
					 ?>
                     
                     <option value="1" selected="selected">Sí</option>  
                     <?php
				   }
				   else
				   {?>
					<option value="2" selected="selected">No</option>  
        			   <?php
				   }?>
                     <option value="1" >Sí</option>
                     <option value="2">No</option>
                   </select>
                   </div>
               </label></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
             <tr>
               <th height="48" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right"> Nº Edición de Noticia: </div></th>
               <th bgcolor="#DDDDDD" scope="col"><div align="left">
                 <input value="<?php echo $fecha;?>" name="fecha" class="required" type="text" id="fecha" size="55" />
               </div></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
             <tr>
              <th width="49" height="48" scope="col">&nbsp;</th>
              <th width="172" bgcolor="#DDDDDD" scope="col"><div align="right">Fecha Noticia </div></th>
              <th width="504" bgcolor="#DDDDDD" scope="col"><label>
                <div align="left">
                  <input value="<?php echo $fec_not;?>" name="fec_not" class="required" type="text" id="fec_not" size="55" />
                  </div>
              </label></th>
              <th width="36" scope="col">&nbsp;</th>
              <th width="21" scope="col">&nbsp;</th>
            </tr>
             <tr>
               <th height="48" scope="col">&nbsp;</th>
               <th bgcolor="#DDDDDD" scope="col"><div align="right">Enlace a Video </div></th>
               <th bgcolor="#DDDDDD" scope="col"><label>
                 <div align="left">
                   <input value="<?php echo $video;?>" name="video" class="required" type="text" id="video" size="55" />
                 </div>
                 </label></th>
               <th scope="col">&nbsp;</th>
               <th scope="col">&nbsp;</th>
             </tr>
			 
            <tr>
              <td height="31">&nbsp;</td>
              <td>&nbsp;</td>
              <td><label>
                <div align="right">
                  <input name="envia_noticia" type="submit"  onclick="return (testeoform())" id="envia_noticia" value="Subir Noticia &gt;&gt;" />
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
