<?php

/**
 * This is the model class for table "alumno".
 *
 * The followings are the available columns in table 'alumno':
 * @property string $matricula
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $plan
 * @property integer $semestre
 * @property string $password
 * @property string $anio_graduado
 * @property integer $idcarrera
 * @property string $email
 *
 * The followings are the available model relations:
 * @property Carrera $idcarrera0
 * @property SolicitudBajaMateria[] $solicitudBajaMaterias
 * @property SolicitudBajaSemestre[] $solicitudBajaSemestres
 * @property SolicitudCartaRecomendacion[] $solicitudCartaRecomendacions
 * @property SolicitudProblemasInscripcion[] $solicitudProblemasInscripcions
 * @property SolicitudRevalidacion[] $solicitudRevalidacions
 * @property Sugerencia[] $sugerencias
 */
class Alumno extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Alumno the static model class
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
		return 'alumno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('matricula, nombre, apellido_paterno, plan, semestre, password, idcarrera, email', 'required'),
			array('semestre, idcarrera', 'numerical', 'integerOnly'=>true),
			array('matricula', 'length', 'max'=>30),
			array('nombre, apellido_paterno, apellido_materno', 'length', 'max'=>60),
			array('plan', 'length', 'max'=>10),
			array('password, email', 'length', 'max'=>45),
			array('anio_graduado', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('matricula, nombre, apellido_paterno, apellido_materno, plan, semestre, password, anio_graduado, idcarrera, email', 'safe', 'on'=>'search'),
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
			'solicitudBajaMaterias' => array(self::HAS_MANY, 'SolicitudBajaMateria', 'matriculaalumno'),
			'solicitudBajaSemestres' => array(self::HAS_MANY, 'SolicitudBajaSemestre', 'matriculaalumno'),
			'solicitudCartaRecomendacions' => array(self::HAS_MANY, 'SolicitudCartaRecomendacion', 'matriculaalumno'),
			'solicitudProblemasInscripcions' => array(self::HAS_MANY, 'SolicitudProblemasInscripcion', 'matriculaalumno'),
			'solicitudRevalidacions' => array(self::HAS_MANY, 'SolicitudRevalidacion', 'matriculaalumno'),
			'sugerencias' => array(self::HAS_MANY, 'Sugerencia', 'matriculaalumno'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'matricula' => 'Matrícula',
			'nombre' => 'Nombre',
			'apellido_paterno' => 'Apellido paterno',
			'apellido_materno' => 'Apellido materno',
			'plan' => 'Plan de estudios',
			'semestre' => 'Semestre',
			'password' => 'Contraseña',
			'anio_graduado' => 'Año de graduado',
			'idcarrera' => 'ID de carrera',
			'email' => 'E-mail',
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

		$criteria->compare('matricula',$this->matricula,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido_paterno',$this->apellido_paterno,true);
		$criteria->compare('apellido_materno',$this->apellido_materno,true);
		$criteria->compare('plan',$this->plan,true);
		$criteria->compare('semestre',$this->semestre);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('anio_graduado',$this->anio_graduado,true);
		$criteria->compare('idcarrera',$this->idcarrera);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}