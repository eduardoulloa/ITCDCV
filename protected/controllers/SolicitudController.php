<?php

class SolicitudController extends Controller


{
	/**
	 * Enlista a todos los modelos, dependiendo del rol del usuario.
	 */
	public function actionIndex(){
		
		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){
			
			// Obtiene el nombre de usuario (matrícula) del
			// usuario actual.
			$mat = Yii::app()->user->id;
			
			// Criterios para obtener todos los
			// modelos de todas las solicitudes del
			// usuario actual.
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
			
			// Obtiene los modelos de las solicitudes de baja de materia del
			// usuario actual.
			$solicitud1=SolicitudBajaMateria::model()->findall($criteria);
			
			// Obtiene los modelos de las solicitudes de baja de semestre del
			// usuario actual.
			$solicitud2=SolicitudBajaSemestre::model()->findall($criteria);
			
			// Obtiene los modelos de la solicitudes de carta de recomendación del
			// usuario actual.
			$solicitud3=SolicitudCartaRecomendacion::model()->findall($criteria);
			
			// Obtiene los modelos de las solicitudes de problemas de inscripción del
			// usuario actual.
			$solicitud4=SolicitudProblemasInscripcion::model()->findall($criteria);
			
			// Obtiene los modelos de las solicitudes de revalidación de materia del
			// usuario actual.
			$solicitud5=SolicitudRevalidacion::model()->findall($criteria);
		
			// Arreglo para almacenar en conjunto todos los modelos de todas las
			// solicitudes del usuario actual.
			$modelArray = array_merge($solicitud1,$solicitud2,$solicitud3,
					$solicitud4,$solicitud5);

			// Criterios para ordenar las diferentes solicitudes del
			// usuario actual, al momento de desplegarlas.
			$dataProvider= new CArrayDataProvider(
					$modelArray, array(
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
			
			
		// Valida si el usuario actual es un director de carrera.				
		}else if (Yii::app()->user->rol == 'Director'){
			
			// Almacena el nombre de usuario (nómina) del
			// usuario actual
			$nomina = Yii::app()->user->id;
		
			// Criterios para obtener todas las solicitudes de
			// aquellos alumnos del director de carrera.
			$criteria = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));

			// Obtiene los modelos de las solicitudes de baja de
			// materia de los alumnos del director de carrera.
			$solicitud1=SolicitudBajaMateria::model()->findall($criteria);
			
			// Obtiene los modelos de las solicitudes de baja de
			// semestre de los alumnos del director de carrera.
			$solicitud2=SolicitudBajaSemestre::model()->findall($criteria);
			
			// Obtiene los modelos de las solicitudes de carta de
			// recomendación de los alumnos del director de carrera.
			$solicitud3=SolicitudCartaRecomendacion::model()->findall($criteria);
			
			// Obtiene los modelos de las solicitudes de problemas de
			// inscripción de los alumnos del director de carrera.
			$solicitud4=SolicitudProblemasInscripcion::model()->findall($criteria);
			
			// Oabtiene los modelos de las solicitudes de revalidación de
			// materia de los alumnos del director de carrera.
			$solicitud5=SolicitudRevalidacion::model()->findall($criteria);
			
			// Arreglo para almacenar en conjunto todos los modelos de
			// todas las solicitudes de los alumnos del director de carrera.
			$modelArray = array_merge($solicitud1,$solicitud2,$solicitud3,
					$solicitud4,$solicitud5);

			// Criterios para ordenar las diferentes solicitudes de
			// los alumnos del director de carrera, al momento de
			// desplegarlas.
			$dataProvider= new CArrayDataProvider(
					$modelArray, array(
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
			
		// Valida si el usuario actual es un administrador general.
		}else if(Yii::app()->user->rol == 'Admin'){
			
			// Obtiene los modelos de todas las solicitudes de
			// baja de materia.
			$solicitud1=SolicitudBajaMateria::model()->findall();
			
			// Obtiene los modelos de todas las solicitudes de
			// baja de semestre
			$solicitud2=SolicitudBajaSemestre::model()->findall();
			
			// Obtiene los modelos de todas las solicitudes de
			// carta de recomendación.
			$solicitud3=SolicitudCartaRecomendacion::model()->findall();
			
			// Obtiene los modelos de todas las solicitudes de
			// problemas de inscripción.
			$solicitud4=SolicitudProblemasInscripcion::model()->findall();
			
			// Obtiene los modelos de todas las solicitudes de
			// revalidación de materia.
			$solicitud5=SolicitudRevalidacion::model()->findall();
			
			// Arreglo para almacenar en conjunto las diferentes
			// solicitudes.
			$modelArray = array_merge($solicitud1,$solicitud2,$solicitud3,
					$solicitud4,$solicitud5);

			// Criterios para ordenar las diferentes solicitudes al
			// momento de desplegarlas.
			$dataProvider= new CArrayDataProvider(
					$modelArray, array(
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
		}

		// Se despliega una página con
		// información de las diferentes solicitudes.
		$this->render('index',array(
			'model'=>$dataProvider,
		));
	}

	/**
	 * Establece los criterios de búsqueda para
	 * obtener aquellas solicitudes que aún no han
	 * sido atendidas, es decir, que tienen un estatus distinto a
	 * 'Terminada'.
	 * @return CDbCriteria criterios de búsqueda para encontrar las solicitudes
	 */
	public function getCriteria() {
		return new CDbCriteria(array('condition'=>'status!=\'Terminada\''));
	}

	/**
	 * Obtiene la cantidad total de solicitudes en la
	 * base de datos que aún no han sido atendidas.
	 * @return integer cantidad de solicitudes que aún no han sido atendidas
	 */
	public function solicitudesTotales() {
		return SolicitudBajaMateria::model()->count($this->getCriteria()) +
			SolicitudBajaSemestre::model()->count($this->getCriteria()) +
			SolicitudCartaRecomendacion::model()->count($this->getCriteria()) +
			SolicitudProblemasInscripcion::model()->count($this->getCriteria()) +
			SolicitudRevalidacion::model()->count($this->getCriteria());
	}
	
	/**
	 * Obtiene la cantidad total de solicitudes de
	 * baja de materia que aún no han sido atendidas.
	 * @return integer cantidad de solicitudes de baja de materia que aún no han sido atendidas
	 */
	public function solicitudBajaMateriaCount() {
		return SolicitudBajaMateria::model()->count(getCriteria());
	}
	
	/**
	 * Obtiene la cantidad total de solicitudes de
	 * baja de semestre que aún no han sido atendidas.
	 * @return integer cantidad de solicitudes de baja de semestre que aún no han sido atendidas
	 */
	public function solicitudBajaSemestreCount() {
		return SolicitudBajaSemestre::model()->count(getCriteria());
	}

	/**
	 * Obtiene la cantidad total de solicitudes de
	 * carta de recomendación que aún no han sido atendidas.
	 * @return integer cantidad de solicitudes de carta de recomendación que aún no han sido atendidas
	 */
	public function solicitudCartaRecomendacionCount() {
		return SolicitudCartaRecomendacion::model()->count(getCriteria());
	}

	/**
	 * Obtiene la cantidad total de solicitudes de
	 * problemas de inscripción que aún no han sido atendidas.
	 * @return integer cantidad de solicitudes de problemas de inscripción que aún no han sido atendidas
	 */
	public function solicitudProblemasInscripcionCount() {
		return SolicitudProblemasInscripcion::model()->count(getCriteria());
	}

	/**
	 * Obtiene la cantidad total de solicitudes de
	 * de revalidación de materia.
	 * @return integer cantidad de solicitudes de revalidación de materia que aún no han sido atendidas
	 */
	public function solicitudRevalidacionCount() {
		return SolicitudRevalidacion::model()->count(getCriteria());
	}

	/**
	 * @var string la distribución por defecto para las vistas. Por defecto es '//layouts/column2', lo cual
	 * indica una distribución de dos columnas. Ver 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array filtros de acción
	 */
	public function filters()
	{
		return array(
			'accessControl', // Realiza control de acceso para operaciones CRUD.
		);
	}

	/**
	 * Especifica las reglas de control de acceso.
	 * Este método es utilizado por el filtro 'accessControl'.
	 * @return array reglas de control de acceso
	 */
	public function accessRules()
	{
		// Arreglo con las acciones de los directores de
		// carrera
		$adminActions=array('index','admin','delete','view_all','view',
				'solicitud',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion',
				'solicitudBajaMateriaCount', 'solicitudBajaSemestreCount',
				'solicitudCartaRecomendacionCount', 
				'solicitudProblemasInscripcionCount',
				'solicitudRevalidacionCount', 'solicitudesTotales');
				
		// Criterios para obtener los nombres de
		// usuario (nóminas) de los directores de
		// carrera
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
						
		// Obtiene los modelos de los directores de
		// carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de usuario (nóminas) de
		// los directores de carrera
		$directores = array();
		
		// Almacena en el arreglo $directores los nombres de usuario (nóminas) de
		// los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de usuario de
		// los asistentes y secretarias
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto=\'Secretaria\''));
		
		// Obtiene los modelos de los asistentes y secretarias.
		$consulta_asistente = Empleado::model()->findAll($asistente_criteria);
		
		// Arreglo para almacenar los nombres de usuario de
		// los asistentes y secretarias.
		$asistentes = array();
		
		// Almacena en el arreglo $asistentes los
		// nombres de usuario de los asistentes y secretarias.
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de
		// usuario de los administradores generales.
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de
		// los administradores generales.
		$admin = array();
		
		// Almacena en el arreglo $admin los nombres de
		// usuario de los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
		return array(
			
			// Les permite a los directores de carrera realizar
		    // acciones de 'index', 'admin', 'delete', 'view_all', 'view',
		    // 'solicitud', 'solicitudBajaMateria', 'solicitudBajaSemestre',
		    // 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion',
		    // 'solicitudRevalidacion', 'solicitudBajaMateriaCount', 
		    // 'solicitudBajaSemestreCount', 'solicitudCartaRecomendacionCount', 
		    // 'solicitudProblemasInscripcionCount', 'solicitudRevalidacionCount' y 'solicitudesTotales'
			array('allow', 
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			
			// Niega el acceso a los asistentes y a las secretarias.	
			array('deny',
				'users'=>$asistentes,
			),
			
			// Les permite a los usuarios autenticados realizar acciones de 'create' y 'update'.
			array('allow',
				'actions'=>array('index','create','update','lista','view'), //quite index
				'users'=>array('@'),
			),
			
			// Les permite a los administradores generales realizar acciones de
			// 'index', 'create', 'update' y 'admin'.
			array('allow',
				'actions'=>array('index','create','update','admin'), 
				'users'=>$admin,
			),
			
			// Niega a todos los usuarios.
			array('deny',
				'users'=>array('*'),
			),
			
		);
	}
}
