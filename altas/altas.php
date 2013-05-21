<html>
<head>
<title>Alumnos dados de alta</title>
</head>
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
	
	<h1>Registro de alumnos </h1> <br />
	
	<p><a href="../index.php">Volver a la Direcci&oacute;n de Carrera Virtual</a></p>
	
<?php
	
	// Clases de Zend Framework requeridas
	require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	
	// Almacena el nombre de usuario de la cuenta de Google proporcionada.
	$user = $_POST['googleaccount'];
	
	// Almacena la contrase�a de la cuenta de Google proporcionada.
	$pass = $_POST['googlepass'];
	
	// Almacena el URL del documento de Google Drive.
	$documento =$_POST["documento"];
	
	// Obtiene la llave para identificar de manera �nica al documento en el
	// servidor de Google.
	if(strpos($documento, "&")===false){
		$key= substr($documento , strpos($documento, "key=")+4, strlen($documento));
	}else{
		$key= substr($documento , strpos($documento, "key=")+4, strpos($documento, "&")-strpos($documento, "key=")-4);
	}
	
	// Construye el URL necesario para acceder al documento de Google Drive.
	$URI='https://spreadsheets.google.com/feeds/spreadsheets/'.$key;
	
	// Credenciales de MySQL para acceder a la base de datos.
	$hostname = "localhost";
	$username = "root";
	$password = "baca.lao";
	$dbname = "dcv";
	
	// Intenta establecer la conexi�n con la base de datos. En caso de fallar
	// se despliega un mensaje con una descripci�n del error.
	try{
    	$con = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    }catch(PDOException $e){
		
    	echo $e->getMessage();
    }
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	
	// Trata de conectarse al API y de obtener el documento de Google. En caso de
	// fallar se despliega un mensaje con una descripci�n del error.
	try {  
      // Se conecta al API.
      $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
      $service = new Zend_Gdata_Spreadsheets($client);

      // Obtiene el documento (hoja de c�lculo).
      $ssEntry = $service->getSpreadsheetEntry($URI);
      
      // Obtiene las hojas del documento (hoja de c�lculo).
      $wsFeed = $ssEntry->getWorksheets();
	  
	  // La conexi�n al API y al documento (hoja de c�lculo) fueron exitosas. Se despliega un mensaje para indicar que
	  // los alumnos fueron dados de alta en la base de datos.
	  echo "Fueron dados de alta los siguientes alumnos:";
	  echo "<br /><br />";
	  
    } catch (Exception $e) {
      die('ERROR: ' . $e->getMessage());
    }
	
	// Bandera para determinar si es el primer dato a insertar en la base de datos
	$primero = true;
	
	// Variable para almacenar las matr�culas de los alumnos que aparecen en el documento (hoja de c�lculo) de
	// Google Drive.
	$todos = "";
	
	// Bandera para determinar si alg�n alumno no pudo ser agregado
	$bandera_alumno_no_pudo_ser_agregado = 0;
	
	// Obtiene los datos de los alumnos a registrar, a partir de la primera hoja del documento (la �nica necesaria).
    $listFeed = $service->getListFeed($wsFeed[0]);
    foreach ($listFeed as $listEntry) {
    	
		// Obtiene la fila.
    	$rowData = $listEntry->getCustom();
		
		// Obtiene los datos de la fila.
		$matricula = $rowData[0]->getText();
		
		// Sirve para determinar si una matr�cula es de 6 o 7 d�gitos.
		$pos = strpos($matricula, "A00");
		
		// Variable para almacenar la matr�cula sola, es decir, sin "A0" o "A00".
		$mat = "";
		
		if($pos === false){
			// Se trata de una matr�cula de 7 d�gitos.
			$mat = substr($matricula, 2, 7);
		}else{
			// Se trata de una matr�cula de 6 d�gitos.
			$mat = substr($matricula, 3, 6);
		}
		
		// Variables para almacenar los datos de la fila.
		$nombre = utf8_decode($rowData[1]->getText());
		$apaterno = utf8_decode($rowData[2]->getText());
		$amaterno = utf8_decode($rowData[3]->getText());
		$plan = $rowData[4]->getText();
		$semestre = $rowData[5]->getText();
		$fechaDeNacimiento = $rowData[6]->getText();
		$carrera = $rowData[7]->getText();
		
		// Crea la contrase�a (a partir de los 8 caracteres de la fecha de nacimiento del alumno)
		$fecha1 = substr($fechaDeNacimiento, 1, 2);
		$fecha2 = substr($fechaDeNacimiento, 4, 2);
		$fecha3 = substr($fechaDeNacimiento, 7, 4);
		
		// Une las 3 fechas de nacimiento en un solo n�mero, que es la contrase�a.
		$fechafinal = $fecha1 . $fecha2 . $fecha3;
		
		// Almacena la contrase�a cifrada en MD5.
		$password = md5($fechafinal);
		
		// Crea la cuenta de e-mail del alumno, agreg�ndole a la matr�cula el
		// sufijo "@itesm.mx".
		$email = $matricula."@itesm.mx";
		
		// Valida si el alumno actual es el primero a registrar en la base de datos.
		if($primero){
			// Agrega la matr�cula del alumno actual al inicio de la lista.
			$primero = false;
			$todos = "'".$mat."'";
		}else{
			// Agrega la matr�cula del alumno actual al final de la lista.
			$todos.= ", '".$mat."'";
		}
		
		// Establece una conexi�n con la base de datos para obtener el ID de la carrera del
		// alumno actual.
		mysql_connect("localhost", "root", "baca.lao") or die(msyqsl_error());
		
		// Selecciona la base de datos.
		mysql_select_db("dcv") or die(mysql_error());
	
		// Obtiene el ID de la carrera a partir de las siglas, las cuales est�n almacenadas en
		// la variable $carrera.
		$result = mysql_query("SELECT id FROM carrera WHERE siglas LIKE '".$carrera."'");
		
		// Obtiene la fila de la carrera del alumno, de la base de datos.
		$row = mysql_fetch_array($result);
		
		// Valida si la variable $row no est� vac�a. Es decir, si la carrera
		// del alumno fue encontrada.
		if(!empty($row)){
			$idcarrera = $row['id'];
		}else{
			// La carrera no fue encontrada. Se detiene todo el proceso de
			// registro y se activa la bandera para indicar que un alumno
			// no pudo ser registrado en la base de datos.
			$bandera_alumno_no_pudo_ser_agregado = 1;
			break;
		}
		
		// Libera la variable $result.
		mysql_free_result($result);
		
		// Busca al alumno actual en la base de datos, para validar si anteriormente exist�a.
		$result2 = mysql_query("SELECT semestre, password, email FROM alumno WHERE matricula = '".$mat."'");
		$row2 = mysql_fetch_array($result2);
				
		// Valida si la variable $row2 est� vac�a. Es decir, si el alumno actual no fue
		// encontrado en la base de datos. En este caso, se inserta un nuevo registro en la
		// base de datos con los datos del alumno actual.
		if(empty($row2)){
			
			// Valida si el semestre del alumno a registrar no es un n�mero. En este caso se
			// le asigna el semestre "1".
			if(!is_numeric($semestre)){
				$semestre = 1;
			}
			
			// Sentencia de SQL para agregar el nuevo registro del alumno actual en la base de datos.
    		$sql = "INSERT INTO alumno(matricula, nombre, apellido_paterno, apellido_materno, plan,
    									semestre, password, anio_graduado, idcarrera, email)
					   			VALUES(:matricula, :nombre, :apaterno, :amaterno, :plan,
					   					:semestre, :password, NULL, :idcarrera, :email)";
		
		// El alumno actual ya estaba registrado en la base de datos. En este caso
		// se deben actualizar sus datos a partir de los m�s recientes.
		}else{
			
			// Valida si el semestre actual del alumno a actualizar no es un n�mero. En este caso el
			// alumno conserva el semestre que anteriormente estaba registrado en la base de datos.
			if(!is_numeric($semestre)){
				$semestre = $row2['semestre'];
			}
			
			// Se conservan el e-mail y la contrase�a anteriores del alumno, en caso de que los hubiese cambiado.
			$email = $row2['email'];
			$password = $row2['password'];
			
			// Sentencia de SQL para actualizar el registro del alumno actual en la base de datos.
			$sql = "UPDATE alumno SET nombre = :nombre, apellido_paterno = :apaterno,
									  apellido_materno = :amaterno, plan = :plan,
									  semestre = :semestre, password = :password,
									  anio_graduado = NULL, idcarrera = :idcarrera,
									  email = :email
					WHERE matricula = :matricula";
		}
		
		// Prepara la sentencia de SQL a ejecutar.
		$preparedStatement = $con -> prepare($sql);
		$preparedStatement -> bindParam(':matricula', $mat);
		$preparedStatement -> bindParam(':nombre', $nombre);
		$preparedStatement -> bindParam(':apaterno', $apaterno);
		$preparedStatement -> bindParam(':amaterno', $amaterno);
		$preparedStatement -> bindParam(':plan', $plan);
		$preparedStatement -> bindParam(':semestre', $semestre);
		$preparedStatement -> bindParam(':password', $password);
		$preparedStatement -> bindParam(':idcarrera', $idcarrera);
		$preparedStatement -> bindParam(':email', $email);
		
		// Libera la variable $result2.
		mysql_free_result($result2);
		
		// Cierra la conexi�n MySQL.
		mysql_close();
		
		// Ejecuta la sentencia preparada de MySQL.
		$preparedStatement -> execute();
        
		// Despliega cada uno de los datos del alumno actual.
        echo "Matr�cula = $matricula <br />";
        echo "Nombre = $nombre <br />";
        echo "Apellido paterno = $apaterno <br />";
        echo "Apellido materno = $amaterno <br />";
        echo "Plan de estudios = $plan <br />";
        echo "Semestre = $semestre <br />";
        echo "Password = $password <br />";
        echo "E-mail = $email <br />";
        echo "<br />";
      }
	  	  
	  // Cambia el semestre de todos los alumnos registrados en la base de datos a -1 (esto significa que son exalumnos).
	  // De esta manera, todos los alumnos que no est�n en el documento (hoja de c�lculo) de Google Drive quedan
	  // registrados como exalumnos.
	  $sql = "UPDATE alumno SET semestre = -1 WHERE matricula NOT IN ($todos)";
	  
	  // Prepara la sentencia de SQL a ejecutar.
	  $preparedStatement = $con -> prepare($sql);
	 
	 // Ejecuta la sentencia de SQL.
	  $preparedStatement -> execute();
	  
	  // Valida si hubo alg�n alumno que no pudo ser agregado. En caso de ser as�, se despliega un
	  // mensaje con una descripci�n del error.
	  if($bandera_alumno_no_pudo_ser_agregado == 1){
		echo "NOTA: En el documento se encontraron alumnos que no pudieron ser dados de alta debido a ambig�edad presente en las siglas de la carrera, en la columna de 'carrera'. Favor de revisar el documento.";
	  }
?>

	<div id="footer">
		&copy; DCV <?php echo date('Y'); ?> por la Direcci&oacute;n de ITC, ITESM<br/>
		Derechos Reservados.<br/>
	</div><!-- footer -->
	
	</div>
	
</body>
</html>