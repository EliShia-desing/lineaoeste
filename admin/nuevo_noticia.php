<?php 

function url_title($str, $separator = 'dash', $lowercase = FALSE) {
    if ($separator == 'dash') {
        $search  = '_';
        $replace = '-';
    }
    else {
        $search  = '-';
        $replace = '_';
    }
    $str = (strtolower(strtr(($str), 
	                         ('ÀÁÂÃÄÅÑÒÓÔÕÖÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöùúûýýÿRr'),
	                          'aaaaaanoooooouuuysaaaaaaaceeeeiiiinooooouuuyyyRr'))
    );

    $trans = array(
        '&\#\d+?;'       => '',
        '&\S+?;'         => '',
        '\s+'            => $replace,
        '[^a-z0-9\-\._]' => '',
        $replace.'+'     => $replace,
        $replace.'$'     => $replace,
        '^'.$replace     => $replace,
        '\.+$'           => ''
    );
    $str = strip_tags($str);
    $str = str_replace('.', '' , $str);
	$str = str_replace(':', '' , $str);
    foreach ($trans as $key => $val)
    {
        $str = preg_replace("#".$key."#i", $val, $str);
    }
    if ($lowercase === TRUE)
    {
        $str = strtolower($str);
    }
    return trim(stripslashes($str));
}

//conexion
$mensaje="";
 $mes = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
  $fecha1=$mes[date('n')].",".strftime('%Y',time());
  require_once("conectar/conectar.php"); 
mysqli_select_db($base,$database);
$ed_activa= mysqli_query($base,"select * from edicion where activo=1");
$res_ed_activa=mysqli_fetch_assoc($ed_activa);

    $mes = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
  $fecha_act=$mes[date('n')].",".strftime('%Y',time());
  $fecha_act12=date("d").'/'.date('m')."/".strftime('%Y',time());
  // busca los nombres de categoria
 $fecha=$fecha_act; //edicion
 $fec_not=$fecha_act12; //fecha de noticia
 $descripcion="";
 $desc_foto="";
 $epigrafe="";
 $periodista="";
 $titulo="";
  $video="";

  $SQLrubro = "SELECT * FROM categoria order by categoria_cat asc"; 
  $res_rubro= mysqli_query($base,$SQLrubro)or die(mysqli_error()); 
     
 
?> 
<SCRIPT>   
//array a java
function confirma()
    {
	    if (confirm("Usted va añadir lo siguiente: \n La Edición: "+document.forms[0].elements[0].value+"\n ¿Esta seguro de continuar?"))
		    {
	   		 return true;
	  		}
	     else
	  		{	document.forms[0].elements[0].value="";
				document.forms[0].elements[1].value="";
	  			document.forms[0].elements[0].focus();
				return false;
	  		
			}
	}
		  
	
</SCRIPT>

<?php if(isset($_POST["envia_noticia"]))
{
	$conterror=0;
	$rubro=$_POST["rubro"];
    $periodista=utf8_decode($_POST["periodista"]);
	$titulo=$_POST["titulo"];
    $epigrafe=$_POST["epigrafe"];
	$descripcion=utf8_decode($_POST["descripcion"]);
	$desc_foto=$_POST["desc_foto"];
	$relevancia=$_POST["relevancia"];
	$video=$_POST["video"];
	$fecha=$_POST["fecha"]; //edicion
	$fec_not=$_POST["fec_not"]; //fecha de noticia
	$cons="SELECT max( id_noticia ) AS cant FROM noticia";
	$res=mysqli_query($base,$cons) or die (mysqli_error()) ;
	if (mysqli_num_rows($res)>0)
	{
		$fila = mysqli_fetch_assoc($res) ;
		$num_foto=$fila['cant']+1 ;
	}
	else
	{
	    $num_foto=1; 
	}
	mysqli_free_result($res);
  	if( !(file_exists('../img/'.$fecha)))
		{
 			mkdir("../img/".$fecha);
		}

    if ($_FILES['foto']['name']!='')
 	 {
  	    $nom='../img/'.$fecha.'/foto'.$num_foto.'.jpg'; 
		$nom1='../img/'.$fecha.'/foto'.$num_foto.'-1.jpg';
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
						$img_nueva_altura1=round($img_nueva_anchura1*$alto/$ancho);
					}
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
				    $archivofoto='img/'.$fecha.'/foto'.$num_foto.'.jpg';
					$archivofoto1='img/'.$fecha.'/foto'.$num_foto.'-1.jpg';

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
		 $archivofoto="";
		 $archivofoto1="";
	 }
	if ($conterror==0)
	{
	    $query_links = "insert into noticia(titulo,descripcion, autor,foto ,rubro,relevancia,fecha,fecha_not,desc_foto,foto1, orden, titular, video) values('$titulo', '$descripcion', '$periodista', '$archivofoto','$rubro', '$relevancia', '$fecha','$fec_not','$desc_foto','$archivofoto1','1','$periodista','$video')";
		  
		$salida = mysqli_query($base,$query_links) or die(mysqli_error());
		unset($_POST["envia_noticia"]);
		
        $maximo_id = ("SELECT max(id_noticia) as maximo FROM noticia");
        $indice= mysqli_query($base,$maximo_id);
        $maximo =  mysqli_fetch_array($indice);
        $valor=$maximo["maximo"];
        $sef = url_title($titulo."-noti-".$valor);
        $sef=$sef.".html";
        $query = "UPDATE noticia SET
		          sef = '".$sef."' WHERE id_noticia = ".$valor." ";
        $res1 = mysqli_query($base, $query) or die(mysqli_error());

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
    <td width="800" align="left"><span class="Estilo2">Nueva Noticia</span></td>
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
              <th width="254" bgcolor="#DDDDDD" scope="col"><div align="right">Seccion de la Noticia : </div></th>
              <th width="396" bgcolor="#DDDDDD" scope="col"><label>
                <div align="left">
                  <label>
                  <select name="rubro" id="rubro">
				    <?php while ($fila_cat=mysqli_fetch_assoc($res_rubro))
					{
					?>
                    <option value="<?php echo $fila_cat["id_cat"];?>"><?php echo ($fila_cat["categoria_cat"]);?></option>
					<?php }
					?>
                  </select>
                  </label>
                </div>
              </label></th>
              <th width="62" scope="col">&nbsp;</th>
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
                     <option value="1" selected="selected">Sí</option>
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
              <th width="254" bgcolor="#DDDDDD" scope="col"><div align="right">Fecha Noticia </div></th>
              <th width="396" bgcolor="#DDDDDD" scope="col"><label>
                <div align="left">
                  <input value="<?php echo $fec_not;?>" name="fec_not" class="required" type="text" id="fec_not" size="55" />
                  </div>
              </label></th>
              <th width="62" scope="col">&nbsp;</th>
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
