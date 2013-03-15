<?php

/**
 * This is the model class for table "solicitud_carta_recomendacion".
 *
 * The followings are the available columns in table 'solicitud_carta_recomendacion':
 * @property integer $id
 * @property string $fechahora
 * @property string $status
 * @property string $tipo
 * @property string $formato
 * @property string $comentarios
 * @property string $matriculaalumno
 *
 * The followings are the available model relations:
 * @property Alumno $matriculaalumno0
 */
class SolicitudCartaRecomendacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolicitudCartaRecomendacion the static model class
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
		return 'solicitud_carta_recomendacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo','required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('status, matriculaalumno', 'length', 'max'=>9),
			array('formato', 'length', 'max'=>30),
			array('comentarios', 'length', 'max'=>500),
			array('tipo','length','max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fechahora, status, tipo, formato, comentarios, matriculaalumno', 'safe', 'on'=>'search'),
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
			'tipo' => 'Tipo',
			'formato' => 'Formato',
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
		
		/*Modifico el query para que directores de carrera, asistentes y secretarias de alguna dirección solo puedan
		buscar sus solicitudes correspondientes*/
		
		$rol = Yii::app()->user->rol;
		$nombre_de_usuario = Yii::app()->user->id;
		
		if($rol == 'Director' || $rol == 'Asistente'|| $rol == 'Secretaria'){
			$criteria->join = 'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nombre_de_usuario.'\'';
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('fechahora',$this->fechahora,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('formato',$this->formato,true);
		$criteria->compare('comentarios',$this->comentarios,true);
		$criteria->compare('matriculaalumno',$this->matriculaalumno,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}