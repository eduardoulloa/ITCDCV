<?php
	// Inicia la sesión.
	session_start();
	
	// Valida si el usuario está autenticado, es decir, si se ingresó un
	// nombre de usuario y una contraseña.
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
	}else{
		// El usuario no está autenticado. En este caso se despliega un
		// mensaje con la descripción del error.
		echo "Se requiere autenticación para ingresar a este sitio.";
		die();
	}
	
	// Realiza la conexión a mysql, con las credenciales del servidor.
	mysql_connect("localhost", "root", "baca.lao") or die(mysql_error());
	
	// Se selecciona la base de datos a utilizar.
	mysql_select_db("dcv") or die(mysql_error());
	
	//$result = mysql_query("SELECT * FROM empleado WHERE nomina ='".$_SESSION['username']."' AND password = '".$_SESSION['password']."'");
	$result = mysql_query("SELECT * FROM empleado WHERE nomina ='".$_SESSION['username']."'");
	
	$row = mysql_fetch_array($result);
	
	//$result_admin = mysql_query("SELECT * FROM admin WHERE username ='".$_SESSION['username']."' AND password = '".$_SESSION['password']."'");
	$result_admin = mysql_query("SELECT * FROM admin WHERE username ='".$_SESSION['username']."'");
	
	$row_admin = mysql_fetch_array($result_admin);
	
	if(empty($row) && empty($row_admin)){
			echo "Error. El usuario no fue encontrado o no tiene acceso a este sitio.";
			die();
	}
	
	mysql_free_result($result);
	mysql_free_result($result_admin);
	mysql_close();
	
	
?>

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
	

<!-- Aquí hay que poner el menú
<div id="mainmenu">
</div>
-->

<?php
     /*require_once("menu.php");*/
	
?>



    <br />
    <!--Aquí se ponen breadcrumbs -->
	
	<!--Aquí inicia el contenido -->
	
	<h1>Registro de alumnos </h1> <br />
	
	<p><a href="../dcv8/DCV/index.php">Volver al Director de Carrera Virtual</a></p>
	
	<p>Por favor ingresa las credenciales de tu cuenta de Google:</p>
	
	<form action="altas.php" method="POST">
	<label for="googleaccount">Cuenta de Google:</label> <input type="text" name="googleaccount" />
	<br />
	<label for="googlepass">Contrase&ntilde;a de Google:</label> <input type="password" name="googlepass" />
	<br />
	<label for="documento">Liga al documento de Google Drive (URL):</label> <input type="text" size="50px" name="documento" />
	<input type="submit" value="Registrar alumnos"/>
	</form>

    <div id="footer">
        &copy; DCV <?php /*echo date('Y'); */?> by Direcci&oacute;n de ITC, ITESM<br/>
        Derechos Reservados.<br/>
        <?php /*echo Yii::powered(); */?>
    </div><!-- footer -->


</div><!-- page -->



</body>

</html>