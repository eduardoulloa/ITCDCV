<?php
/**
 * Esta es la clase modelo para la tabla "empleado".
 *
 * A continuación se indican las columnas disponibles en la tabla 'empleado':
 * @property string $nomina
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $password
 * @property string $puesto
 *
 * A continuación se indican las relaciones disponibles para el modelo:
 * @property Carrera[] $carreras
 */
class Empleado extends CActiveRecord
{
	/**
	 * Devuelve el modelo estático para la clase de AR especificada.
	 * @return Empleado la clase del modelo estático
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
		return 'empleado';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que
		// serán ingresados por usuarios.
		return array(
			array('nomina, nombre, apellido_paterno, password, puesto', 'required'),
			array('nomina', 'length', 'max'=>9),
			array('nombre, apellido_paterno, apellido_materno', 'length', 'max'=>60),
			array('password', 'length', 'max'=>45),
			array('puesto', 'length', 'max'=>11),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('nomina, nombre, apellido_paterno, apellido_materno, password, puesto', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: posiblemente usted tendrá que ajustar el nombre y el nombre de la
		// clase relacionada para las siguientes relaciones que se generan automáticamente:
		return array(
			'carreras' => array(self::MANY_MANY, 'Carrera', 'carrera_tiene_empleado(nomina, idcarrera)'),
		);
	}

	/**
	 * @return array etiquetas de atributos personalizadas (nombre=>etiqueta)
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
	 * Obtiene una lista de modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos (data provider) que puede devolver modelos en base a las
	 * condiciones de de búsqueda/filtro
	 */
	public function search()
	{		
		// Advertencia: Por favor modifique el siguiente código para remover aquellos atributos que
		// no deben ser buscados.
	
		// Crea un nuevo modelo de CDbCriteria.
		$criteria=new CDbCriteria;
		
		// Almacena el rol del usuario actual.
		$rol = Yii::app()->user->rol;
		
		// Almacena el nombre de usuario del usuario actual.
		$nombre_de_usuario = Yii::app()->user->id;
		
		// Valida si el usuario actual es un director de carrera.
		if($rol == 'Director'){
			
			// Criterios para que los directores de carrera puedan buscar únicamente a los empleados
			// que laboran en las carreras donde los directores laboran.
			$criteria->condition = 'nomina IN (SELECT nomina FROM carrera_tiene_empleado WHERE idcarrera IN (SELECT idcarrera FROM carrera_tiene_empleado WHERE nomina =  \''.$nombre_de_usuario.'\') GROUP BY nomina)';
			$criteria->group = 'nomina';

		}

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