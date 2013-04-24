<?php

/**
 * Clase LoginForm.
 * LoginForm es la estructura de datos para almacenar
 * la información de 'login' de un usuario, a partir de una forma. Es utilizada por
 * la acción 'login' de 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declara las reglas de validación.
	 * Las reglas indican que el nombre de usuario y la contraseña son
	 * requeridos, y que la contraseña debe ser autenticada.
	 */
	public function rules()
	{
		return array(
			// El nombre de usuario y la contraseña son requeridos.
			array('username, password', 'required'),
			// rememberMe debe ser de tipo boolean.
			array('rememberMe', 'boolean'),
			// La contraseña debe ser autenticada.
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declara las etiquetas de los atributos.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
			'username'=>'El nombre de usuario',
			'password'=>'La contraseña',
		);
	}

	/**
	 * Autentifica la contraseña.
	 * Este es el validador 'authenticate', declarado en rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$identity = new UserIdentity($this->username,$this->password);
			$identity->authenticate();
			switch($identity->errorCode){
				
				case UserIdentity::ERROR_NONE:
					Yii::app()->user->login($identity, 0);
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('username','La matrícula o nómina es incorrecta.');
					break;
				default: //UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError('password','La contraseña es incorrecta.');
					break;
			}
		}
	}

	/**
	 * Inicia la sesión del usuario utilizando el nombre de usuario y la contraseña proporcionados en
	 * el modelo.
	 * @return boolean un valor booleano, indicando si el inicio de sesión fue exitoso
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 días
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
