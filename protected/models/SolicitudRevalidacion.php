<?php

/**
 * This is the model class for table "solicitud_revalidacion".
 *
 * The followings are the available columns in table 'solicitud_revalidacion':
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
 * The followings are the available model relations:
 * @property Alumno $matriculaalumno0
 */
class SolicitudRevalidacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolicitudRevalidacion the static model class
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
		return 'solicitud_revalidacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, periodo, anio, clave_revalidar, nombre_revalidar, nombre_cursada, universidad, matriculaalumno', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('periodo', 'length', 'max'=>16),
			array('anio', 'length', 'max'=>4),
			array('clave_revalidar, clave_cursada', 'length', 'max'=>10),
			array('nombre_revalidar, nombre_cursada, universidad', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fechahora, status, periodo, anio, clave_revalidar, nombre_revalidar, clave_cursada, nombre_cursada, universidad, matriculaalumno', 'safe', 'on'=>'search'),
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
			'matriculaalumno0' => array(self::BELONGS_TO, 'Alumno', 'matriculaalumno'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechahora' => 'Fecha',
			'status' => 'Status',
			'periodo' => 'Periodo',
			'anio' => 'Anio',
			'clave_revalidar' => 'Clave de Materia a Revalidar',
			'nombre_revalidar' => 'Nombre de Materia a Revalidar',
			'clave_cursada' => 'Clave de Materia Cursada',
			'nombre_cursada' => 'Nombre de Materia Cursada',
			'universidad' => 'Universidad',
			'matriculaalumno' => 'Matricula',
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