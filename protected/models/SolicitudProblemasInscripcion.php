<?php

/**
 * This is the model class for table "solicitud_problemas_inscripcion".
 *
 * The followings are the available columns in table 'solicitud_problemas_inscripcion':
 * @property integer $id
 * @property string $fechahora
 * @property string $status
 * @property string $periodo
 * @property string $anio
 * @property integer $unidades
 * @property integer $quitar_prioridades
 * @property string $comentarios
 * @property string $matriculaalumno
 *
 * The followings are the available model relations:
 * @property Alumno $matriculaalumno0
 */
class SolicitudProblemasInscripcion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolicitudProblemasInscripcion the static model class
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
		return 'solicitud_problemas_inscripcion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodo, unidades, quitar_prioridades', 'required'),
			array('id, unidades', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('periodo', 'length', 'max'=>16),
			array('anio', 'length', 'max'=>4),
			array('comentarios', 'length', 'max'=>500),
			array('quitar_prioridades','length','max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fechahora, status, periodo, anio, unidades, quitar_prioridades, comentarios, matriculaalumno', 'safe', 'on'=>'search'),
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
			'periodo' => 'Periodo',
			'anio' => 'Año',
			'unidades' => 'Unidades',
			'quitar_prioridades' => 'Quitar prioridades',
			'comentarios' => 'Comentarios',
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
		$criteria->compare('periodo',$this->periodo,true);
		$criteria->compare('anio',$this->anio,true);
		$criteria->compare('unidades',$this->unidades);
		$criteria->compare('quitar_prioridades',$this->quitar_prioridades);
		$criteria->compare('comentarios',$this->comentarios,true);
		$criteria->compare('matriculaalumno',$this->matriculaalumno,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}