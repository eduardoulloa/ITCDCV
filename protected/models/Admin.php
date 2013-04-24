<?php

 /**
 * Esta es la clase modelo para la tabla "admin".
 *
 * A continuación se indican las columnas disponibles en la tabla 'admin':
 * @property string $username
 * @property string $password
 */
class Admin extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático de la clase de AR especificada.
	 * @return Admin la clase del modelo estático
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string el nombre asociado a la tabla en la base de datos
	 */
	public function tableName()
	{
		return 'admin';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('username', 'length', 'max'=>20),
			array('password', 'length', 'max'=>60),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deberán ser buscados.
			array('username, password', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: posiblemente se deba ajustar el nombre de la relación y el
		// nombre de clase relacionada para las relaciones que se generan
		// automáticamente a continuación.
		return array(
		);
	}

	/**
	 * @return array etiquetas de atributos personalizadas (nombre=>etiqueta)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Nombre de usuario',
			'password' => 'Contraseña',
		);
	}

	/**
	 * Obtiene una lista de modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos (data provider) que puede devolver modelos en base a las
	 * condiciones de búsqueda/filtro.
	 */
	public function search()
	{
		// Advertencia: Por favor modifique el siguiente código para remover los atributos que
		// no deben ser buscados.

		$criteria=new CDbCriteria;

		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}