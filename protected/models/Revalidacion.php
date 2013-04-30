<?php

/**
 * Esta es la clase modelo para la tabla "revalidación".
 *
 * A continuación se indican las columnas disponibles en la tabla 'revalidacion':
 * @property integer $id
 * @property string $fechahora
 * @property string $universidad
 * @property string $clave_materia_local
 * @property string $nombre_materia_local
 * @property string $clave_materia_cursada
 * @property string $nombre_materia_cursada
 * @property string $periodo_de_revalidacion
 * @property string $anio_de_revalidacion
 * @property integer $idcarrera
 *
 * A continuación se indican las relaciones disponibles para el modelo:
 * @property Carrera $idcarrera0
 */
class Revalidacion extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático de la clase de AR especificada.
	 * @return Revalidacion la clase del modelo estático
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
		return 'revalidacion';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('fechahora, universidad, clave_materia_local, nombre_materia_local, clave_materia_cursada, nombre_materia_cursada, periodo_de_revalidacion, anio_de_revalidacion, idcarrera', 'required'),
			array('idcarrera', 'numerical', 'integerOnly'=>true),
			array('universidad, nombre_materia_local, nombre_materia_cursada', 'length', 'max'=>100),
			array('clave_materia_local', 'length', 'max'=>10),
			array('clave_materia_cursada', 'length', 'max'=>20),
			array('periodo_de_revalidacion', 'length', 'max'=>16),
			array('anio_de_revalidacion', 'length', 'max'=>4),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('id, fechahora, universidad, clave_materia_local, nombre_materia_local, clave_materia_cursada, nombre_materia_cursada, periodo_de_revalidacion, anio_de_revalidacion, idcarrera', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: Posiblemente tendrá que ajustar el nombre de la relación y de la
		// clase relacionada para las siguientes relaciones que se generan automáticamente.
		return array(
			'idcarrera0' => array(self::BELONGS_TO, 'Carrera', 'idcarrera'),
		);
	}

	/**
	 * @return array etiquetas personalizadas para los atributos (nombre=>etiqueta)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechahora' => 'Fecha de registro en DCV',
			'universidad' => 'Universidad',
			'clave_materia_local' => 'Clave de la materia local',
			'nombre_materia_local' => 'Nombre de la materia local',
			'clave_materia_cursada' => 'Clave de la materia cursada',
			'nombre_materia_cursada' => 'Nombre de la materia cursada',
			'periodo_de_revalidacion' => 'Periodo de revalidación',
			'anio_de_revalidacion' => 'Año de revalidación',
			'idcarrera' => 'Idcarrera',
		);
	}

	/**
	 * Devuelve una lista de modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos (data provider) que puede devolver los modelos en base a
	 * las condiciones de búsqueda/filtro.
	 */
	public function search()
	{
		// Advertencia: Por favor modifique el siguiente código para remover aquellos atributos que
		// no deben ser buscados.
		
		// Crea un nuevo modelo de CDbCriteria
		$criteria=new CDbCriteria;
				
		// Almacena el rol del usuario actual.
		$rol = Yii::app()->user->rol;
		
		// Almacena el nombre de usuario del usuario actual.
		$nombre_de_usuario = Yii::app()->user->id;
		
		// Valida si el usuario actual es un director, asistente o secretaria.
		if($rol == 'Director' || $rol == 'Asistente'|| $rol == 'Secretaria'){
		
			// Criterios para que el usuario actual solo pueda buscar aquellas revalidaciones hechas en
			// las carreras en las que labora.
			$criteria->join = 'JOIN carrera_tiene_empleado AS c ON t.idcarrera = c.idcarrera AND c.nomina = \''.$nombre_de_usuario.'\'';
			
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('fechahora',$this->fechahora,true);
		$criteria->compare('universidad',$this->universidad,true);
		$criteria->compare('clave_materia_local',$this->clave_materia_local,true);
		$criteria->compare('nombre_materia_local',$this->nombre_materia_local,true);
		$criteria->compare('clave_materia_cursada',$this->clave_materia_cursada,true);
		$criteria->compare('nombre_materia_cursada',$this->nombre_materia_cursada,true);
		$criteria->compare('periodo_de_revalidacion',$this->periodo_de_revalidacion,true);
		$criteria->compare('anio_de_revalidacion',$this->anio_de_revalidacion,true);
		$criteria->compare('idcarrera',$this->idcarrera);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}