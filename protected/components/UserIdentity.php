<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{	
		//checa si es Alumno
		$usuario = Alumno::model()->findByAttributes(array('matricula'=>$this->username));
		if ($usuario == null){ //no existe como Alumno
			//checa si es Empleado
			$usuario = Empleado::model()->findByAttributes(array('nomina'=>$this->username));
			if ($usuario == null){ //no existe como Empleado tampoco
				$usuario = Admin::model()->findByAttributes(array('username'=>$this->username));
				if ($usuario == null) {
					$this->errorCode=self::ERROR_USERNAME_INVALID;
				}else if ($usuario->password !== md5($this->password)){ //es admin pero password incorrecta
					$this->errorCode=self::ERROR_PASSWORD_INVALID;
				}else{ //es Empleado y no hay error
					$this->errorCode=self::ERROR_NONE;
					//Check this out. El admin no esta asociado a rol ni carrera.
					$this->setState('rol', 'Admin');
					//$this->setState('carrera', $usuario->carreras[0]->id);
				}
			}else if ($usuario->password !== md5($this->password)){ //es Empleado pero password incorrecta
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}else{ //es Empleado y no hay error
				$this->errorCode=self::ERROR_NONE;
				$this->setState('rol', $usuario->puesto);
				$this->setState('carrera', $usuario->carreras[0]->id);
			}
		}else if ($usuario->password !== md5($this->password)){ //es Alumno pero password incorrecta
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}else{ //es Alumno y no hay error
			$this->errorCode=self::ERROR_NONE;
			$this->setState('rol', 'Alumno');
			$this->setState('carrera', $usuario->idcarrera);
		}
		
		return !$this->errorCode;
	}
}
