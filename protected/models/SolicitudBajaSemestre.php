<?php
/**
 * Esta es la clase modelo para la tabla "solicitud_baja_semestre".
 *
 * A continuación se indican las columnas disponibles en la tabla 'solicitud_baja_semestre':
 * @property integer $id
 * @property string $fechahora
 * @property string $status
 * @property string $periodo
 * @property string $anio
 * @property string $domicilio
 * @property string $motivo
 * @property string $telefono
 * @property integer $extranjero
 * @property string $matriculaalumno
 *
 * A continuación se indican las relaciones disponibles para el modelo:
 * @property Alumno $matriculaalumno0
 */
class SolicitudBajaSemestre extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático de la clase de AR especificada.
	 * @return SolicitudBajaSemestre la clase del modelo estático
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
		return 'solicitud_baja_semestre';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('periodo, domicilio, motivo, telefono, extranjero', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('periodo', 'length', 'max'=>16),
			array('anio', 'length', 'max'=>4),
			array('domicilio', 'length', 'max'=>100),
			array('motivo', 'length', 'max'=>500),
			array('telefono', 'length', 'max'=>12),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('id, fechahora, status, periodo, anio, domicilio, motivo, telefono, extranjero, matriculaalumno', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: posiblemente tengrá que ajustar el nombre de la relación y de la
		// clase relacionada para las siguientes relaciones, que se generan automáticamente.
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
			'domicilio' => 'Domicilio',
			'motivo' => 'Motivo',
			'telefono' => 'Teléfono',
			'extranjero' => 'Extranjero',
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
				
		// Obtiene el rol del usuario actual.
		$rol = Yii::app()->user->rol;
		
		// Obtiene el nombre de usuario del usuario actual.
		$nombre_de_usuario = Yii::app()->user->id;
		
		// Valida si el usuario actual es un director, un asistente o una secretaria.
		if($rol == 'Director' || $rol == 'Asistente'|| $rol == 'Secretaria'){
		
			// Criterios para que el usuario actual solo pueda buscar las
			// solicitudes de baja de semestre hechas en las carreras en las que
			// labora
			$criteria->join = 'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nombre_de_usuario.'\'';
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('fechahora',$this->fechahora,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('periodo',$this->periodo,true);
		$criteria->compare('anio',$this->anio,true);
		$criteria->compare('domicilio',$this->domicilio,true);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('extranjero',$this->extranjero);
		$criteria->compare('matriculaalumno',$this->matriculaalumno,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}