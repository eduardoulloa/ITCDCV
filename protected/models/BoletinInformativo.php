<?php

/**
 * This is the model class for table "boletin_informativo".
 *
 * The followings are the available columns in table 'boletin_informativo':
 * @property integer $id
 * @property string $mensaje
 * @property string $fechahora
 * @property integer $semestre1
 * @property integer $semestre2
 * @property integer $semestre3
 * @property integer $semestre4
 * @property integer $semestre5
 * @property integer $semestre6
 * @property integer $semestre7
 * @property integer $semestre8
 * @property integer $semestre9
 * @property integer $exatec
 * @property integer $idcarrera
 *
 * The followings are the available model relations:
 * @property Carrera $idcarrera0
 */
class BoletinInformativo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BoletinInformativo the static model class
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
		return 'boletin_informativo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mensaje','required'),
			//array('semestre1, semestre2, semestre3, semestre4, semestre5, semestre6, semestre7, semestre8, semestre9, exatec', 'almenosuno'),
			array('semestre1, semestre2, semestre3, semestre4, semestre5, semestre6, semestre7, semestre8, semestre9, exatec, idcarrera', 'numerical', 'integerOnly'=>true),
			array('mensaje', 'length', 'max'=>10000),
			array('subject', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mensaje, fechahora, semestre1, semestre2, semestre3, semestre4, semestre5, semestre6, semestre7, semestre8, semestre9, exatec, idcarrera', 'safe', 'on'=>'search'),
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
			'mensaje' => 'Mensaje',
			'subject'=> 'Asunto',
			'fechahora' => 'Fecha',
			'semestre1' => 'Semestre 1',
			'semestre2' => 'Semestre 2',
			'semestre3' => 'Semestre 3',
			'semestre4' => 'Semestre 4',
			'semestre5' => 'Semestre 5',
			'semestre6' => 'Semestre 6',
			'semestre7' => 'Semestre 7',
			'semestre8' => 'Semestre 8',
			'semestre9' => 'Semestre 9',
			'exatec' => 'Exatec',
			'idcarrera' => 'Id de carrera',
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
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('subject',$this->subject);
		$criteria->compare('fechahora',$this->fechahora,true);
		$criteria->compare('semestre1',$this->semestre1);
		$criteria->compare('semestre2',$this->semestre2);
		$criteria->compare('semestre3',$this->semestre3);
		$criteria->compare('semestre4',$this->semestre4);
		$criteria->compare('semestre5',$this->semestre5);
		$criteria->compare('semestre6',$this->semestre6);
		$criteria->compare('semestre7',$this->semestre7);
		$criteria->compare('semestre8',$this->semestre8);
		$criteria->compare('semestre9',$this->semestre9);
		$criteria->compare('exatec',$this->exatec);
		$criteria->compare('idcarrera',$this->idcarrera);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/*public function validar(){
		
			if (($this->semestre1==NULL) && 
			($this->semestre2== NULL) && 
			($this->semestre3== NULL) &&
			($this->semestre4== NULL) &&
			($this->semestre5== NULL) &&
			($this->semestre6== NULL) &&
			($this->semestre7== NULL) &&
			($this->semestre8== NULL) &&
			($this->semestre9== NULL) &&
			($this->exatec== NULL)){
				$this->addError($this->semestre1,'Debe seleccionar al menos un grupo de destinatarios');
				return 0;
			}
			return 1;
		
	}*/
	
	public function validar(){
		
			if (($this->attributes['semestre1']==0) && 
			($this->attributes['semestre2']== 0) && 
			($this->attributes['semestre3']== 0) &&
			($this->attributes['semestre4']== 0) &&
			($this->attributes['semestre5']== 0) &&
			($this->attributes['semestre6']== 0) &&
			($this->attributes['semestre7']== 0) &&
			($this->attributes['semestre8']== 0) &&
			($this->attributes['semestre9']== 0) &&
			($this->attributes['exatec']== 0)){
				$this->addError($this->attributes['semestre1'],'Debe seleccionar al menos un grupo de destinatarios');
			}
		
	}
	
	
}