<?php

	//1. estas son unas pruebas que hice para quitar los slashes de las fechas
	
	/*$s = "25/03/1983";
	$fecha1 = substr($s, 0, 2);
	$fecha2 = substr($s, 3, 2);
	$fecha3 = substr($s, 6, 4);
	$fechaDeNacimiento = $fecha1 . $fecha2 . $fecha3;
	echo $fechaDeNacimiento;*/
	
	
	//2. esta funcion detecta si una matricula es de 6 o 7 digitos
	/*$mat = "A00796570";
	
	$pos = strpos($mat, "A00");
	
	if($pos === false){
		//echo "matricula de 7 digitos";
		$matricula = substr($mat, 2, 7);
	}else{
		//echo "matricula de 6 digitos";
		$matricula = substr($mat, 3, 6);
	}
	
	echo $matricula;*/
	
	//3. esta función es para user authentication
	/*$username = $_POST['username'];
	$password = md5($_POST['password']);
	
	mysql_connect("localhost", "root", "") or die(msyqsl_error());
	mysql_select_db("dcv") or die(mysql_error());
	
	$result = mysql_query("SELECT * FROM empleado WHERE nomina ='".$username."' AND password = '".$password."'");
	
	$row = mysql_fetch_array($result);
	
	if( !empty($username)){
	
		if(empty($row)){
			echo "usuario no encontrado";
		}else{
			echo "bienvenido ".$username;
		}
	}else{
		echo "se requiere autenticacion para visualizar este sitio";
	}
	
	mysql_free_result($result);
	mysql_close();*/
	
	
	//4. Esta función obtiene el id de una carrera, a partir de sus siglas. 
	// Si no encuentra la carrera, avisa.
	/*$carrera = "ima";
	
	mysql_connect("localhost", "root", "") or die(msyqsl_error());
	mysql_select_db("dcv") or die(mysql_error());
	
	$result = mysql_query("SELECT id FROM carrera WHERE siglas LIKE '".$carrera."'");
	
	$row = mysql_fetch_array($result);
	
	if(!empty($row)){
		echo "El id de la carrera es ".$row['id'];
	}else{
		echo "carrera no encontrada";
	}
	
	mysql_free_result($result);
	mysql_close();*/
	
	
	
?>