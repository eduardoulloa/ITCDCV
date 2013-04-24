<?php
 
 /**
 * Esta es la clase modelo para la tabla "boletin_informativo".
 *
 * A continuación se indican las columnas disponibles en la tabla 'boletin_informativo':
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
 * A continuación se indica la relación disponible para el modelo:
 * @property Carrera $idcarrera0
 */
class BoletinInformativo extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático para la clase de AR especificada.
	 * @return BoletinInformativo la clase del modelo estático
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
		return 'boletin_informativo';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('mensaje','required'),
			//array('semestre1, semestre2, semestre3, semestre4, semestre5, semestre6, semestre7, semestre8, semestre9, exatec', 'almenosuno'),
			array('semestre1, semestre2, semestre3, semestre4, semestre5, semestre6, semestre7, semestre8, semestre9, exatec, idcarrera', 'numerical', 'integerOnly'=>true),
			array('mensaje', 'length', 'max'=>10000),
			array('subject', 'length', 'max'=>50),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('id, mensaje, fechahora, semestre1, semestre2, semestre3, semestre4, semestre5, semestre6, semestre7, semestre8, semestre9, exatec, idcarrera', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: posiblemente usted requerirá ajustar el nombre de la relación y de la
		// clase relacionada para las relaciones generadas automáticamente a continuación.
		return array(
			'idcarrera0' => array(self::BELONGS_TO, 'Carrera', 'idcarrera'),
		);
	}

	/**
	 * @return array etiquetas de atributos personalizadas (nombre=>etiqueta)
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
			'idcarrera' => 'ID de carrera',
		);
	}

	/**
	 * Obtiene una lista de modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos (data provider) que puede devolver modelos en base a las
	 * condiciones de búsqueda/filtro.
	 */
	public function search()
	{
		// Advertencia: Por favor modifique el siguiente código para remover los atributos que
		// no deben ser buscados.

		// Crea una nueva variable de CDbCriteria.
		$criteria=new CDbCriteria;
		
		// Almacena el nombre de usuario del usuario actual.
		$nombre_de_usuario = Yii::app()->user->id;
		
		// Almacena el rol del usuario actual.
		$rol = Yii::app()->user->rol;
		
		// Valida si el usuario actual es un director de carrera.
		if($rol == 'Director'){
			
			// Criterios para que los directores puedan únicamente buscar sus
			// propios boletines.
			$criteria->join = 'JOIN carrera_tiene_empleado AS c ON t.idcarrera = c.idcarrera AND
			c.nomina = \''.$nombre_de_usuario.'\'';
			
		}

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
	
	/**
	 * Valida que el boletín informativo esté dirigido a al menos un
	 * grupo de destinatarios, ya sean alumnos o exalumnos.
	 */
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