<html>
<body>
<link rel="stylesheet" type="text/css" href="../dcv8/DCV/css/screen.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="../dcv8/DCV/css/print.css" media="print" />
<!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="../dcv8/DCV/css/ie.css" media="screen, projection" />
<![endif]-->
<link rel="stylesheet" type="text/css" href="../dcv8/DCV/css/main.css" />
<link rel="stylesheet" type="text/css" href="../dcv8/DCV/css/form.css" />


<div class="container" id="page">


    <div id="header">
        <div id="logo"><a href="../dcv8/DCV/index.php">Director de Carrera Virtual</a></div>
    </div><!-- header -->
	
	<br />
	
	<h1>Revalidaciones registradas </h1> <br />
	
	<p><a href="../dcv8/DCV/index.php">Volver al Director de Carrera Virtual</a></p>
	
<?php

	require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	
	$user = $_POST['googleaccount'];
	$pass = $_POST['googlepass'];
	$documento =$_POST["documento"];
	$idcarrera =1;
	
	if(strpos($documento, "&")===false){
		$key= substr($documento , strpos($documento, "key=")+4, strlen($documento));
	}else{
		$key= substr($documento , strpos($documento, "key=")+4, strpos($documento, "&")-strpos($documento, "key=")-4);
	}
	
	$URI='https://spreadsheets.google.com/feeds/spreadsheets/'.$key;
	
	$hostname = "localhost";
	$username = "root";
	$password = "baca.lao";
	$dbname = "dcv";
	
	try{
    	$con = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
		//$con = new PDO("mysql:host=\"localhost\";dbname=\"dcv\"", $username, $password);
    }catch(PDOException $e){
		
    	echo $e->getMessage();
    }
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	
	try {  
      // connect to API
      $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
      $service = new Zend_Gdata_Spreadsheets($client);

      // get spreadsheet entry
      $ssEntry = $service->getSpreadsheetEntry($URI);
      
      // get worksheets in this spreadsheet
      $wsFeed = $ssEntry->getWorksheets();
	  
	  //se conectó exitosamente al API y a la spreadsheet.
	  //Entonces aquí despliego el mensaje de que fueron dados de alta los alumnos que aparecen en la spreadsheet
	  echo "Fueron registradas las siguientes revalidaciones:";
	  echo "<br /><br />";
	  
    } catch (Exception $e) {
      die('ERROR: ' . $e->getMessage());
    }
	
	$primero = true;
	$todos = "";
	
	//bandera para detectar si algún alumno no pudo ser agregado
	$bandera_revalidacion_no_pudo_ser_agregada = 0;
	
	//obtiene datos de la primera hoja (la única necesaria)
    $listFeed = $service->getListFeed($wsFeed[0]);
    foreach ($listFeed as $listEntry) {
    	//obtiene fila
    	$rowData = $listEntry->getCustom();
				
		$nombre_uni = utf8_decode($rowData[0]->getText());
		$clave_local = $rowData[1]->getText();
		$nombre_local = utf8_decode($rowData[2]->getText());
		$clave_cursada = $rowData[3]->getText();
		$nombre_cursada = utf8_decode($rowData[4]->getText());
		$periodo = $rowData[5]->getText();
		$anio = $rowData[6]->getText();
		$carrera = $rowData[7]->getText();
		
		//Variable para almacenar el ID de la carrera, el cual se obtendrá a continuación.
		$idcarrera = "";
		
		//obtengo el id de la carrera, a partir de las siglas de la carrera
		mysql_connect("localhost", "root", "") or die(msyqsl_error());
		mysql_select_db("dcv") or die(mysql_error());
	
		$result = mysql_query("SELECT id FROM carrera WHERE siglas LIKE '".$carrera."'");
		
		$row = mysql_fetch_array($result);
		
		if(!empty($row)){
			$idcarrera = $row['id'];
		}else{
			//la carrera no fue encontrada, entonces se rompe el ciclo
			$bandera_revalidacion_no_pudo_ser_agregada = 1;
			break;
		}
		
		mysql_free_result($result);
		
		/*
		Coloco el periodo de revalidación en el formato que requiere la tabla "Revalidación", en la base de datos:
		'Enero-Mayo', 'Verano', o bien, 'Agosto-Diciembre'
		*/
		switch($periodo){
			case "EM": $periodo = "Enero-Mayo"; break;
			case "V": $periodo = "Verano"; break;
			case "AD": $periodo = "Agosto-Diciembre"; break;
		}
		
		
    	$sql = "INSERT INTO revalidacion(universidad, clave_materia_local, nombre_materia_local, clave_materia_cursada, nombre_materia_cursada,
    								periodo_de_revalidacion, anio_de_revalidacion, idcarrera)
					   		VALUES(:universidad, :clave_materia_local, :nombre_materia_local, :clave_materia_cursada, :nombre_materia_cursada,
					   				:periodo_de_revalidacion, :anio_de_revalidacion, :idcarrera)";
			
		
		//prepara el query
		$preparedStatement = $con -> prepare($sql);
		$preparedStatement -> bindParam(':universidad', $nombre_uni);
		$preparedStatement -> bindParam(':clave_materia_local', $clave_local);
		$preparedStatement -> bindParam(':nombre_materia_local', $nombre_local);
		$preparedStatement -> bindParam(':clave_materia_cursada', $clave_cursada);
		$preparedStatement -> bindParam(':nombre_materia_cursada', $nombre_cursada);
		$preparedStatement -> bindParam(':periodo_de_revalidacion', $periodo);
		$preparedStatement -> bindParam(':anio_de_revalidacion', $anio);
		$preparedStatement -> bindParam(':idcarrera', $idcarrera);
		
		mysql_close();
		$preparedStatement -> execute();
        
        echo "Universidad = $nombre_uni <br />";
        echo "Clave de la materia local = $clave_local <br />";
		echo "Nombre de la materia local = $nombre_local <br />";
		echo "Clave de la materia cursada = $clave_cursada <br />";
		echo "Nombre de la materia cursada = $nombre_cursada <br />";
		echo "Periodo = $periodo <br />";
		echo "Año de revalidación = $anio <br />";
		echo "Id de la carrera = $idcarrera <br />";
        
        echo "<br />";
      }
	  
	  
	  if($bandera_revalidacion_no_pudo_ser_agregada == 1){
		echo "NOTA: En el documento se encontraron revalidaciones que no pudieron ser registradas debido a ambigüedad presente en las siglas de la carrera, en la columna de 'carrera'. Favor de revisar el documento.";
	  }
	  
?>

	<div id="footer">
			&copy; DCV <?php /*echo date('Y'); */?> by Direcci&oacute;n de ITC, ITESM<br/>
			Derechos Reservados.<br/>
			<?php /*echo Yii::powered(); */?>
		</div><!-- footer -->
	</div>
</body>
</html>