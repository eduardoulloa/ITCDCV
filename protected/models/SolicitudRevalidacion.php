<?php

/**
 * Esta es la clase modelo para la tabla "solicitud_revalidacion".
 *
 * A continuación se indican las columnas disponibles en la tabla 'solicitud_revalidacion':
 * @property integer $id
 * @property string $fechahora
 * @property string $status
 * @property string $periodo
 * @property string $anio
 * @property string $clave_revalidar
 * @property string $nombre_revalidar
 * @property string $clave_cursada
 * @property string $nombre_cursada
 * @property string $universidad
 * @property string $matriculaalumno
 *
 * A continuación se indican las relaciones disponibles para el modelo:
 * @property Alumno $matriculaalumno0
 */
class SolicitudRevalidacion extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático de la clase de AR especificada.
	 * @return SolicitudRevalidacion la clase del modelo estático
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
		return 'solicitud_revalidacion';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para los atributos que
		// serán ingresados por usuarios.
		return array(
			array('status, periodo, anio, clave_revalidar, nombre_revalidar, nombre_cursada, universidad, matriculaalumno', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('periodo', 'length', 'max'=>16),
			array('anio', 'length', 'max'=>4),
			array('clave_revalidar, clave_cursada', 'length', 'max'=>10),
			array('nombre_revalidar, nombre_cursada, universidad', 'length', 'max'=>100),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('id, fechahora, status, periodo, anio, clave_revalidar, nombre_revalidar, clave_cursada, nombre_cursada, universidad, matriculaalumno', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: usted posiblemente tendrá que ajustar el nombre de la relación y de la
		// clase relacionada para las siguientes relaciones generadas automáticamente.
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
			'periodo' => 'Periodo',
			'anio' => 'Año',
			'clave_revalidar' => 'Clave de materia a revalidar',
			'nombre_revalidar' => 'Nombre de materia a revalidar',
			'clave_cursada' => 'Clave de materia cursada',
			'nombre_cursada' => 'Nombre de materia cursada',
			'universidad' => 'Universidad',
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
		
		// Valida si el usuario actual es un director de carrera, un asistente o una secretaria.
		if($rol == 'Director' || $rol == 'Asistente'|| $rol == 'Secretaria'){
			
			// Criterios para que el usuario actual solo pueda buscar las
			// solicitudes de revalidación de materia hechas en las
			// carreras en las que labora
			$criteria->join = 'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nombre_de_usuario.'\'';
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('fechahora',$this->fechahora,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('periodo',$this->periodo,true);
		$criteria->compare('anio',$this->anio,true);
		$criteria->compare('clave_revalidar',$this->clave_revalidar,true);
		$criteria->compare('nombre_revalidar',$this->nombre_revalidar,true);
		$criteria->compare('clave_cursada',$this->clave_cursada,true);
		$criteria->compare('nombre_cursada',$this->nombre_cursada,true);
		$criteria->compare('universidad',$this->universidad,true);
		$criteria->compare('matriculaalumno',$this->matriculaalumno,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}