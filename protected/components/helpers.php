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
	
	function esDirectorOAdmin() {
		if(userTieneRolAsignado()) {
			return Yii::app()->user->rol != 'Alumno';
		}
		return false;
	}
	
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
	
	function cifraPassword($password) {
		if($password != '') {
			return md5($password);	
		}
		return $password;
	}
	
	