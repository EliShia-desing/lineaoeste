<?php
  require_once('conectar/conectar.php');
  mysql_select_db($database,$base);
  //para las ediciones 
$SQLquery = "SELECT * FROM edicion where activo=1 "; 
$resultado = mysql_query($SQLquery,$base)or die(mysql_error()); 
$edicion=array();
   if (mysql_num_rows($resultado)>=0)
    {  
	   $a=0;
       while ($fila = mysql_fetch_array($resultado)) 
        {  
		$edicion["id"][$a]=$fila["id_edicion"];
		$edicion["edicion"][$a]=$fila["edicion"];
		$edicion["fecha"][$a]=$fila["fecha"];		
		$edicion["activo"][$a]=$fila["activo"];
		 $a++;
      }
	}
  mysql_free_result($resultado);
  if(isset($_POST["id"]))
  {
     $id=$_POST["id"];
  }
  if(isset($_GET["id"]))
  {
     $id=$_GET["id"];
  }
  if(is_numeric($id)){
     $SQLquery = "SELECT *  FROM noticia  WHERE id_noticia='".$id."' and  fecha='".$edicion["fecha"][0]."' order by relevancia, orden, id_noticia"; 
     $resultado= mysql_query($SQLquery,$base)or die(mysql_error()); 
     if (mysql_num_rows($resultado)>0)
     {
		 $i=0;
		 $noticiaP=array();
		 while ($fila = mysql_fetch_array($resultado)) 
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
			 $noticiaP[$i]["sef"]=($fila["sef"]);

 			 $sqlFotos="SELECT *  FROM fotos WHERE noticia='".$id."'  order by id";
			 $resFotos= mysql_query($sqlFotos,$base)or die(mysql_error());

			 $fotos=array();
			 $ii=0;
			 while ($filaFoto = mysql_fetch_array($resFotos)) 
		  	{  
			 	$fotos[$ii]["link"]=$filaFoto["foto"];
			 	$fotos[$ii]["descripcion"] = ( ($filaFoto["descripcion"]));
				$ii++;
			 }

			 $i++;
		  }
  	 }
  	else{
     header('Location: http://www.lineaoeste.com.ar/noticias.php');
  	}
    mysql_free_result($resultado);
 }
 else{ //si no es numérico redirecciono a noticias
 header('Location: http://www.lineaoeste.com.ar/noticias.php');

 }
   ?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <title>Línea Oeste</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="title" content="Línea Oeste"/><meta name="keywords" content="Línea Oeste"/>            <meta http-equiv="refresh" content="600;URL='http://lineaoeste.com.ar"/>
            <meta name="robots" content="index,follow"/><meta name="author" content="Línea Oeste"/><link href="/favicon.ico" type="image/x-icon" rel="icon"/><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon"/>        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
        <link rel="canonical" href="http://www.lineaoeste.com.ar/<?php echo $noticiaP[0]["sef"]  ;?>">

        <meta property="og:locale" content="es_ES"/>
        <meta property="og:type" content="website"/>
        <meta property="og:site_name" content="Línea Oeste"/>
        <meta property="og:title" content="<?php echo utf8_encode($noticiaP[0]["titulo"]);?>">
        <meta property="og:description" content="<?php echo substr(strip_tags(utf8_encode($noticiaP[0]["descripcion"])),0,200); ?>">
	    <meta property="og:image" content="http://lineaoeste.com.ar/<?php echo utf8_encode($noticiaP[0]["foto"]);?>">
	     <meta property="og:url" content="http://lineaoeste.com.ar/<?php echo ($noticiaP[0]["sef"]);?>">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css?v=1.9.8"/>
        <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css"/><link rel="stylesheet" type="text/css" href="css/rootcode.oeste.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/backtotop.min.css"/><link rel="stylesheet" type="text/css" href="css/cd-tabs.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/colorbox.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/twitmarquee.min.css?v=1.9.8"/><link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css"/><script type="text/javascript" src="js/jquery.min.js"></script><script type="text/javascript" src="js/bootstrap.min.js"></script><script type="text/javascript" src="js/cd-tabs.min.js"></script><script type="text/javascript" src="js/jquery.colorbox.min.js"></script><script type="text/javascript" src="js/devian.scripts.min.js?v=1.9.8"></script><script type="text/javascript" src="js/twitmarquee.min.js"></script><script type="text/javascript" src="js/jquery.fancybox.pack.js"></script><script type="text/javascript" src="js/backtotop.min.js"></script><script type="text/javascript" src="js/ie-10-view-port.min.js"></script>        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    	<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.0';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
        <!-- Social tools -->
        
        <div class="container">
<!--            <div id="publicidad_superior" class="row">
                <img src="img/publicidad/banner_horizontal_superior.jpg" class="img-responsive center-block" alt=""/>            </div>-->
            <div id="cabecera" class="row">
			
			        <?php
$contadorVisita="Noticias";
      include("arriba.php");
   ?>
    <div class="clearfix"></div>
    </div>
            
    <div id="contenido" class="row">
    	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<script type="text/javascript">
				$(document).ready(function() {
					$('.ocultar').css({display:'none'});
					$('.img_nota').colorbox({rel:'img_nota'});
					
					$('#aumentar-texto').click(function(){
						zoomText('aumentar', 'texto-nota');
					});
					$('#disminuir-texto').click(function(){
						zoomText('disminuir', 'texto-nota');
					});
					$("#imprimir").click(function(){
						imprimir('http://correodelsur.com/notas/imprimir/27957');
					});
				});
			</script>
		<div class="row">
    		<div id="ver_nota">
				<a name="ver-nota"></a>
				<h5></h5>
				<h1><?php echo utf8_encode($noticiaP[0]["titulo"]);?></h1>
				<div class="info">
					<?php echo ($noticiaP[0]["fecha_not"]);?><span class="fuente"></span>
						<div class="pull-right hidden-xs">
							Tamaño de texto: 
							<a href="#ver-nota" title="Aumentar tamaño de texto" id="aumentar-texto">A+</a>                
							<a href="#ver-nota" title="Disminuir tamaño de text" id="disminuir-texto">A-</a>            
						</div>
				</div>
        		<div class="texto col-xs-12 col-sm-12 col-md-12 col-lg-12">
                	<div class="imagen">
						<a href="<?php echo ($noticiaP[0]["foto_1"]);?>" class="img_nota zoom  hidden-xs hidden-sm cboxElement" title="<?php echo utf8_encode($noticiaP[0]["titulo"]);?>"></a>
						<img src="<?php echo ($noticiaP[0]["foto"]);?>" alt="<?php echo utf8_encode($noticiaP[0]["titulo"]);?>" title="<?php echo utf8_encode($noticiaP[0]["titulo"]);?>" class="foto img-responsive">                
						<p>
							<?php echo ($noticiaP[0]["desc_foto"]);?>        </p>
					</div>
                    <div id="texto-nota" class="cuerpo" style="font-size: 100%;">
            			<?php echo ($noticiaP[0]["descripcion"]);?>
					</div>
					<div align="right" style="text-align:right; font-weight:bold">
						<?php echo ($noticiaP[0]["autor"]);?>
					</div>
                <div>
					
					<div>
				<?php
					if (count($fotos)>0)
					{
				?>
					<script src="slider/bjqs.min.js"></script>
        			<script src="slider/script.js"></script>
								
					<!-- Start WOWSlider.com BODY section -->
					<link rel="stylesheet" type="text/css" href="slider/estilos.css">
					<!-- SLIDESHOW -->
				 
					<div id="slider">
						<ul class="bjqs">
							<?php
							$wows=0;
							foreach($fotos as $item)
							{
							?>
							<li>
								<img src="/<?php echo $item["link"];?>" alt="" title="<?php echo utf8_encode($item["descripcion"]);?>" />
							</li>
							<?php
								  $wows++;
							}
							
							if ($noticiaP[0]["foto"]!="")
							
							{
							?>
							<li>
								<img src="/<?php echo $noticiaP[0]["foto"];?>" alt="" title="<?php echo utf8_encode($item["desc_foto"]);?>" />
							</li>
							<?php
							}
							
						?>
							
						 </ul>
					</div>
				 
    				<!-- FIN SLIDESHOW -->
				<?php
					}
				?>
<br>
					</div>						
				</div>
			</div>
		</div>
		<div class="row">
		    <div style="float: left;  margin-right: 15px;">
	              <div class="fb-share-button" 
				    data-href="http://www.lineaoeste.com.ar/<?php echo $noticiaP[0]["sef"]  ;?>" 
				    data-layout="button" data-size="small" data-mobile-iframe="true" >
				   <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.lineaoeste.com.ar%2F<?php echo $noticiaP[0]["sef"]  ;?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a>
				  </div> 
		    </div>
			<div style="float: left; position: relative;" >
			  	<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-url="http://www.lineaoeste.com.ar/<?php echo $noticiaP[0]["sef"]  ;?>" data-text="<?php echo utf8_encode($noticiaP[0]["titulo"])  ;?>" data-show-count="false">Compartir</a>
			</div>	
		</div>
		<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
      
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