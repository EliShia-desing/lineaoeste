<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<?php
function url_title($str, $separator = 'dash', $lowercase = FALSE) {
    if ($separator == 'dash') {
            $search         = '_';
            $replace        = '-';
    }
    else {
            $search         = '-';
            $replace        = '_';
    }
    $str = (strtolower(strtr(($str), 
	('ÀÁÂÃÄÅÑÒÓÔÕÖÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöùúûýýÿRr'), 
	 'aaaaaanoooooouuuysaaaaaaaceeeeiiiinooooouuuyyyRr')));

    $trans = array(
        '&\#\d+?;'                              => '',
        '&\S+?;'                                => '',
        '\s+'                                   => $replace,
        '[^a-z0-9\-\._]'                => '',
        $replace.'+'                    => $replace,
        $replace.'$'                    => $replace,
        '^'.$replace                    => $replace,
        '\.+$'                                  => ''
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

if (isset ($_POST["enviar"])){
	$tabla= $_POST["tabla"];
	if ($tabla!="0"){
	
		echo " Realizando la creacion de sef para la tabla  . .........".$tabla."<br>";
		
		 $atables=array('noticia' => 'titulo',
		 				'edicion' => 'edicion'
				);
		 $atables1=array('noticia' => '.html',
				'edicion' => ''
		);

		require_once('conectar/conectar.php'); 
		mysql_select_db($database, $base);

		$query = "SELECT id_".$tabla.", ".$atables[$tabla]." FROM ".$tabla;
		
		$res = mysql_query($query, $base) or die(mysql_error());
		$adic="";
		if($tabla=="noticia"){
			$adic="-noti-";
		}
		elseif($tabla=="edicion"){
			$adic="edicion-";
		}
		while ($data = mysql_fetch_array($res)) 
        {  

				echo "<br>".$data[$atables[$tabla]]." &nbsp;&nbsp; &nbsp; &nbsp; ";
				
				if ($tabla =="noticia"){
					$sef = url_title($data[$atables[$tabla]].$adic.$data['id_'.$tabla]);
				}
				else{
					$sef = url_title($adic.$data['id_'.$tabla]);
				}
				$sef=$sef.$atables1[$tabla]; 
				echo $sef."<br>";
				/*// Guardamos en explora_sefs; para evitar que hay seft duplicados entre varias entidades
				$query = "
						REPLACE INTO explora_sefs
						(type, id, sef)
						VALUES
						('".$aTables[$i]['type']."', ".$data['id'].", '".$sef."' ) ";
				//pr($query); die;
				DB::getInstance()->update($query);
7*/
				$query = "
						UPDATE ".$tabla." SET
						sef = '".$sef."'
						WHERE id_".$tabla." = ".$data['id_'.$tabla]." ";
				$res1 = mysql_query($query, $base) or die(mysql_error());

		}
                

	}
	unset ($_POST["enviar"]);
}
?>

</head>

<body>

elija la tabla a crear el sef 
<form action="" method="post">
<select name="tabla">
  <option value="0" selected="selected">elija</option>
  <option value="noticia">Noticia</option>
  <option value="edicion">Edicion</option>
</select>
<input name="enviar" type="submit" value="enviar" />
</form>
</body>
</html>
