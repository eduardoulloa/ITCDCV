<?php
	// Inicia una sesi�n de MySQL.
	session_start();
	
	// Valida si el usuario est� autenticado. Es decir, si ingres� su nombre de usuario y su contrase�a.
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
	}else{
	
		// El usuario no est� autenticado. En este caso se despliega un mensaje con una
		// descripci�n del error.
		echo "Se requiere autenticaci�n para ingresar a este sitio.";
		die();
	}
		
	// Establece la conexi�n con el servidor.
	mysql_connect("localhost", "root", "") or die(mysql_error());
	
	// Selecciona la base de datos del servidor.
	mysql_select_db("dcv") or die(mysql_error());
	
	// Sentencia de SQL para validar si el usuario actual es un empleado
	$result = mysql_query("SELECT * FROM empleado WHERE nomina ='".$_SESSION['username']."'");
	
	// Obtiene el resultado de la sentencia de SQL.
	$row = mysql_fetch_array($result);
	
	// Sentencia de SQL para validar si el usuario actual es un administrador general
	$result_admin = mysql_query("SELECT * FROM admin WHERE username ='".$_SESSION['username']."'");
	
	// Obtiene el resultado de la sentencia de SQL.
	$row_admin = mysql_fetch_array($result_admin);
	
	// Valida si el usuario no es un empleado ni un administrador general. En caso de ser as�, se
	// despliega un mensaje con una descripci�n del error.
	if(empty($row) && empty($row_admin)){
		echo "Error. El usuario no fue encontrado o no tiene acceso a este sitio.";
		die();
	}
	
	// Libera la variable $result.
	mysql_free_result($result);
	
	// Libera la variable $result_admin.
	mysql_free_result($result_admin);
	
	// Cierra la sesi�n de MySQL.
	mysql_close();
?>

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
	

<!-- Men�
<div id="mainmenu">
</div>
-->

<?php
     /*require_once("menu.php");*/
	
?>

    <br />
    <!-- Aqu� inician breadcrumbs. -->
	
	<!-- Aqu� inicia el contenido. -->
	
	<h1>Registro de revalidaciones </h1> <br />
	
	<p><a href="../index.php">Volver a la Direcci&oacute;n de Carrera Virtual</a></p>
	
	<p>Por favor ingresa las credenciales de tu cuenta de Google:</p>
	
	<form action="reporte_revalidaciones.php" method="POST">
	<label for="googleaccount">Cuenta de Google:</label> <input type="text" name="googleaccount" />
	<br />
	<label for="googlepass">Contrase&ntilde;a de Google:</label> <input type="password" name="googlepass" />
	<br />
	<label for="documento">Liga al documento de Google Drive (URL):</label> <input type="text" size="50px" name="documento" />
	<input type="submit" value="Registrar revalidaciones"/>
	</form>

    <div id="footer">
        &copy; DCV <?php echo date('Y'); ?> por la Direcci&oacute;n de ITC, ITESM<br/>
        Derechos Reservados.<br/>
    </div><!-- footer -->

</div><!-- page -->

</body>

</html>