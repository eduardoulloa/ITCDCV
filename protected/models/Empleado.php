<?php

/**
 * This is the model class for table "empleado".
 *
 * The followings are the available columns in table 'empleado':
 * @property string $nomina
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $password
 * @property string $puesto
 *
 * The followings are the available model relations:
 * @property Carrera[] $carreras
 */
class Empleado extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Empleado the static model class
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
		return 'empleado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomina, nombre, apellido_paterno, password, puesto', 'required'),
			array('nomina', 'length', 'max'=>9),
			array('nombre, apellido_paterno, apellido_materno', 'length', 'max'=>60),
			array('password', 'length', 'max'=>45),
			array('puesto', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nomina, nombre, apellido_paterno, apellido_materno, password, puesto', 'safe', 'on'=>'search'),
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
			'carreras' => array(self::MANY_MANY, 'Carrera', 'carrera_tiene_empleado(nomina, idcarrera)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nomina' => 'Nómina',
			'nombre' => 'Nombre',
			'apellido_paterno' => 'Apellido paterno',
			'apellido_materno' => 'Apellido materno',
			'password' => 'Contraseña',
			'puesto' => 'Puesto',
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

		$criteria->compare('nomina',$this->nomina,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido_paterno',$this->apellido_paterno,true);
		$criteria->compare('apellido_materno',$this->apellido_materno,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('puesto',$this->puesto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}