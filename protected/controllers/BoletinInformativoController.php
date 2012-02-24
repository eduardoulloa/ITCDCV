<?php

//Extensions para el uso de e-mail.
Yii::import('application.extensions.yii-mail.YiiMail');
Yii::import('application.extensions.yii-mail.YiiMailMessage');


class BoletinInformativoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	
	/**
	 * Envia un e-mail a los alumnos en los semestres seleccionados en la forma del Boletin Informativo.
	 * @param arreglo de strings $s lista de semestres de los alumnos para realizar la consulta.
	 * @param objeto $body el cuerpo del mensaje a enviar.
	 */
	public function mandarAlumno($s, $body, $subject, $idcarrera){
		$connection=Yii::app()->db;
		
		
		$sql = "";
		
		//Genera la consulta en SQL, dependiendo de si uno o varios semestres fueron seleccionados en la forma.
		if(count($s)<2){ //Un solo semestre
			$sql = "SELECT matricula FROM alumno WHERE semestre = ".$s[0]." AND idcarrera = ".$idcarrera;
		}else{ //varios semestres
			
			$sql = "SELECT matricula FROM alumno WHERE semestre IN (".$s[0];
			
			$i = 1;

			do {
				
				$sql .= ",".$s[$i];
				$i++;
			}while ($i < count($s));
			$sql .= ") AND idcarrera = ".$idcarrera;
			
		}
		
		$command=$connection->createCommand($sql);
		
		$dataReader=$command->query();

		//Arreglo para almacenar la lista de destinatarios.
		$destinatario = array();
		
		$dataReader->bindColumn(1, $mat);
		
		//Genera la lista de destinatarios.
		while(($row = $dataReader->read())!== false){
			$address = '';
			if(strlen($mat)==6){
				$address .= 'A00'.$mat.'@itesm.mx';
			}else if(strlen($mat)==7){
				$address .= 'A0'.$mat.'@itesm.mx';
			}
			array_push($destinatario, $address);
		}
		
		$message = new YiiMailMessage;
		
		//Se establece el cuerpo del mensaje.
		$message->setBody($body);
		
		//Se establece el asunto del mensaje.
		$message->setSubject($subject);
		
		//Se establecen los destinatarios.
		$message->setTo($destinatario);
		
		//Se establece el remitente.
		//$message->from = Yii::app()->params['adminEmail'];
		$message->setFrom(array('dcv-noreply@itesm.mx'=>'DCV'));
		
		Yii::app()->mail->send($message);
		
	}
	
	/**
	 * Envia un e-mail a los exalumnos registrados en el portal, a partir de la forma del Boletin Informativo.
	 * @param objeto body el cuerpo del mensaje a enviar.
	 */
	public function mandarExAlumno($body, $subject, $idcarrera){
		$connection=Yii::app()->db;
		
		
		//consulta para obtener a los alumnos graduados.
		$sql = "SELECT email FROM alumno WHERE semestre = -1 AND idcarrera = ".$idcarrera;
		
		$command=$connection->createCommand($sql);
		
		$dataReader=$command->query();
	
		//arreglo para almacenar la lista de destinatarios
		$destinatario = array();
		
		$dataReader->bindColumn(1, $mat);
		
		//genera la lista de destinatarios
		while(($row = $dataReader->read())!== false){
			array_push($destinatario, $mat);
		}
		
		$message = new YiiMailMessage;
		
		//se establece el cuerpo del mensaje.
		$message->setBody($body);
		
		//se establece el asunto del mensaje.
		$message->setSubject($subject);
		
		//se establecen los destinatarios
		$message->setTo($destinatario);
		
		//se establece el remitente
		//$message->from = Yii::app()->params['adminEmail'];
		$message->setFrom(array('dcv-noreply@itesm.mx'=>'DCV'));
		
		Yii::app()->mail->send($message);
		
	}

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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		
		$adminActions=array('index','delete', 'create','view_all','view',
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
				'actions'=>array('view'), //quite index
				'users'=>array('*'),
			),*/
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'), //quite create
				'users'=>array('@'),
			),*/
			array('allow', // acciones del director
				'actions'=>$adminActions,
				'users'=>$directores, 
			),
			
			array('allow', // acciones del director
				'actions'=>$adminActions,
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
	 * If creation is successful, an e-mail will be sent to the users registered in the chosen semesters. The browser will then be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$connection=Yii::app()->db;
		
		$model=new BoletinInformativo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		

		if(isset($_POST['BoletinInformativo']))
		{
			$dir = Yii::app()->user->id;
			
			//Obtiene el id de la carrera asociada al Director
			$sql2 = "SELECT idcarrera FROM carrera_tiene_empleado WHERE nomina = '".$dir."'";
			$command2 = $connection->createCommand($sql2);
			$dataReader2 = $command2->query();
			$dataReader2->bindColumn(1, $idcarrera);
			$row = $dataReader2->read();
			
			$model->attributes=$_POST['BoletinInformativo'];
			$model->setAttribute('idcarrera', $idcarrera);
			
			$sem1 = $model->attributes['semestre1'];
			$sem2 = $model->attributes['semestre2'];
			$sem3 = $model->attributes['semestre3'];
			$sem4 = $model->attributes['semestre4'];
			$sem5 = $model->attributes['semestre5'];
			$sem6 = $model->attributes['semestre6'];
			$sem7 = $model->attributes['semestre7'];
			$sem8 = $model->attributes['semestre8'];
			$sem9 = $model->attributes['semestre9'];
			
			if(($sem1 == 0) && ($sem2 == 0) && ($sem3 == 0) && ($sem4 == 0) && ($sem5 == 0) && ($sem6 == 0) && ($sem7 == 0) && ($sem8 == 0) && ( $sem9 == 0) && ($model->attributes['exatec']==0)){
				$model->addError($model->attributes['semestre1'],'Debe seleccionar al menos un grupo de destinatarios');
			}else{
				$arr = array();
			
			$paraAlumno = 0;
			
			if ($sem1 == 1){
				array_push($arr, 1);
				$paraAlumno = 1;
			}
			
			if ($sem2 == 1){
				array_push($arr, 2);
				$paraAlumno = 1;
			}
			
			if ($sem3 == 1){
				array_push($arr, 3);
				$paraAlumno = 1;
			}
			
			if ($sem4 == 1){
				array_push($arr, 4);
				$paraAlumno = 1;
			}
			
			if ($sem5 == 1){
				array_push($arr, 5);
				$paraAlumno = 1;
			}
			
			if ($sem6 == 1){
				array_push($arr, 6);
				$paraAlumno = 1;
			}
			
			if ($sem7 == 1){
				array_push($arr, 7);
				$paraAlumno = 1;
			}
			
			if ($sem8 == 1){
				array_push($arr, 8);
				$paraAlumno = 1;
			}
			
			if ($sem9 == 1){
				array_push($arr, 9);
				$paraAlumno = 1;
			}
			
			if ($paraAlumno == 1){
				$this->mandarAlumno($arr, $model->attributes['mensaje'], $model->attributes['subject'], $idcarrera);
			}
			
			if ($model->attributes['exatec']==1){
				$this->mandarExAlumno($model->attributes['mensaje'], $model->attributes['subject'], $idcarrera);
			}
			
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

		if(isset($_POST['BoletinInformativo']))
		{
			$model->attributes=$_POST['BoletinInformativo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		if(Yii::app()->user->rol == 'Director'){
			$nomina = Yii::app()->user->id;
			
			$criteria = new CDbCriteria(array(
						'condition'=>'nomina=\''.$nomina.'\''));
			
			$carreraTieneEmpleado = CarreraTieneEmpleado::model()->find($criteria);
			

			$dataProvider = new CActiveDataProvider('BoletinInformativo', array(
				'criteria'=>array(
					'condition'=>'idcarrera='.$carreraTieneEmpleado->idcarrera,
					),
				));
			
		}else if(Yii::app()->user->rol == 'Admin'){
			$dataProvider = new CActiveDataProvider('BoletinInformativo');
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
		$model=new BoletinInformativo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BoletinInformativo']))
			$model->attributes=$_GET['BoletinInformativo'];

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
		$model=BoletinInformativo::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='boletin-informativo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
