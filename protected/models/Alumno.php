<?php

/**
 * Esta es la clase modelo para la tabla "alumno".
 *
 * A continuación se muestran las columnas disponibles en la tabla 'alumno':
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
 * A continuación se indican las relaciones disponibles para el modelo:
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
	 * Devuelve el modelo estático de la clase de AR especificada.
	 * @return Alumno la clase del modelo estático
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
		return 'alumno';
	}

	/**
	 * @return array reglas de validación para los atributos del modelo
	 */
	public function rules()
	{
		// NOTA: usted solo debe definir reglas para aquellos atributos que 
		// serán ingresados por usuarios.
		return array(
			array('matricula, nombre, apellido_paterno, plan, semestre, password, idcarrera, email', 'required'),
			array('semestre, idcarrera', 'numerical', 'integerOnly'=>true),
			array('matricula', 'length', 'max'=>30),
			array('nombre, apellido_paterno, apellido_materno', 'length', 'max'=>60),
			array('plan', 'length', 'max'=>10),
			array('password, email', 'length', 'max'=>45),
			array('anio_graduado', 'length', 'max'=>4),
			// La siguiente regla es empleada por search().
			// Por favor remueva aquellos atributos que no deben ser buscados.
			array('matricula, nombre, apellido_paterno, apellido_materno, plan, semestre, password, anio_graduado, idcarrera, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array reglas relacionales
	 */
	public function relations()
	{
		// NOTA: posiblemente requerirá ajustar el nombre de la relación y el nombre de clase
		// relacionada para las relaciones generadas automáticamente a continuación.
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
	 * @return array etiquetas de atributos personalizadas (nombre=>etiqueta)
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
	 * Obtiene una lista de los modelos en base a las condiciones actuales de búsqueda/filtro.
	 * @return CActiveDataProvider el proveedor de datos (data provider) que puede devolver modelos en base a las
	 * condiciones de búsqueda/filtro
	 */
	public function search()
	{
		// Advertencia: Por favor modifique el siguiente código para remover aquellos
		// atributos que no deben ser buscados.

		$criteria=new CDbCriteria;
		
		$rol = Yii::app()->user->rol;
		$nombre_de_usuario = Yii::app()->user->id;
		
		// Valida si el usuario actual es un director de carrera.
		if($rol == 'Director'){
			
			// Criterios para que los directores puedan buscar únicamente a los
			// alumnos inscritos en sus carreras.
			$criteria->join = 'JOIN carrera_tiene_empleado AS c ON t.idcarrera = c.idcarrera AND
			c.nomina = \''.$nombre_de_usuario.'\'';
			
		}

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