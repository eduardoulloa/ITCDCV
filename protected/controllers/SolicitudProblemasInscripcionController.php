<?php

class SolicitudProblemasInscripcionController extends Controller
{	 
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
		$adminActions=array('index','admin','update','delete','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
				
		// Criterios para obtener los nombres de usuario (nóminas) de
		// los directores de carrera
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
		
		// Obtiene los modelos de los directores de carrera.
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
		// los asistentes y secretarias
		$asistentes = array();
		
		// Almacena en el arreglo $asistentes los nombres de
		// usuario de los asistentes y secretarias.
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		// Arreglo con las acciones de los administradores generales
		$admin_acciones = array('index','create','update','view','admin','delete');
		
		// Criterios para obtener los nombres de usuario de los
		// administradores generales
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de
		// los administradores generales
		$admin = array();
		
		// Almacena en el arreglo $admin los nombres de
		// usuario de los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
		return array(
			
			// Les permite a los usuarios autenticados realizar
			// acciones de 'create' y 'perform'.
			array('allow',
				'actions'=>array('index','create','view'),
				'users'=>array('@'),
			),
			
			// Les permite a los directores de carrera realizar
			// acciones de 'index', 'admin', 'update', 'delete', 'view_all',
			// 'view', 'solicitudBajaMateria', 'solicitudBajaSemestre',
			// 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion' y
			// 'solicitudRevalidacion'
			array('allow',
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			
			// Les permite a los administradores generales realizar
			// acciones de 'index', 'create', 'update', 'view', 'admin', y
			// 'delete'.
			array('allow',
				'actions'=>$admin_acciones,
				'users'=>$admin,
			),
			
			// Les permite a los asistentes realizar
			// acciones de 'index', 'admin', 'update', 'delete', 'view_all',
			// 'view', 'solicitudBajaMateria', 'solicitudBajaSemestre',
			// 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion' y
			// 'solicitudRevalidacion'
			array('allow',
				'actions'=>$adminActions,
				'users'=>$asistentes,
			),
			
			// Niega a todos los usuarios.
			array('deny',
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
	
		if(Yii::app()->user->rol == 'Alumno'){
			$mat = Yii::app()->user->id;
			$criteria = new CDbCriteria(array(
						'condition'=>'matriculaalumno = '.$mat.' AND id = '.$id));
						
			$solicitudes=SolicitudProblemasInscripcion::model()->find($criteria);
			
			if(sizeof($solicitudes) == 0){
				throw new CHttpException(403,'Usted no está autorizado para realizar esta acción.');
			}
		}
	
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
			
			if(Yii::app()->user->rol == 'Alumno'){
				
				if($model->matriculaalumno == Yii::app()->user->id){
				
					if($model->save()) {
						if($this->needsToSendMail($model)) {
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						
						$this->redirect(array('view','id'=>$model->id));

					}
				
				}else{
					throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
				}
				
			}else if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria' ){
			
				$matricula = $model->matriculaalumno;
				$nomina = Yii::app()->user->id;
				$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
			
				if(!empty($challenge)){
				
				
			
					if($model->save()) {
						if($this->needsToSendMail($model)) {
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						
							$this->redirect(array('view','id'=>$model->id));

					}
				
				}else{
					throw new CHttpException(400,'No se encontró la solicitud a editar.');
				}
			
			}else{
				if($model->save()) {
					if($this->needsToSendMail($model)) {
						EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
														getEmailAddress($model->matriculaalumno));

					}
				
					
						$this->redirect(array('view','id'=>$model->id));

				}
			}
			
		}

		if(Yii::app()->user->rol == 'Alumno'){

			if(Yii::app()->user->id == $model->matriculaalumno){
				$this->render('update',array(
				'model'=>$model,
				));
			}else{
				throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
			}
		
		}else if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria' ){
			$matricula = $model->matriculaalumno;
			$nomina = Yii::app()->user->id;
			$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
		
			if(!empty($challenge)){
			
				$this->render('update',array(
					'model'=>$model,
				));
		
			
			}else{
				throw new CHttpException(400,'No se encontro la solicitud a editar.');
			}
		}else{
		
			$this->render('update',array(
				'model'=>$model,
			));
			
		}
	}
	
	public function needsToSendMail($model)
	{
		return $model->attributes['status'] == 'terminada';
	}
	
	public function createEmailBody($model) 
	{
		$body = "";
		$body .= "\nComentarios: ".$model->comentarios;
		return $body;
	}
	
	public function createSubject($model)
	{
		$subject = "Reporte de Problema de Inscripcion con ID: ".$model->id;
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
							'defaultOrder'=>'fechahora DESC'
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
							'defaultOrder'=>'fechahora DESC'
							),
						));
	
		}else if(Yii::app()->user->rol == 'Admin'){
		
			$dataProvider = new CActiveDataProvider('SolicitudProblemasInscripcion', array(
					'sort'=>array(
							'attributes'=>array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
				)
			);
			
			
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
