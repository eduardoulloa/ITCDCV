<?php
	
	function getEmailAddress($matricula) 
	{
		$address = "";
		if(strlen($matricula) == 6){
			$address .= 'A00'.$matricula.'@itesm.mx';
		} else if (strlen($mat) == 7){
			$address .= 'A0'.$matricula.'@itesm.mx';
		}
		return $address;
	}
	
	function userTieneRolAsignado() {
		return isset(Yii::app()->user->rol);
	}
	
	function esAdmin() {
		if(userTieneRolAsignado()) {
			return Yii::app()->user->rol == 'Admin';
		}
		return false;
	}
	
	function esDirector() {
		if(userTieneRolAsignado()) {
			return Yii::app()->user->rol == 'Director';
		}
		return false;
	}
	
	function esCoDirector() {
		if(userTieneRolAsignado()) {
			return Yii::app()->user->rol == 'Co-director';
		}
		return false;
	}
	
	function esSecretaria() {
		if(userTieneRolAsignado()) {
			return Yii::app()->user->rol == 'Secretaria';
		}
		return false;
	}
	
	function esAsistente() {
		if(userTieneRolAsignado()) {
			return Yii::app()->user->rol == 'Asistente';
		}
		return false;
	}
	
	function esAlumno() {
		if(userTieneRolAsignado()) {
			return Yii::app()->user->rol == 'Alumno';
		}
		return false;
	}
	
	//Yii:app()->user->id
	
	function matriculaYaExiste($matricula) {
		$matriculas = array();
		$alumnos = Alumno::model()->findAll();
		foreach($alumnos as &$alumno){
			array_push($matriculas, ($alumno->matricula).'');
		}
		if(in_array($matricula, $matriculas)) {
			return true;
		}
		return false;
	}
	
	function getCarreras() {
		$res = array();
		$carreras = Carrera::model()->findAll();
		foreach($carreras as &$carrera) {
			$res[$carrera->id] = $carrera->siglas;
		}
		return $res;
	}
	
	function getPuestos() {
		$res = array();
		$res["Director"] = "Director";
		$res["Co-director"] = "Co-director";
		$res["Secretaria"] = "Secretaria";
		$res["Asistente"] = "Asistente";
		return $res;		
	}
	
	function cifraPassword($password) {
		if($password != '') {
			return md5($password);
		}
		return $password;
	}
	
	