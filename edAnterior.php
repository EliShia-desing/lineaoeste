
<!DOCTYPE html>
<html lang="es">
<?php 
  require_once('conectar/conectar.php');
  mysql_select_db($database,$base);
  
     $SQLquery = "SELECT n.foto, e . * 
FROM  `edicion` AS e
INNER JOIN noticia AS n ON e.fecha = n.fecha
WHERE n.foto <>  ''
GROUP BY n.fecha
ORDER BY e.edicion DESC , n.relevancia, n.orden"; 
   $resultado= mysql_query($SQLquery,$base)or die(mysql_error()); 
   
  if (mysql_num_rows($resultado)>0)
  {
     $i=0;
	 $noticiaP=array();
     while ($fila = mysql_fetch_array($resultado)) 
      {  
     	 $noticiaP[$i]["foto"]=$fila["foto"];
		 $noticiaP[$i]["id_edicion"] = ( ($fila["id_edicion"]));
		 $noticiaP[$i]["edicion"]=( $fila["edicion"]);
		 $noticiaP[$i]["fecha"]=( $fila["fecha"]);
		 $noticiaP[$i]["anio"]=$fila["anio"];
		 $i++;
      }
  }
  else{$i=0;}
   mysql_free_result($resultado);
   
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <title>Línea Oeste</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="title" content="Línea Oeste"/><meta name="keywords" content="Línea Oeste"/>            <meta http-equiv="refresh" content="600;URL='http://lineaoeste.com.ar"/>
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
$contadorVisita="EdAnterior";
      include("arriba.php");
   ?>

    <div class="clearfix"></div>
            </div>
            
            <div id="contenido" class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
<div id="portada" class="row">
    <div class="columna_i col-sm-12 col-md-12 col-lg-12">
        <div class="row">
           <?php 
			for ($m=0;$m<$i;$m++)
			  {
			?>
		    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                   <div class="nota center-block">
                         <h4><a href="edAnterior/?edicion=<?php echo $noticiaP[$m]["id_edicion"];?>"><?php echo ($noticiaP[$m]["fecha"]);?></a></h4>
                         <a href="edAnterior/?edicion=<?php echo $noticiaP[$m]["id_edicion"];?>">
						     <img src="<?php echo $noticiaP[$m]["foto"];?>" class="img-rounded img-responsive" alt=""/>
						 </a>            
                   </div>
             </div>
    		<?php
			if (($m+1)%3==0){
			?>
				<div class="col-sm-12 col-md-12 col-lg-12">
                	 <div class="borde_naranja"></div>
            	</div>
			<?php
			}	
			 
			
			}
			 ?>	
		    
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
