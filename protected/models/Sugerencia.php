<?php

/**
 * Esta es la clase modelo para la tabla "sugerencia".
 *
 * A continuación se indican las columnas disponibles en la tabla 'sugerencia':
 * @property integer $id
 * @property string $fechahora
 * @property string $status
 * @property string $sugerencia
 * @property string $respuesta
 * @property string $matriculaalumno
 *
 * A continuación se indican las relaciones disponibles para el modelo:
 * @property Alumno $matriculaalumno0
 */
class Sugerencia extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático para la clase de AR especificada.
	 * @return Sugerencia la clase del modelo estático
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
		return 'sugerencia';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('sugerencia', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('sugerencia, respuesta', 'length', 'max'=>500),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('id, fechahora, status, sugerencia, respuesta, matriculaalumno', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: usted posiblemente tendrá que ajustar el nombre de la relación y de la
		// clase relacionada para las siguientes relaciones que se generan automáticamente.
		return array(
			'matriculaalumno0' => array(self::BELONGS_TO, 'Alumno', 'matriculaalumno'),
		);
	}

	/**
	 * @return array etiquetas personalizadas para los atributos (nombre=>etiqueta)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechahora' => 'Fecha',
			'status' => 'Estatus',
			'sugerencia' => 'Sugerencia',
			'respuesta' => 'Respuesta',
			'matriculaalumno' => 'Matrícula',
		);
	}

	/**
	 * Obtiene una lista de modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos (data provider) que puede devolver los modelos en base a las
	 * condiciones de búsqueda/filtro.
	 */
	public function search()
	{
		// Advertencia: Por favor modifique el siguiente código para remover los atributos que
		// no deben ser buscados.

		// Crea un nuevo modelo de CDbCriteria.
		$criteria=new CDbCriteria;
		
		// Almacena el rol del usuario actual.
		$rol = Yii::app()->user->rol;
		
		// Almacena el nombre de usuario del usuario actual.
		$nombre_de_usuario = Yii::app()->user->id;
		
		// Valida si el usuario actual es un director, un asistente o una secretaria.
		if($rol == 'Director' || $rol == 'Asistente'|| $rol == 'Secretaria'){
			
			// Criterios para que el usuario actual solo pueda buscar las
			// sugerencias hechas en las carreras en las que labora
			$criteria->join = 'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nombre_de_usuario.'\'';
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('fechahora',$this->fechahora,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('sugerencia',$this->sugerencia,true);
		$criteria->compare('respuesta',$this->respuesta,true);
		$criteria->compare('matriculaalumno',$this->matriculaalumno,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}