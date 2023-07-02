<?php 
//conexion
$mensaje="";
 $mes = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
  $fecha1=$mes[date('n')].",".strftime('%Y',time());
  require_once("conectar/conectar.php"); 
mysqli_select_db($base, $database);

  //busca el mayor valor
   $SQLquery = "SELECT id_edicion AS max_cat, edicion, fecha FROM edicion where edicion in (select max(edicion) from edicion) GROUP BY id_edicion"; 
  $resultado= mysqli_query($base,$SQLquery)or die(mysqli_error()); 
  $SQLrow = mysqli_fetch_assoc($resultado);
 //si no hay datos pone id 1 sino el mayor valor 
  if (mysqli_num_rows($resultado)<=0)
    {
	   $id_cat=1;
    }
  else
  	{
		$id_cat=$SQLrow["max_cat"]+1;
		$edicion=$SQLrow["edicion"]+1;
		$fecha=$SQLrow["fecha"];		
	}
  mysqli_free_result($resultado);
  // busca los nombres de categoria
  $SQLquery = "SELECT edicion as cat FROM edicion"; 
  $resultado= mysqli_query($base,$SQLquery)or die(mysqli_error()); 
 $i=-1;
 
 //asigna a array categ los datos
 if (mysqli_num_rows($resultado)>0)
  {
     while ($fila = mysqli_fetch_assoc($resultado)) 
      {  $i++;
     	 $categ[$i] = strtoupper($fila["cat"]);
      }
	 $i++ ;
  }
 else
  {
	  $i=1;
	  $categ[0]="";
	
  }
  mysqli_free_result($resultado);
?> 
<SCRIPT>   
//array a java
 j=<?php echo $i;?>;
if (j>0)
  {
     cat=new Array(<?php echo "'".implode("','",$categ)."'"; ?>);
	
  }

function testeoform() //valida form ya sea blanco o datos existentes
  { 
      if (document.forms[0].elements[0].value=="" || document.forms[0].elements[1].value=="")
         { 
		 	alert("Debe usted rellenar todos los campos del formulario") ;
				return false;
		 }
	  else
	    { 
	      if (j>0)
		  {
		      for (t=0;t<=(j-1);t++)
	            {
 	               if (document.forms["form1"].elements["edicion"].value==cat[t])
				   //==cat[t])
                       { 
		 	      		    alert("Ya tiene esa edición") ;
				 			document.forms[0].elements[0].value="";
			     			document.forms[0].elements[1].value="";
			     			return false;
		       			} 

		 		 }
	
					 
		   }
		 
		}
		
  }
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

<?php if(isset($_POST["envia_edicion"]))
{
	$conterror=0;
	$edicion=utf8_decode($_POST["edicion"]);
	$fecha=utf8_decode($_POST["fecha"]);
	if ($conterror==0)
		{
				
		   //$archivof='logo_p.jpg';
			$consulta="insert into edicion(edicion,fecha,activo) values('$edicion','$fecha','0')";
		   $resultado= mysqli_query($base,$consulta)or die(mysqli_error());	
		   $mensaje='Registro exitoso';
	$edicion=utf8_decode($_POST["edicion"]);
	$fecha=utf8_decode($_POST["fecha"]);
			
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
    <td width="800" align="left"><span class="Estilo2">Nueva Edición </span></td>
  </tr>
  <tr>
      <td>
	  	<?php if (($mensaje!=""))
	  	  {
  			  if ($mensaje=='Registro exitoso')
  		 		 {
				    	unset($_POST["envia_edicion"]);
		     		?>			<div align="left" class="mensaje">
									<?php echo $mensaje; ?>
								</div>
								<br />
					 <script type='text/javascript'>
					document.write('<p class="details"><a href="edicions.php">Volver a la página de inicio.</a></p>');
					</script>
					<script type='text/javascript'>
					  setTimeout('window.location="ediciones.php"', 4000);
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
              <th width="254" bgcolor="#DDDDDD" scope="col"><div align="right">Edicion: </div></th>
              <th width="396" bgcolor="#DDDDDD" scope="col"><label>
                <input value="<?php echo $edicion;?>" name="edicion" class="required" type="text" id="edicion" size="55" />
              </label></th>
              <th width="62" scope="col">&nbsp;</th>
              <th width="21" scope="col">&nbsp;</th>
            </tr>
             <tr>
              <th width="49" height="48" scope="col">&nbsp;</th>
              <th width="254" bgcolor="#DDDDDD" scope="col"><div align="right">Fecha </div></th>
              <th width="396" bgcolor="#DDDDDD" scope="col"><label>
                <input value="<?php echo $fecha1;?>" name="fecha" class="required" type="text" id="fecha" size="55" />
              </label></th>
              <th width="62" scope="col">&nbsp;</th>
              <th width="21" scope="col">&nbsp;</th>
            </tr>
			 
            <tr>
              <td height="31">&nbsp;</td>
              <td>&nbsp;</td>
              <td><label>
                <div align="right">
                  <input name="envia_edicion" type="submit"  onclick="return (testeoform())" id="envia_edicion" value="Agregar edición  &gt;&gt;" />
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
