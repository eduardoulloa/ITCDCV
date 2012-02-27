<?php

class SolicitudProblemasInscripcionController extends Controller
{
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
		$adminActions=array('index','admin','update','delete','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
				
		
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
		
		//obtiene todos los directores de carrera
		$consulta=Empleado::model()->findAll($criteria);
		
		//arreglo con todos los directores de carrera
		$directores = array();
		
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
		
		//Acciones del admin.
		$admin_acciones = array('index','create','update','view','admin','delete');
		
		//Condiciones para buscar al super admin
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		//Query para encontrar al super admin
		//$consulta_super_admin = Admin::model()->findAllByPk('admin', $criteria_super_admin);
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		$admin = array();
		
		
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
		
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','view'),
				'users'=>array('@'),
			),
			array('allow', // acciones de los directores de carrera
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			array('allow', // Acciones de los admins.
				'actions'=>$admin_acciones,
				'users'=>$admin,
			),
			array('allow', // acciones de los asistentes de docencia
				'actions'=>$adminActions,
				'users'=>$asistentes,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SolicitudProblemasInscripcion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SolicitudProblemasInscripcion']))
		{
			$model->attributes=$_POST['SolicitudProblemasInscripcion'];
			$mat = Yii::app()->user->id;
			$model->setAttribute('matriculaalumno',$mat);
			$model->setAttribute('anio',date('Y'));
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SolicitudProblemasInscripcion']))
		{
			$model->attributes=$_POST['SolicitudProblemasInscripcion'];
			if($model->save()) {
				if($this->needsToSendMail($model)) {
					EMailSender::sendEmail($this->createEmailBody($model), 'Problema de Inscripcion', 
													getEmailAddress($model->matriculaalumno));
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function needsToSendMail($model)
	{
		return $model->attributes['status'] == 'terminada';
	}
	
	public function createEmailBody($model) 
	{
		$body = "Tu Problema de Inscripcion ha cambiado al status Terminado.\n";
		$body .= "\nComentarios: ".$model->comentarios;
		return $body;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Enlista todos los modelos, dependiendo del rol del usuario.
	 */
	public function actionIndex()
	{
		/*$criteria = NULL;
	
		if (Yii::app()->user->rol == 'Alumno'){ //el usuario es un alumno
		$mat = Yii::app()->user->id;
			$criteria = new CDbCriteria(array(
					'condition'=>'status!=\'Terminada\' AND matriculaalumno ='.$mat));
		}else if(Yii::app()->user->rol == 'Director'){ //el usuario es un director
			$criteria = new CDbCriteria(array(
					'condition'=>'status!=\'Terminada\''));
		}
		
		$solicitudes=array();
		
		$solicitudes=SolicitudProblemasInscripcion::model()->findall($criteria);
		
		$dataProvider= new CArrayDataProvider(
				$solicitudes, array(
					'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora'
						),
					'pagination'=> array(
						'pageSize'=>100,
						),
					));*/
	
		
		if(Yii::app()->user->rol == 'Alumno'){
		
			$mat = Yii::app()->user->id;
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
					
			$solicitudes=SolicitudProblemasInscripcion::model()->findall($criteria);
			
			$dataProvider= new CArrayDataProvider(
					$solicitudes, array(
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
						
		}else if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
			
			$nomina = Yii::app()->user->id;
		
			
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));

			$solicitudes_para_directores = SolicitudProblemasInscripcion::model()->findall($criteria_directores);
			
			$dataProvider = new CArrayDataProvider ($solicitudes_para_directores, array(
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
	
		}else if(Yii::app()->user->rol == 'Admin'){
		
			$dataProvider = new CActiveDataProvider('SolicitudProblemasInscripcion');
		}
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SolicitudProblemasInscripcion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SolicitudProblemasInscripcion']))
			$model->attributes=$_GET['SolicitudProblemasInscripcion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SolicitudProblemasInscripcion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='solicitud-problemas-inscripcion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
