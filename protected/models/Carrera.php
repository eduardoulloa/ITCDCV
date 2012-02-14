<?php

/**
 * This is the model class for table "carrera".
 *
 * The followings are the available columns in table 'carrera':
 * @property integer $id
 * @property string $siglas
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Alumno[] $alumnos
 * @property BoletinInformativo[] $boletinInformativos
 * @property Empleado[] $empleados
 */
class Carrera extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Carrera the static model class
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
		return 'carrera';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('siglas, nombre', 'required'),
			array('siglas', 'length', 'max'=>5),
			array('nombre', 'length', 'max'=>80),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, siglas, nombre', 'safe', 'on'=>'search'),
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
			'alumnos' => array(self::HAS_MANY, 'Alumno', 'idcarrera'),
			'boletinInformativos' => array(self::HAS_MANY, 'BoletinInformativo', 'idcarrera'),
			'empleados' => array(self::MANY_MANY, 'Empleado', 'carrera_tiene_empleado(idcarrera, nomina)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'siglas' => 'Siglas',
			'nombre' => 'Nombre',
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
		$criteria->compare('siglas',$this->siglas,true);
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}