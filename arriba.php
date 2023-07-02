<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    </head>
	<body>
      <div id="menu_superior">
          <div class="pull-left hidden-xs">
               <?php 
			       $diaSemana= array (0=>"--", 1=>"Lunes",2=>"Martes",3=>"Miércoles",4=>"Jueves",5=>"Viernes",6=>"Sábado",7=>"Domingo");
				   $meses = array (0=>"--", 1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre");
				   echo $diaSemana[date("N")].", ".date("d"). " de ".$meses[date("n")]." de ".date("Y")  ?> </div>
          <div class="pull-right">
                <a href="/">&gt; Portada</a>
				<a href="noticias.php">&gt; Noticias</a>
				<a href="agenda.php" target="_blank" class="hidden-xs">&gt; Agenda</a>
				<a href="edAnterior.php" class="lnk_publicidad hidden-xs" title="Ediciones Anteriores de Línea Oeste">&gt; Ediciones Anteriores</a>
				<a href="contactenos.php">&gt; Contáctenos</a>    
			</div>
          <div class="clearfix"></div>
     </div>
     <script type="text/javascript">
       //  $('.lnk_publicidad').colorbox({rel: 'lnk_publicidad', frame: true, width: "980", height: "640"});
     </script>
     <!-- Columnas: Logo, Clima, Búsqueda, Redes Sociales -->
       <div class="row logoPrin">
	        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
		        <a href="/" title="Línea Oeste"><img src="img/logo1.png" class="img-responsive center-block" alt="Linea Oeste"/></a>
			</div>
	<!--<div class="col-sm-3 col-md-3 col-lg-3" style="padding: 10px 0;text-align: center;">
		<!--<div id="weather"></div><br />-->
	<!--</div>
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 10px 10px 5px 10px;text-align: center;">
    	<form action="/buscador" id="busqueda" method="get" accept-charset="utf-8"><input type="hidden" name="buscar" value="si" id="BusquedaBuscar"/><input name="texto" placeholder="buscar..." type="text" id="BusquedaTexto"/></form>    
		<div class="hidden-xs">
        	<a href="https://www.facebook.com/correodelsurcom" target="_blank">
				<img src="img/social/Facebook.png" style="margin:0 5px;" alt=""/></a>
			<a href="https://twitter.com/correodelsurcom" target="_blank"><img src="img/social/Twitter.png" style="margin:0 5px;" alt=""/></a>
			<a href="https://www.youtube.com/c/CorreodelSurDigital" target="_blank"><img src="img/social/YouTube.png" style="margin:0 5px;" alt=""/></a>    
		</div>
	</div>-->
</div>	
<div class="clearfix"></div>
<!-- Menú de navegación -->
<div id="menu_principal" class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
	<!--menu flotante-->
        <a href="/" class="navbar-brand hidden">Línea Oeste</a>        
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
		       <span class="sr-only">Toggle navigation</span>
			   <span class="icon-bar"></span><span class="icon-bar">
			   </span><span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse navbar-menubuilder">
        <div class="container">
            <ul class="nav navbar-nav navbar-left">
				<?php if($contadorVisita=="Portada") {$menuActivo="active";}
			      else $menuActivo="";?>
                <li class="<?php echo $menuActivo;  ?>">
				   <a href="/">Inicio</a></li>
				<?php if($contadorVisita=="Quienes") {$menuActivo="active";}
			      else $menuActivo="";?>	   
				<li class="<?php echo $menuActivo;  ?>">
				   <a href="quienes.php">Qui&eacute;nes Somos</a></li>
				<?php if($contadorVisita=="Noticias") {$menuActivo="active";}
			      else $menuActivo="";?>	   
				<li class="<?php echo $menuActivo;  ?>">
				   <a href="noticias.php">Noticias</a></li>
				
				<?php if($contadorVisita=="Agenda") {$menuActivo="active";}
			      else $menuActivo="";?>	   
				<li class="<?php echo $menuActivo;  ?>">
				   <a href="agenda.php">Agenda</a></li>
				<?php if($contadorVisita=="Arte") {$menuActivo="active";}
			      else $menuActivo="";?>	   
				<li class="<?php echo $menuActivo;  ?>">
				   <a href="arte.php">Arte y Cultura</a></li>
				
				<?php if($contadorVisita=="EdAnterior") {$menuActivo="active";}
			      else $menuActivo="";?>	   
				<li class="<?php echo $menuActivo;  ?>">
					<a href="edAnterior.php">Ed. Anteriores</a></li>     
			</ul>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var menu = $('#menu_principal');
        var origOffsetY = menu.offset().top;

        function scroll() {
            if ($(window).scrollTop() >= origOffsetY) {
                $('#menu_principal').addClass('navbar-fixed-top');
                $('.navbar-brand').removeClass('hidden');

            } else {
                $('#menu_principal').removeClass('navbar-fixed-top');
                $('.navbar-brand').addClass('hidden');
            }
        }
        document.onscroll = scroll;

        /*El clima*/
//        $.simpleWeather({
//            location: 'Sucre, BO',
//            woeid: '',
//            unit: 'c',
//            success: function (weather) {
//                html = '<h2><i class="icon-' + weather.code + '"></i> ' + weather.temp + '&deg;' + weather.units.temp + '</h2> <br><p> Sucre - Bolivia</p>';
//
//                $("#weather").html(html);
//            },
//            error: function (error) {
//                $("#weather").html('<p>' + error + '</p>');
//            }
//        });
    });
</script>
</body>
