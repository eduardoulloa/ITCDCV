<?php
/**
 * Esta es la clase modelo para la tabla "solicitud_baja_materia".
 *
 * A continuación se indican las columnas disponibles en la tabla 'solicitud_baja_materia':
 * @property integer $id
 * @property string $fechahora
 * @property string $status
 * @property string $motivo
 * @property string $clave_materia
 * @property string $nombre_materia
 * @property integer $unidades_materia
 * @property integer $grupo
 * @property string $atributo
 * @property integer $unidades
 * @property string $periodo
 * @property string $anio
 * @property string $matriculaalumno
 *
 * A continuación se indican las relaciones disponibles para el modelo:
 * @property Alumno $matriculaalumno0
 */
class SolicitudBajaMateria extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático de la clase de AR especificada.
	 * @return SolicitudBajaMateria la clase del modelo estático
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
		return 'solicitud_baja_materia';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('status, motivo, clave_materia, nombre_materia, grupo, atributo, unidades, periodo, anio', 'required'),
			array('id, unidades_materia, grupo, unidades', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('motivo', 'length', 'max'=>500),
			array('clave_materia, atributo', 'length', 'max'=>10),
			array('nombre_materia', 'length', 'max'=>100),
			array('periodo', 'length', 'max'=>16),
			array('anio', 'length', 'max'=>4),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('id, fechahora, status, motivo, clave_materia, nombre_materia, unidades_materia, grupo, atributo, unidades, periodo, anio, matriculaalumno', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: usted posiblemente tendrá que ajustar el nombre de la relación y de
		// la clase relacionada para las siguientes relaciones, que se generan automáticamente.
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
			'motivo' => 'Motivo',
			'clave_materia' => 'Clave de la materia',
			'nombre_materia' => 'Nombre de la materia',
			'unidades_materia' => 'Unidades de la materia',
			'grupo' => 'Grupo',
			'atributo' => 'Atributo',
			'unidades' => 'Unidades',
			'periodo' => 'Periodo',
			'anio' => 'Año',
			'matriculaalumno' => 'Matrícula',
		);
	}

	/**
	 * Devuelve una lista de modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos (data provider) que puede devolver los modelos en base a
	 * las condiciones actuales de búsqueda/filtro.
	 */
	public function search()
	{
		// Advertencia: Por favor modifique el siguiente código para remover aquellos atributos que
		// no deben ser buscados.

		// Crea un nuevo modelo de CDbCriteria.
		$criteria=new CDbCriteria;
				
		// Almacena el rol del usuario actual.
		$rol = Yii::app()->user->rol;
		
		// Almacena el nombre de ususario del usuario actual.
		$nombre_de_usuario = Yii::app()->user->id;
		
		// Valida si el usuario actual es un director de carrera, un asistente o una secretaria.
		if($rol == 'Director' || $rol == 'Asistente'|| $rol == 'Secretaria'){
			
			// Criterios para que el usuario actual solo pueda buscar aquellas solicitudes de
			// baja de materia registradas en las carreras en las que labora.
			$criteria->join = 'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nombre_de_usuario.'\'';
					
		}
		
		$criteria->compare('id',$this->id);
		$criteria->compare('fechahora',$this->fechahora,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('clave_materia',$this->clave_materia,true);
		$criteria->compare('nombre_materia',$this->nombre_materia,true);
		$criteria->compare('unidades_materia',$this->unidades_materia);
		$criteria->compare('grupo',$this->grupo);
		$criteria->compare('atributo',$this->atributo,true);
		$criteria->compare('unidades',$this->unidades);
		$criteria->compare('periodo',$this->periodo,true);
		$criteria->compare('anio',$this->anio,true);
		$criteria->compare('matriculaalumno',$this->matriculaalumno,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}