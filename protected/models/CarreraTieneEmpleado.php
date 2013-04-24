<?php
 /**
 * Esta es la clase modelo para la tabla "carrera_tiene_empleado".
 *
 * A continuación se indican las columnas disponibles en la tabla 'carrera_tiene_empleado':
 * @property integer $idcarrera
 * @property string $nomina
 */
class CarreraTieneEmpleado extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático de la clase de AR especificada.
	 * @return CarreraTieneEmpleado la clase del modelo estático
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
		return 'carrera_tiene_empleado';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('idcarrera, nomina', 'required'),
			array('idcarrera', 'numerical', 'integerOnly'=>true),
			array('nomina', 'length', 'max'=>9),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('idcarrera, nomina', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		// NOTA: posiblemente usted requiera ajustar el nombre de la relación y de la
		// clase para las siguientes relaciones que se generan automáticamente:
		return array(
		);
	}

	/**
	 * @return array etiquetas de atributos personalizadas (nombre=>etiqueta)
	 */
	public function attributeLabels()
	{
		return array(
			'idcarrera' => 'Idcarrera',
			'nomina' => 'Nomina',
		);
	}

	/**
	 * Obtiene una lista de modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos que puede devolver los modelos en base a las
	 * condiciones de búsqueda/filtro.
	 */
	public function search()
	{		
		// Advertencia: Por favor modifique el siguiente código para remover los atributos que
		// no deben ser buscados.

		$criteria=new CDbCriteria;

		$criteria->compare('idcarrera',$this->idcarrera);
		$criteria->compare('nomina',$this->nomina,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}