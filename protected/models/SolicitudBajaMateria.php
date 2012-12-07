<?php

/**
 * This is the model class for table "solicitud_baja_materia".
 *
 * The followings are the available columns in table 'solicitud_baja_materia':
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
 * The followings are the available model relations:
 * @property Alumno $matriculaalumno0
 */
class SolicitudBajaMateria extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolicitudBajaMateria the static model class
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
		return 'solicitud_baja_materia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, motivo, clave_materia, nombre_materia, grupo, atributo, unidades, periodo, anio', 'required'),
			array('id, unidades_materia, grupo, unidades', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('motivo', 'length', 'max'=>500),
			array('clave_materia, atributo', 'length', 'max'=>10),
			array('nombre_materia', 'length', 'max'=>100),
			array('periodo', 'length', 'max'=>16),
			array('anio', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fechahora, status, motivo, clave_materia, nombre_materia, unidades_materia, grupo, atributo, unidades, periodo, anio, matriculaalumno', 'safe', 'on'=>'search'),
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