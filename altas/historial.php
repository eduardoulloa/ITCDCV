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
	
	<h1>Registro de alumnos </h1> <br />
	
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
	  echo "Fueron dados de alta los siguientes alumnos:";
	  echo "<br /><br />";
	  
    } catch (Exception $e) {
      die('ERROR: ' . $e->getMessage());
    }
	
	$primero = true;
	$todos = "";
	
	//bandera para detectar si algún alumno no pudo ser agregado
	$bandera_alumno_no_pudo_ser_agregado = 0;
	
	//obtiene datos de la primera hoja (la única necesaria)
    $listFeed = $service->getListFeed($wsFeed[0]);
    foreach ($listFeed as $listEntry) {
    	//obtiene fila
    	$rowData = $listEntry->getCustom();
		
		//obtiene datos de la fila
		
		$matricula = $rowData[0]->getText();
	
		$pos = strpos($matricula, "A00");
		
		//variable para almacenar la matrícula con sólamente el número; es decir, sin A0 o A00
		$mat = "";
		
		if($pos === false){
			//se trata de una matrícula de 7 dígitos
			$mat = substr($matricula, 2, 7);
		}else{
			//se trata de una matrícula de 6 dígitos
			$mat = substr($matricula, 3, 6);
		}
		
		$nombre = utf8_decode($rowData[1]->getText());
		$apaterno = utf8_decode($rowData[2]->getText());
		$amaterno = utf8_decode($rowData[3]->getText());
		$plan = $rowData[4]->getText();
		$semestre = $rowData[5]->getText();
		$fechaDeNacimiento = $rowData[6]->getText();
		$carrera = $rowData[7]->getText();
		
		//creando el password (son los 8 caracteres de su fecha de nacimiento)
		$fecha1 = substr($fechaDeNacimiento, 1, 2);
		$fecha2 = substr($fechaDeNacimiento, 4, 2);
		$fecha3 = substr($fechaDeNacimiento, 7, 4);
		
		$fechafinal = $fecha1 . $fecha2 . $fecha3;
		
		$password = md5($fechafinal);
		$email = $matricula."@itesm.mx";
		
		if($primero){
			$primero = false;
			$todos = "'".$mat."'";
		}else{
			$todos.= ", '".$mat."'";
		}
		
		//obtengo el id de la carrera, a partir de las siglas de la carrera
		mysql_connect("localhost", "root", "") or die(msyqsl_error());
		mysql_select_db("dcv") or die(mysql_error());
	
		$result = mysql_query("SELECT id FROM carrera WHERE siglas LIKE '".$carrera."'");
		
		$row = mysql_fetch_array($result);
		
		if(!empty($row)){
			$idcarrera = $row['id'];
		}else{
			//la carrera no fue encontrada, entonces se rompe el ciclo
			$bandera_alumno_no_pudo_ser_agregado = 1;
			break;
			
		}
		
		mysql_free_result($result);
		
		//Checa si ya está en la BD el alumno
		$result2 = mysql_query("SELECT semestre, password, email FROM alumno WHERE matricula = '".$mat."'");
		$row2 = mysql_fetch_array($result2);
		
		//Al parecer esto no funciona
		//checa si la matricula ya existe,
		//y obtiene el semestre anterior en caso de que el dado no sea válido
		/*$sql = "SELECT semestre, password, email FROM alumno WHERE matricula = :matricula";
		$preparedStatement = $con -> prepare($sql);
		$preparedStatement -> bindParam(':matricula', $mat);
		$result = $preparedStatement -> fetchAll(PDO::FETCH_ASSOC);*/
		
		
		//si no estaba, insértalo
		if(empty($row2)){
			if(!is_numeric($semestre)){
				$semestre = 1;
			}
    		$sql = "INSERT INTO alumno(matricula, nombre, apellido_paterno, apellido_materno, plan,
    									semestre, password, anio_graduado, idcarrera, email)
					   			VALUES(:matricula, :nombre, :apaterno, :amaterno, :plan,
					   					:semestre, :password, NULL, :idcarrera, :email)";
			
		}else{ //si ya estaba, actualízalo
			
			if(!is_numeric($semestre)){
				$semestre = $row2['semestre'];
			}
			//conserva correo y password anterior del alumno, por si los había cambiado
			$email = $row2['email'];
			$password = $row2['password'];
			$sql = "UPDATE alumno SET nombre = :nombre, apellido_paterno = :apaterno,
									  apellido_materno = :amaterno, plan = :plan,
									  semestre = :semestre, password = :password,
									  anio_graduado = NULL, idcarrera = :idcarrera,
									  email = :email
					WHERE matricula = :matricula";
		}
		
		
		
		//prepara el query
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
		mysql_free_result($result2);
		mysql_close();
		$preparedStatement -> execute();
        
		
        echo "Matrícula = $matricula <br />";
        echo "Nombre = $nombre <br />";
        echo "Apellido paterno = $apaterno <br />";
        echo "Apellido materno = $amaterno <br />";
        echo "Plan de estudios = $plan <br />";
        echo "Semestre = $semestre <br />";
        echo "Password = $password <br />";
        echo "E-mail = $email <br />";
        
        echo "<br />";
      }
	  
	  
	  
	  //actualiza el semestre de todos los alumnos de la carrera a -1
	  //para que los que no se actualicen a continuación queden como exalumnos
	  $sql = "UPDATE alumno SET semestre = -1 WHERE matricula NOT IN ($todos)";
	  $preparedStatement = $con -> prepare($sql);
	  //$preparedStatement -> bindParam(':idcarrera', $idcarrera);
	  $preparedStatement -> execute();
	  
	  if($bandera_alumno_no_pudo_ser_agregado == 1){
		echo "NOTA: En el documento se encontraron alumnos que no pudieron ser dados de alta debido a ambigüedad presente en las siglas de la carrera, en la columna de 'carrera'. Favor de revisar el documento.";
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