<?php

/**
 * Esta es la clase modelo para la tabla "solicitud_carta_recomendacion".
 *
 * A continuación se indican las columnas disponibles para la tabla 'solicitud_carta_recomendacion':
 * @property integer $id
 * @property string $fechahora
 * @property string $status
 * @property string $tipo
 * @property string $formato
 * @property string $comentarios
 * @property string $matriculaalumno
 *
 * A continuación se indican las relaciones disponibles para el modelo:
 * @property Alumno $matriculaalumno0
 */
class SolicitudCartaRecomendacion extends CActiveRecord
{

	/**
	 * Devuelve el modelo estático para la clase de AR especificada.
	 * @return SolicitudCartaRecomendacion la clase del modelo estático
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
		return 'solicitud_carta_recomendacion';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe defnir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('tipo','required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('formato', 'length', 'max'=>30),
			array('comentarios', 'length', 'max'=>500),
			array('tipo','length','max'=>50),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('id, fechahora, status, tipo, formato, comentarios, matriculaalumno', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: posiblemente tendrá que ajustar el nombre de la relación y de la
		// clase relacionada para las siguientes relaciones, generadas automáticamente.
		return array(
			'matriculaalumno0' => array(self::BELONGS_TO, 'Alumno', 'matriculaalumno'),
		);
	}

	/**
	 * @return array etiquetas de atributos (nombre=>etiqueta)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechahora' => 'Fecha',
			'status' => 'Estatus',
			'tipo' => 'Tipo',
			'formato' => 'Formato',
			'comentarios' => 'Comentarios',
			'matriculaalumno' => 'Matrícula',
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

		// Crea un nuevo modelo de CDbCriteria.
		$criteria=new CDbCriteria;
				
		// Almacena el rol del usuario actual.
		$rol = Yii::app()->user->rol;
		
		// Almacena el nombre de usuario del usuario actual.
		$nombre_de_usuario = Yii::app()->user->id;
		
		// Valida si el usuario actual es un director de carrera, un asistente o una secretaria.
		if($rol == 'Director' || $rol == 'Asistente'|| $rol == 'Secretaria'){
			
			// Criterios para que el usuario actual solo pueda buscar las
			// solicitudes de carta de recomendación hechas en las
			// carreras en las que labora
			$criteria->join = 'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nombre_de_usuario.'\'';
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('fechahora',$this->fechahora,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('formato',$this->formato,true);
		$criteria->compare('comentarios',$this->comentarios,true);
		$criteria->compare('matriculaalumno',$this->matriculaalumno,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}