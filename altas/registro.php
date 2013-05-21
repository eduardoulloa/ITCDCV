<?php
	// Inicia la sesi�n.
	session_start();
	
	// Valida si el usuario est� autenticado, es decir, si se ingres� un
	// nombre de usuario y una contrase�a.
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
	}else{
		// El usuario no est� autenticado. En este caso se despliega un
		// mensaje con la descripci�n del error. Se cierra la sesi�n.
		echo "Se requiere autenticaci�n para ingresar a este sitio.";
		die();
	}
	
	// Realiza la conexi�n a mysql, con las credenciales del servidor.
	mysql_connect("localhost", "root", "baca.lao") or die(mysql_error());
	
	// Se selecciona la base de datos a utilizar.
	mysql_select_db("dcv") or die(mysql_error());
	
	// Busca los datos del usuario actual en la tabla de empleados.
	$result = mysql_query("SELECT * FROM empleado WHERE nomina ='".$_SESSION['username']."'");
	$row = mysql_fetch_array($result);
	
	// Busca los datos del usuario actual en la tabla de administradores generales.
	$result_admin = mysql_query("SELECT * FROM admin WHERE username ='".$_SESSION['username']."'");
	$row_admin = mysql_fetch_array($result_admin);
	
	// Si el usuario no es un empleado ni un administrador general se despliega un
	// mensaje con una descripci�n del error. Se cierra la sesi�n.
	if(empty($row) && empty($row_admin)){
			echo "Error. El usuario no fue encontrado o no tiene acceso a este sitio.";
			die();
	}
	
	// Se libera la variable $result.
	mysql_free_result($result);
	
	// Se libera la variable $result_admin.
	mysql_free_result($result_admin);
	
	// Se cierra la sesi�n con MySQL.
	mysql_close();
	
?>

<html>
<head>
<title>Registro de alumnos desde Internet</title>
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
	

<!-- Men�
<div id="mainmenu">
</div>
-->

<?php
     /*require_once("menu.php");*/
?>

    <br />
    <!--Aqu� inician breadcrumbs -->
	
	<!--Aqu� inicia el contenido -->
	
	<h1>Registro de alumnos </h1> <br />
	
	<p><a href="../index.php">Volver a la Direcci&oacute;n de Carrera Virtual</a></p>
	
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
        &copy; DCV <?php echo date('Y'); ?> por la Direcci&oacute;n de ITC, ITESM<br/>
        Derechos Reservados.<br/>
    </div><!-- footer -->

</div><!-- page -->

</body>

</html>