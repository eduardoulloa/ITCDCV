<?php
/**
 * Clase ContactForm.
 * ContactForm es la estructura de datos para almacenar
 * datos de una forma de contacto. Es utilizada por la acción 'contact' de
 * 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * Declara las reglas de validación.
	 */
	public function rules()
	{
		return array(
			// El nombre, dirección de e-mail, asunto y cuerpo son requeridos.
			array('name, email, subject, body', 'required'),
			// El e-mail tiene que ser una dirección de e-mail válida.
			array('email', 'email'),
			// El 'verifyCode' debe ser ingresado correctamente.
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declara etiquetas de atributos personalizadas.
	 * Si no se declara aquí, un atributo tendrá una etiqueta que sería
	 * igual a su nombre, con la primera letra en mayúscula.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}
}