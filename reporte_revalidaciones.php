<html>
<body>
<link rel="stylesheet" type="text/css" href="../css/screen.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="../css/print.css" media="print" />
<!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="../css/ie.css" media="screen, projection" />
<![endif]-->
<link rel="stylesheet" type="text/css" href="../css/main.css" />
<link rel="stylesheet" type="text/css" href="../css/form.css" />


<div class="container" id="page">

    <div id="header">
        <div id="logo"><a href="../index.php">Direcci&oacute;n de Carrera Virtual</a></div>
    </div><!-- header -->
	
	<br />
	
	<h1>Revalidaciones registradas </h1> <br />
	
	<p><a href="../index.php">Volver a la Direcci&oacute;n de Carrera Virtual</a></p>
	
<?php

	// Clases de Zend Framework requeridas
	require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	
	// Almacena el nombre de usuario de la cuenta de Google.
	$user = $_POST['googleaccount'];
	
	// Almacena la contraseña de la cuenta de Google.
	$pass = $_POST['googlepass'];
	
	// Almacena el URL del documento (hoja de cálculo) de Google Drive.
	$documento =$_POST["documento"];
	
	// Obtiene la llave para identificar al documento (hoja de cálculo) de Google Drive.
	if(strpos($documento, "&")===false){
		$key= substr($documento , strpos($documento, "key=")+4, strlen($documento));
	}else{
		$key= substr($documento , strpos($documento, "key=")+4, strpos($documento, "&")-strpos($documento, "key=")-4);
	}
	
	// Construye el URL para identificar al documento de Google Drive.
	$URI='https://spreadsheets.google.com/feeds/spreadsheets/'.$key;
	
	// Credenciales para conectarse a la base de datos
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$dbname = "dcv";
	
	// Intenta establecer una conexión con la base de datos. En caso de fallar, se despliega un
	// mensaje con una descripción del error.
	try{
	
    	$con = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
		
    }catch(PDOException $e){
		
    	echo $e->getMessage();
    }
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	
	// Intenta conectarse con el API de Zend Framework y con el documento (hoja de cálculo) de
	// Google Drive. En caso de fallar, se despliega un mensaje con una descripción del error.
	try {  
      
	  // Establece la conexión con el API de Zend Framework
      $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
      $service = new Zend_Gdata_Spreadsheets($client);

	  // Obtiene el registro que corresponde al documento (hoja de cálculo) de Google Drive.
      $ssEntry = $service->getSpreadsheetEntry($URI);
      
	  // Obtiene las hojas dentro del documento (hoja de cálculo) de Google Drive.
      $wsFeed = $ssEntry->getWorksheets();
	  	  
	  // La conexión con el API y con el documento (hoja de cálculo) fue exitosa. Se despliega un mensaje para avisar que
	  // las revalidaciones fueron registradas.
	  echo "Fueron registradas las siguientes revalidaciones:";
	  echo "<br /><br />";
	  
    } catch (Exception $e) {
      die('ERROR: ' . $e->getMessage());
    }
		
	// Bandera para determinar si alguna revalidación no pudo ser registrada
	$bandera_revalidacion_no_pudo_ser_agregada = 0;
	
	// Obtiene los datos de la primera hoja del documento (la única hoja necesaria).
    $listFeed = $service->getListFeed($wsFeed[0]);
	
	// Registra cada revalidación del documento (hoja de cálculo) en la base de datos.
    foreach ($listFeed as $listEntry) {

		// Variable para almacenar los datos de cada fila del documento
    	$rowData = $listEntry->getCustom();
		
		// Variables para almacenar los datos de cada revalidación.
		$nombre_uni = utf8_decode($rowData[0]->getText());
		$clave_local = $rowData[1]->getText();
		$nombre_local = utf8_decode($rowData[2]->getText());
		$clave_cursada = $rowData[3]->getText();
		$nombre_cursada = utf8_decode($rowData[4]->getText());
		$periodo = $rowData[5]->getText();
		$anio = $rowData[6]->getText();
		$carrera = $rowData[7]->getText();
		
		// Variable para almacenar el ID de la carrera en la que se realizó la revalidación.
		$idcarrera = "";
		
		// Establece la conexión con el servidor.
		mysql_connect("localhost", "root", "") or die(msyqsl_error());
		
		// Selecciona la base de datos.
		mysql_select_db("dcv") or die(mysql_error());
	
		// Sentencia de SQL para obtener el ID de la carrera en la que se registró la revalidación.
		$result = mysql_query("SELECT id FROM carrera WHERE siglas LIKE '".$carrera."'");
		
		// Obtiene el resultado de la sentencia de SQL.
		$row = mysql_fetch_array($result);
		
		// Valida si la variable $row no está vacía. Es decir, si se encontró la carrera en la que
		// se realizó la revalidación. Si la carrera no se encontró, se detiene el proceso de registro de las
		// revalidaciones en la base de datos.
		if(!empty($row)){
			$idcarrera = $row['id'];
		}else{
		
			// Se activa la bandera para indicar que la revalidación no pudo ser agregada y
			// se detiene el ciclo.
			$bandera_revalidacion_no_pudo_ser_agregada = 1;
			break;
		}
		
		// Libera la variable $result.
		mysql_free_result($result);
		
		// Establece el periodo en el que se realizó la revalidación, en el formato requerido en la base de datos.
		switch($periodo){
			case "EM": $periodo = "Enero-Mayo"; break;
			case "V": $periodo = "Verano"; break;
			case "AD": $periodo = "Agosto-Diciembre"; break;
		}
		
		// Sentencia de SQL para insertar en tabla "revalidaciones" la revalidación actual.
    	$sql = "INSERT INTO revalidacion(universidad, clave_materia_local, nombre_materia_local, clave_materia_cursada, nombre_materia_cursada,
    								periodo_de_revalidacion, anio_de_revalidacion, idcarrera)
					   		VALUES(:universidad, :clave_materia_local, :nombre_materia_local, :clave_materia_cursada, :nombre_materia_cursada,
					   				:periodo_de_revalidacion, :anio_de_revalidacion, :idcarrera)";
			
		
		// Prepara la sentencia de SQL a ejecutar.
		$preparedStatement = $con -> prepare($sql);
		$preparedStatement -> bindParam(':universidad', $nombre_uni);
		$preparedStatement -> bindParam(':clave_materia_local', $clave_local);
		$preparedStatement -> bindParam(':nombre_materia_local', $nombre_local);
		$preparedStatement -> bindParam(':clave_materia_cursada', $clave_cursada);
		$preparedStatement -> bindParam(':nombre_materia_cursada', $nombre_cursada);
		$preparedStatement -> bindParam(':periodo_de_revalidacion', $periodo);
		$preparedStatement -> bindParam(':anio_de_revalidacion', $anio);
		$preparedStatement -> bindParam(':idcarrera', $idcarrera);
		
		// Cierra la conexión MySQL.
		mysql_close();
		
		// Ejecuta la sentencia de SQL.
		$preparedStatement -> execute();
        
		// Despliega los datos de la revalidación actual.
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
	  
	  // Valida si hubo alguna revalidación que no pudo ser registrada. En este caso se despliega un mensaje con una
	  // descripción del error.
	  if($bandera_revalidacion_no_pudo_ser_agregada == 1){
		echo "NOTA: En el documento se encontraron revalidaciones que no pudieron ser registradas debido a ambigüedad presente en las siglas de la carrera, en la columna de 'carrera'. Favor de revisar el documento.";
	  }
	  
?>

	<div id="footer">
			&copy; DCV <?php echo date('Y'); ?> por la Direcci&oacute;n de ITC, ITESM<br/>
			Derechos Reservados.<br/>
	</div><!-- footer -->
	
	</div>
	
</body>
</html>