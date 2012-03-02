<?php

class SolicitudBajaMateriaController extends Controller
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
		$adminActions=array('index','admin','delete','update','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
				
				
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
						
						
		//Obtiene a todos los directores de carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		//Arreglo con todos los directores de carrera.
		$directores = array();
		
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		
		
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto = \'Secretaria\''));
		
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
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
			array('deny',  // Negar acceso a asistentes y secretarias.
				'users'=>$asistentes,
			),
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','view','update'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>$adminActions, // acciones de los directores de carrera
				'users'=>$directores,
			),
			array('allow', 
				'actions'=>$adminActions, // acciones de los admins
				'users'=>$admin,
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
		$model=new SolicitudBajaMateria;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SolicitudBajaMateria']))
		{
			$mat = Yii::app()->user->id;
			
			if(Yii::app()->user->rol == 'Alumno'){
				$model->attributes=$_POST['SolicitudBajaMateria'];
				$model->setAttribute('matriculaalumno',$mat);
				
				$model->setAttribute('anio',date('Y'));
				
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
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

		if(isset($_POST['SolicitudBajaMateria']))
		{
		
			$model->attributes=$_POST['SolicitudBajaMateria'];

			if($model->save()) {
				if($this->needsToSendMail($model)) {
					EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
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
		$body = "";
		$body .= "\nClave de la materia: ".$model->clave_materia;
		$body .= "\nNombre de la materia: ".$model->nombre_materia;
		return $body;
	}
	
	public function createSubject($model)
	{
		$subject = "Solicitud de Baja de Materia con ID: ".$model->id;
		return $subject;
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
		/*else if(Yii::app()->user->rol == 'Alumno'){
			
			if($this->loadModel($id)->matriculaalumno == Yii::app()->user->id){
				$this->loadModel($id)->delete();
				$this->redirect(array('index'));
			}else{
				
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
			}
			
		}*/
			
		else	
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Enlista todos los modelos, dependiendo del rol del usuario.
	 */
	public function actionIndex()
	
	
	{
		
		if(Yii::app()->user->rol == 'Alumno'){
		
			$mat = Yii::app()->user->id;
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
					
			$solicitudes=SolicitudBajaMateria::model()->findall($criteria);
			
			$dataProvider= new CArrayDataProvider(
					$solicitudes, array(
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC',
							
							),
						'pagination'=> array(
							'pageSize'=>100,
							),
						));
						
			
						
		}else if (Yii::app()->user->rol == 'Director'){
			
			$nomina = Yii::app()->user->id;
		
			
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));

			$solicitudes_para_directores = SolicitudBajaMateria::model()->findall($criteria_directores);
			
			$dataProvider = new CArrayDataProvider ($solicitudes_para_directores, array(
					'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						'pagination'=> array(
							'pageSize'=>100,
							),
						
						));
						
	
		}else if(Yii::app()->user->rol == 'Admin'){
			$dataProvider = new CActiveDataProvider('SolicitudBajaMateria');
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
		$model=new SolicitudBajaMateria('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SolicitudBajaMateria']))
			$model->attributes=$_GET['SolicitudBajaMateria'];

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
		$model=SolicitudBajaMateria::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='solicitud-baja-materia-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
