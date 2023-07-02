<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
   <div id="suplementos" class="row">
            <?php
			$archivo = "../contador.txt"; // Archivo en donde se acumulará el numero de visitas
			$abre = fopen($archivo, "r"); // Abrimos el archivo para solamente leerlo (r de read)
			$total = fread($abre, filesize($archivo)); // Leemos el contenido del archivo(filesize "detectara" la longitud de Bytes de $archivo la cual desconocemos)
			fclose($abre); // Cerramos la conexión al archivo
			
			?>
			<div class="clearfix" style="padding: 5px 5px; text-align:center">
            <strong>Es el Visitante N°: </strong> <?php echo $total; ?>
        </div> 
   </div>
            <div id="pie" class="row">
            <!--    <div id="pie_info" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
   <!-- <p style="text-align: center; font-size: 120%; font-weight:bold;#ffa800">Año 19  - Número 223 <br> Febrero 2016</p>
	<div class="separador_h hidden-sm hidden-md col-md-12 col-lg-12"></div>
    <p style="text-align: center; font-size: 120%; margin-top:5px; font-weight:bold;">Staff LINEA OESTE</p>
    <p style="text-align: center; font-size: 90%;">Directora Propietaria: Nora B. Mestre</p>
	<p style="text-align: center; font-size: 90%;">Diseño Diagramación Ed. Impresa: Daniel Klodi</p>
	<p style="text-align: center; font-size: 90%;">Colaboradores: Lara Varela</p>
	<p style="text-align: center; font-size: 90%;">Registro Prop. Int: 5246779</p>
	<p style="text-align: center; font-size: 90%;">ISSN: 1852-768X</p>
	<p style="text-align: center; font-size: 90%;">Tirada Impresa: 7000 ejemplares</p>
</div>-->
<div id="pie_contactenos" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <h1>Cont&aacute;ctenos</h1>
    <p class="correo"><b>Correo electr&oacute;nicos:</b></p>
    <div class="items">
        lineaoeste@yahoo.com.ar
    </div>
</div>
<div id="pie_redes_sociales" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <h1>Redes Sociales</h1>
    <script type="text/javascript">
        $(function () {
            $(".social").mouseover(function () {
                var src = $(this).attr("src").match(/[^\.]+/) + "_hover.png";
                $(this).attr("src", src);
            }).mouseout(function () {
                var src = $(this).attr("src").replace("_hover", "");
                $(this).attr("src", src);
            });
        });
    </script>
    S&iacute;guenos en:<br />
    <p>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <a href="https://www.facebook.com/periodicolineaoeste" target="_blank"><img src="img/facebook_42x42.png" class="social" border="0" alt=""/></a>
		    </p>
</div>
<div id="pie_menu" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <a href="index.php?edicion=<?php echo $idEdicion; ?>">Portada</a> | 
    <a href="noticias.php?edicion=<?php echo $idEdicion; ?>">Noticias</a> | 
    <a href="agenda.php?edicion=<?php echo $idEdicion; ?>" target="_blank">Agenda</a> | 

    <a href="/contactenos.php">Contáctenos</a> 
</div>
<div class="clearfix"></div>
            </div>
</body>
</html>
