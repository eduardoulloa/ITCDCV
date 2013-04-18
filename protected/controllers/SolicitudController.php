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
			
			$nomina = Yii::app()->user->id;
		
			
			$criteria = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));

			
			$solicitud1=SolicitudBajaMateria::model()->findall($criteria);
			$solicitud2=SolicitudBajaSemestre::model()->findall($criteria);
			$solicitud3=SolicitudCartaRecomendacion::model()->findall($criteria);
			$solicitud4=SolicitudProblemasInscripcion::model()->findall($criteria);
			$solicitud5=SolicitudRevalidacion::model()->findall($criteria);
			
			$modelArray = array_merge($solicitud1,$solicitud2,$solicitud3,
					$solicitud4,$solicitud5);

			$dataProvider= new CArrayDataProvider(
					$modelArray, array(
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
			
	
		}else if(Yii::app()->user->rol == 'Admin'){
			
			
			$solicitud1=SolicitudBajaMateria::model()->findall();
			$solicitud2=SolicitudBajaSemestre::model()->findall();
			$solicitud3=SolicitudCartaRecomendacion::model()->findall();
			$solicitud4=SolicitudProblemasInscripcion::model()->findall();
			$solicitud5=SolicitudRevalidacion::model()->findall();
			
			$modelArray = array_merge($solicitud1,$solicitud2,$solicitud3,
					$solicitud4,$solicitud5);

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

		$this->render('index',array(
			'model'=>$dataProvider,
		));
		
		
		
		
	}

	/*public function actionIndex($action = 'all')
	{
		$dataProvider = NULL;
		$sqlAction = "";
		if (Yii::app()->user->id != 'admin')
			$matricula = Yii::app()->user->name;

		$criteria= new CDbCriteria(array(
					'condition'=> 'status!=\'Terminada\''));
		$solicitud1=array();
		$solicitud2=array();
		$solicitud3=array();
		$solicitud4=array();
		$solicitud5=array();

		if ($action == 'solicitudBajaMateria' || $action == 'all')
			$solicitud1=SolicitudBajaMateria::model()->findall($criteria);
		if ($action == 'solicitudBajaSemestre' || $action == 'all')
			$solicitud2=SolicitudBajaSemestre::model()->findall($criteria);
		if ($action == 'solicitudCartaRecomendacion' || $action == 'all')
			$solicitud3=SolicitudCartaRecomendacion::model()->findall($criteria);
		if ($action == 'solicitudProblemasInscripcion' || $action == 'all')
			$solicitud4=SolicitudProblemasInscripcion::model()->findall($criteria);
		if ($action == 'solicitudRevalidacion' || $action == 'all')
			$solicitud5=SolicitudRevalidacion::model()->findall($criteria);

		$modelArray = array_merge($solicitud1,$solicitud2,$solicitud3,
				$solicitud4,$solicitud5);

		$dataProvider= new CArrayDataProvider(
				$modelArray, array(
					'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora'
						),
					'pagination'=> array(
						'pageSize'=>100,
						),
					));

		$this->render('index',array(
			'model'=>$dataProvider,
		));
	}*/

	public function actionSolicitudBajaMateria() {
		$this->actionIndex('solicitudBajaMateria');
	}

	public function actionSolicitudBajaSemestre() {
		$this->actionIndex('solicitudBajaSemestre');
	}

	public function actionSolicitudCartaRecomendacion() {
		$this->actionIndex('solicitudCartaRecomendacion');
	}

	public function actionSolicitudProblemasInscripcion() {
		$this->actionIndex('solicitudProblemasInscripcion');
	}

	public function actionSolicitudRevalidacion() {
		$this->actionIndex('solicitudRevalidacion');
	}

	public function getCriteria() {
		return new CDbCriteria(array('condition'=>'status!=\'Terminada\''));
	}

	public function solicitudesTotales() {
		return SolicitudBajaMateria::model()->count($this->getCriteria()) +
			SolicitudBajaSemestre::model()->count($this->getCriteria()) +
			SolicitudCartaRecomendacion::model()->count($this->getCriteria()) +
			SolicitudProblemasInscripcion::model()->count($this->getCriteria()) +
			SolicitudRevalidacion::model()->count($this->getCriteria());
	}

	public function solicitudBajaMateriaCount() {
		return SolicitudBajaMateria::model()->count(getCriteria());
	}

	public function solicitudBajaSemestreCount() {
		return SolicitudBajaSemestre::model()->count(getCriteria());
	}

	public function solicitudCartaRecomendacionCount() {
		return SolicitudCartaRecomendacion::model()->count(getCriteria());
	}

	public function solicitudProblemasInscripcionCount() {
		return SolicitudProblemasInscripcion::model()->count(getCriteria());
	}

	public function solicitudRevalidacionCount() {
		return SolicitudRevalidacion::model()->count(getCriteria());
	}

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Especifica las reglas de control de acceso.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		//arreglo con las acciones de los directores
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
				
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
						
		//obtiene todos los directores de carrera
		$consulta=Empleado::model()->findAll($criteria);
		
		//arreglo con todos los directores de carrera
		$directores = array();
		
		array_push($directores, 'admin');
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto=\'Secretaria\''));
		
		//Obtiene a todos los asistentes.
		$consulta_asistente = Empleado::model()->findAll($asistente_criteria);
		
		//Arreglo con todos los directores de carrera.
		$asistentes = array();
		
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		//Condiciones para buscar al super admin
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		//Query para encontrar al super admin
		//$consulta_super_admin = Admin::model()->findAllByPk('admin', $criteria_super_admin);
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		$admin = array();
		
		
		//array_push($admin, $consulta_super_admin);
		
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
		return array(
			/*
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
			//prueba de stash antes de hacer merge
			array('allow', //acciones de los directores de carrera
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			
			array('allow', //acciones de los directores de carrera
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			
			array('deny',  // Negar acceso a los asistentes.
				'users'=>$asistentes,
			),
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','update','lista','view'), //quite index
				'users'=>array('@'),
			),
			array('allow', // Acciones de los admins.
				'actions'=>array('index','create','update','admin'), 
				'users'=>$admin,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
			
					);
	}
}
