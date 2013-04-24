<?php

 /**
 * Esta es la clase modelo para la tabla "carrera".
 *
 * A continuación se indican las columnas disponibles en la tabla 'carrera':
 * @property integer $id
 * @property string $siglas
 * @property string $nombre
 *
 * A continuación se indican las relaciones disponibles para el modelo:
 * @property Alumno[] $alumnos
 * @property BoletinInformativo[] $boletinInformativos
 * @property Empleado[] $empleados
 */
class Carrera extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático de la clase de AR especificada.
	 * @return Carrera la clase del modelo estático
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
		return 'carrera';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('siglas, nombre', 'required'),
			array('siglas', 'length', 'max'=>5),
			array('nombre', 'length', 'max'=>80),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deberán ser buscados.
			array('id, siglas, nombre', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: posiblemente usted deberá ajustar el nombre de la relación y de la
		// clase relacionada para las siguientes relaciones que se generan automáticamente.
		return array(
			'alumnos' => array(self::HAS_MANY, 'Alumno', 'idcarrera'),
			'boletinInformativos' => array(self::HAS_MANY, 'BoletinInformativo', 'idcarrera'),
			'empleados' => array(self::MANY_MANY, 'Empleado', 'carrera_tiene_empleado(idcarrera, nomina)'),
		);
	}

	/**
	 * @return array etiquetas de atributos personalizadas (nombre=>etiqueta)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'siglas' => 'Siglas',
			'nombre' => 'Nombre',
		);
	}

	/**
	 * Obtiene una lista de modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos (data provider) que puede devolver modelos en base a las
	 * condiciones de búsqueda/filtro
	 */
	public function search()
	{		
		// Advertencia: Por favor modifique el siguiente código para remover atributos que
		// no deben ser buscados.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('siglas',$this->siglas,true);
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}