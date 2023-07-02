
<!DOCTYPE html>
<html lang="es">
<?php 
  require_once('conectar/conectar.php');
  mysqli_select_db($base,$database);
  //para las ediciones 
  if(isset($_POST["edicion"]))
  {
     $idEdicion=$_POST["edicion"];
  }
  if(isset($_GET["edicion"]))
  {
     $idEdicion=$_GET["edicion"];
  }
  if(is_numeric($idEdicion)){


$SQLquery = "SELECT * FROM edicion where id_edicion= ".$idEdicion; 
$resultado = mysqli_query($base,$SQLquery)or die(mysqli_error()); 
$edicion=array();
   if (mysqli_num_rows($resultado)>=0)
    {  
	   $a=0;
       while ($fila = mysqli_fetch_array($resultado)) 
        {  
		$edicion["id"][$a]=$fila["id_edicion"];
		$edicion["edicion"][$a]=$fila["edicion"];
		$edicion["fecha"][$a]=$fila["fecha"];		
		$edicion["activo"][$a]=$fila["activo"];
		 $a++;
      }
	}
  mysqli_free_result($resultado);
  
     $SQLquery = "SELECT *  FROM noticia  WHERE  relevancia=1 and fecha='".$edicion["fecha"][0]."' order by orden, id_noticia"; 
   $resultado= mysqli_query($base,$SQLquery)or die(mysqli_error()); 
   
  if (mysqli_num_rows($resultado)>0)
  {
     $i=0;
	 $noticiaP=array();
     while ($fila = mysqli_fetch_array($resultado)) 
      {  
     	 $noticiaP[$i]["id"]=$fila["id_noticia"];
		 $noticiaP[$i]["titulo"] = ( ($fila["titulo"]));
		 $noticiaP[$i]["descripcion"]=( $fila["descripcion"]);
		 $noticiaP[$i]["autor"]=( $fila["autor"]);
		 $noticiaP[$i]["foto"]=$fila["foto"];
		 $noticiaP[$i]["foto_1"]=$fila["foto1"];
		 $noticiaP[$i]["rubro"]=$fila["rubro"];
		 $noticiaP[$i]["relevancia"]=$fila["relevancia"];
		 $noticiaP[$i]["fecha"]=$fila["fecha"];
		 $noticiaP[$i]["fecha_not"]=$fila["fecha_not"];		 
		 $noticiaP[$i]["desc_foto"]=($fila["desc_foto"]);
		 $i++;
      }
  }
  else{$i=0;}
   mysqli_free_result($resultado);
   
    $SQLquery = "SELECT *  FROM noticia  WHERE  relevancia<>1 and fecha='".$edicion["fecha"][0]."' order by orden, id_noticia"; 
   $resultado= mysqli_query($base,$SQLquery)or die(mysqli_error()); 
   
  if (mysqli_num_rows($resultado)>0)
  {
     $j=0;
	 $noticia=array();
     while ($fila = mysqli_fetch_array($resultado)) 
      {  
     	 $noticia[$j]["id"]=$fila["id_noticia"];
		 $noticia[$j]["titulo"] = ( ($fila["titulo"]));
		 $noticia[$j]["descripcion"]=( $fila["descripcion"]);
		 $noticia[$j]["autor"]=( $fila["autor"]);
		 $noticia[$j]["foto"]=$fila["foto"];
		 $noticia[$j]["foto_1"]=$fila["foto1"];
		 $noticia[$j]["rubro"]=$fila["rubro"];
		 $noticia[$j]["relevancia"]=$fila["relevancia"];
		 $noticia[$j]["fecha"]=$fila["fecha"];
		 $noticia[$j]["fecha_not"]=$fila["fecha_not"];		 
		 $noticia[$j]["desc_foto"]=($fila["desc_foto"]);
		 $j++;
      }
  }
  else{$j=0;}
   mysqli_free_result($resultado);
}else{
//edicion con valor no numerico
header('Location: http://www.lineaoeste.com.ar/noticias.php');
}   
/*  print_r($edicion);
    print_r($noticia);*/
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <title>Línea Oeste</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="title" content="Línea Oeste"/><meta name="keywords" content="Línea Oeste"/>            
        <meta name="robots" content="index,follow"/><meta name="author" content="Línea Oeste"/><link href="/favicon.ico" type="image/x-icon" rel="icon"/><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon"/>        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
        <meta property="og:locale" content="es_ES"/><meta property="og:type" content="website"/><meta property="og:site_name" content="Línea Oeste"/><link rel="stylesheet" type="text/css" href="css/bootstrap.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css"/><link rel="stylesheet" type="text/css" href="css/rootcode.oeste.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/backtotop.min.css"/><link rel="stylesheet" type="text/css" href="css/cd-tabs.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/colorbox.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/twitmarquee.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css"/><script type="text/javascript" src="js/jquery.min.js"></script><script type="text/javascript" src="js/bootstrap.min.js"></script><script type="text/javascript" src="js/cd-tabs.min.js"></script><script type="text/javascript" src="js/jquery.colorbox.min.js"></script><script type="text/javascript" src="js/devian.scripts.min.js?v=1.9.8"></script><script type="text/javascript" src="js/twitmarquee.min.js"></script><script type="text/javascript" src="js/jquery.fancybox.pack.js"></script><script type="text/javascript" src="js/backtotop.min.js"></script><script type="text/javascript" src="js/ie-10-view-port.min.js"></script>        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- Social tools -->
        <div id="fb-root"></div>
       <!-- <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.3&appId=951516094899229";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <script src="https://apis.google.com/js/platform.js" async defer>{lang: 'es'}</script>-->
<div class="container">
<!--            <div id="publicidad_superior" class="row">
                <img src="img/publicidad/banner_horizontal_superior.jpg" class="img-responsive center-block" alt=""/>            </div>-->
   <div id="cabecera" class="row">
   <?php
$contadorVisita="Portada";
      include("arriba.php");
   ?>

    <!-- Marquesina de últimas notas -->
    <div id="marquee_notas">
        <div id="trends">
            <div class="inner">
                <ul class="trendscontent">
                         <?php 
						      for ($m=0;$m<$i;$m++)
							  {
						  ?>
						         <li>                            
                                   <a href="noticia.php?edicion=<?php echo $idEdicion;?>&id=<?php echo $noticiaP[$m]["id"];?>">
								         <?php echo $noticiaP[$m]["titulo"];?>  
									</a>
			                      </li>
                          <?php 
						  	  }
						  ?>
                                    </ul>
                <div class="clear"></div>
            </div>
            <span class="fade fade-left">&nbsp;</span><span class="fade fade-right">&nbsp;</span>
        </div>
        <script type="text/javascript">
            //<![CDATA[
            var page = {};
            $(function () {
                new FrontPage().init();
            });
            //]]>
        </script>
    </div>
    <div class="clearfix"></div>
            </div>
            
            <div id="contenido" class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
<div id="portada" class="row">
    <div class="columna_i col-sm-12 col-md-12 col-lg-12">
        <div class="row">
           <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="nota">
                  <h5></h5>
                  <h1><a href="noticia.php?edicion=<?php echo $idEdicion;?>&id=<?php echo $noticiaP[0]["id"];?>">
				          <?php echo $noticiaP[0]["titulo"];
						   //Cómo afectará a los Porteños la Reducción del subsidio a la energía electrica 
						   ?>
						</a>
				   </h1>
				   <a href="noticia.php?edicion&<?php echo $idEdicion;?>id=<?php echo $noticiaP[0]["id"];?>">
				          
						  <img src="../<?php echo $noticiaP[0]["foto"]; ?>" alt="<?php echo utf8_encode($noticiaP[0]["titulo"]); ?>" class="img-responsive img-rounded">
						  
					</a>
				   
				   
                   <div class="fecha-version">
                        <div class="fecha"><?php echo $noticiaP[0]["fecha_not"]; ?></div>
                   </div>
                   <div class="intro">
				         <?php echo substr(strip_tags($noticiaP[0]["descripcion"]),0,200)."...";?>
				   </div>
			       <div class="otras_notas col-sm-12 col-md-12 col-lg-12">
                            <a href="noticia.php?edicion=<?php echo $idEdicion;?>&id=<?php echo $noticiaP[0]["id"];?>" class="mas">Ver más</a>                   </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                 <div class="borde_naranja"></div>
            </div>
           <?php 
			for ($m=1;$m<$i;$m++)
			  {
			?>
		    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                   <div class="nota center-block">
                         <h4><a href="noticia.php?edicion=<?php echo $idEdicion;?>&id=<?php echo $noticiaP[$m]["id"];?>"><?php echo $noticiaP[$m]["titulo"];?></a></h4>
                         <a href="noticia.php?edicion=<?php echo $idEdicion;?>&id=<?php echo $noticiaP[$m]["id"];?>">
						     <img src="../<?php echo $noticiaP[$m]["foto"];?>" class="img-rounded img-responsive" alt="<?php echo utf8_encode($noticiaP[$m]["titulo"]);?>"/>
						 </a>            
						 <div class="fecha-version">
                              <div class="fecha">     <?php echo ($noticiaP[$m]["fecha_not"]);?>              </div>
                              <div class="version"> </div>
                         </div>
                         <div class="intro">
						     <?php echo substr(strip_tags($noticiaP[$m]["descripcion"]),0,160)."...";?>
						 </div>
			             <div class="otras_notas col-sm-12 col-md-12 col-lg-12">
                            <a href="noticia.php?edicion=<?php echo $idEdicion;?>&id=<?php echo $noticiaP[$m]["id"];?>" class="mas">Ver más</a>                          </div>
                   </div>
             </div>
    
			<?php 
			
			}
			 ?>	
		
		</div>       
	
	               <div class="seccion">
                    <h1>Noticias</h1>
                        <div class="row">
							<div class="otras_notas col-sm-12 col-md-12 col-lg-12">
								<ul>
									<?php 
						    		  if($j>5) $cant=5; else $cant=$j;
									  for ($m=0;$m<$cant;$m++)
							  			{
						  			?>
									<li ><a href="noticia.php?edicion=<?php echo $idEdicion;?>&id=<?php echo $noticia[$m]["id"];?>"><?php echo utf8_encode($noticia[$m]["titulo"]);?></a></li>
									
									<?php 
						    			}
									?>
								 </ul>
								 <a href="noticias.php?edicion=<?php echo $idEdicion;?>" class="mas">Ver más notas</a>                      
							  </div>
                         </div>
                    </div>
             </div>
    		<!--<div class="columna_m col-sm-12 col-md-3 col-lg-3">
				<div class="seccion">
					<h1>Deporte</h1>
                    <div class="row">
                         <div class="nota_s_m col-sm-6 col-md-12 col-lg-12">
                             <h4><a href="/deporte/20160305_fierro-se-suma--a-la-lista-de-bajas-en-universitario.html">Fierro se suma  a la lista de bajas en Universitario</a></h4>
                                    <a href="/deporte/20160305_fierro-se-suma--a-la-lista-de-bajas-en-universitario.html" style="display:block;margin:0;padding:0;">
									<img src="img/notas/20160305/nota27805_imagen0_x4.jpg" class="img-responsive img-rounded center-block" alt=""/></a>                                    <div class="fecha-version">
                                        <div class="fecha">05 Mar 2016</div>
                                        <div class="version">Edición Impresa</div>
                                    </div>
                                    <div class="intro">Tras evaluaciones complementarias, se confirmó la baja del delantero de Universitario Juan Eduardo Fierro para visitar mañana, domingo, a Nacional Potosí, en la Villa Imperial.</div>
                          </div>
                          <div class="separador_h hidden-sm hidden-md col-md-12 col-lg-12"></div>
                    </div>
                 </div>
            </div>-->
</div>
                </div>
<div class="lateral col-xs-12 col-sm-4 col-md-4 col-lg-4">
<?php include ("lateral.php");
?>
 </div>
  <div class="row clearfix"></div>
            </div>
<?php 

include ("abajo.php");
?>
        </div>
                <a href="#" class="back-to-top"></a>
            </body>
</html>
