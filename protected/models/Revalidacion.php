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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'revalidacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fechahora, universidad, clave_materia_local, nombre_materia_local, clave_materia_cursada, nombre_materia_cursada, periodo_de_revalidacion, anio_de_revalidacion, idcarrera', 'required'),
			array('idcarrera', 'numerical', 'integerOnly'=>true),
			array('universidad, nombre_materia_local, nombre_materia_cursada', 'length', 'max'=>100),
			array('clave_materia_local', 'length', 'max'=>10),
			array('clave_materia_cursada', 'length', 'max'=>20),
			array('periodo_de_revalidacion', 'length', 'max'=>16),
			array('anio_de_revalidacion', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fechahora, universidad, clave_materia_local, nombre_materia_local, clave_materia_cursada, nombre_materia_cursada, periodo_de_revalidacion, anio_de_revalidacion, idcarrera', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idcarrera0' => array(self::BELONGS_TO, 'Carrera', 'idcarrera'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		/*Modifico el query para que directores de carrera, asistentes y secretarias de alguna dirección solo puedan
		buscar sus solicitudes correspondientes*/
		
		$rol = Yii::app()->user->rol;
		$nombre_de_usuario = Yii::app()->user->id;
		
		if($rol == 'Director' || $rol == 'Asistente'|| $rol == 'Secretaria'){
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