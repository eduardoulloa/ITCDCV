<?php

class AlumnoController extends Controller
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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
	
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
						
		$adminCriteria = new CDbCriteria(array(
						'select'=>'username'));
						
						
		//obtiene todos los directores de carrera
		$consulta=Empleado::model()->findAll($criteria);
		
		$adminConsulta = Admin::model()->findAll($adminCriteria);
		
		$alumnoConsulta = Alumno::model()->findAll();
		
		//arreglo con todos los directores de carrera
		$directores = array();
		$admins = array();
		$alumnos = array();
		
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		foreach($adminConsulta as &$valor){
			array_push($admins, ($valor->username).'');
		}
		
		foreach($alumnoConsulta as &$valor){
			array_push($alumnos, ($valor->matricula).'');
		}
	
		return array(
			/*
			array('allow',  // allow all users to perform 'index' and 'view' actions
				//'actions'=>array('index','view'),
				'actions'=>array('create'),
				'users'=>array('*'),
			),
			*/
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				//'actions'=>array('index','view'),
				'actions'=>array('create'),
				'users'=>array('*'),
			),*/
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),*/
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('update','view'),
				'users'=>$alumnos,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view'),
				'users'=>$admins,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view'),
				'users'=>$directores,
			),
			
			array('allow',  // deny all users
				'actions'=>array('crearexalumno'),
				'users'=>array(),
			),
			array('deny',  // deny all users
				'actions'=>array('crearexalumno'),
				'users'=>$alumnos,
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
		$model=new Alumno;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Alumno']))
		{
			$model->attributes=$_POST['Alumno'];
			
			$this->verificaQueMatriculaNoEstaRegistrada($model->matricula);
			$model->password = cifraPassword($model->password);
			
			if($model->save()) {
				$this->redirect(array('create','id'=>$model->matricula));
			}
	
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function verificaQueMatriculaNoEstaRegistrada($matricula) {
		if(matriculaYaExiste($matricula)) {
			throw new CHttpException(400, 'Error. Ya existe un usuario registrado con la matrícula
			 o el nombre de usuario proporcionado. Favor de verificarlo. Puede también crear un
			 nombre de usuario a partir de una cadena de caracteres. ');
		}
	}
	
	public function actionCrearExalumno()
	{
		$model = new Alumno;
		
		if(isset($_POST['Alumno']))
		{
			$model->attributes = $_POST['Alumno'];			
			$model->semestre = -1;
			$model->plan = -1;
			
			$this->verificaQueMatriculaNoEstaRegistrada($model->matricula);
			$model->password = cifraPassword($model->password);
			
			if($model->save()) {
				$this->redirect(array('crearexalumno','id'=>$model->matricula));
			}
		}
		
		$this->render('crearexalumno',array('model'=>$model,));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
	
		if(Yii::app()->user->rol == 'Admin'){
		
			$model=$this->loadModel($id);

			if(isset($_POST['Alumno']))
			{
				$model->attributes=$_POST['Alumno'];
				$pass = md5($model->attributes['password']);
				$model->password = $pass;
				if($model->save())
					$this->redirect(array('view','id'=>$model->matricula));
			}
		
		}else if(Yii::app()->user->rol == 'Alumno'){
			$model = $this->loadModel(Yii::app()->user->id);
			if(isset($_POST['Alumno'])) {
			
				if ('' === $_POST['Alumno']['password']) {
					$_POST['Alumno']['password'] = $model->password;
				}
				else {
					if(md5($_POST['passwordActual']) != $model->password) {
						throw new CHttpException(400, 'El password actual no es correcto.');
					}
					else {
						$_POST['Alumno']['password'] = md5($_POST['Alumno']['password']);
					}
				}
				$model->attributes = $_POST['Alumno'] + $model->attributes;
				if($model->save()) {
					$this->redirect(array('view','id'=>$model->matricula));
				}
			}
			
		}else if(Yii::app()->user->rol == 'Director'){
			
			$nomina = Yii::app()->user->id;
			
			$validacion = Alumno::model()->findAllBySql('SELECT matricula FROM alumno JOIN  carrera_tiene_empleado ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND alumno.matricula ='.$id.' AND carrera_tiene_empleado.nomina = \''.$nomina.'\'');
			
			if(!empty($validacion)){
			
				$model=$this->loadModel($id);
				
				if(isset($_POST['Alumno']))
				{	
					$oldpass = $model->password;
					$model->attributes=$_POST['Alumno'];
					$newpass = $model->password;
					
					//Valida si el usuario ha hecho algun cambio de password.
					if($newpass != $oldpass){
						$pass = md5($model->password);
						$model->password = $pass;
					}
					
					//$model->email = $model->attributes['email'];
					if($model->save())
						$this->redirect(array('view','id'=>$model->matricula));
				}
			
			}else{
				throw new CHttpException(400,'El alumno no se encuentra registrado en ninguna de las carreras de su direccion.');
			}
		
			
		
		}
		
		$model->password = '';
		
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
	
		if (Yii::app()->user->rol == 'Alumno'){
			$dataProvider=new CActiveDataProvider('Alumno', array(
				'criteria'=>array(
						'condition'=>'idcarrera='.Yii::app()->user->carrera,
					),
				)
			);
		}else if(Yii::app()->user->rol == 'Admin'){
			$dataProvider=new CActiveDataProvider('Alumno');
			
		}else if(Yii::app()->user->rol == 'Director'){
		
			$nomina = Yii::app()->user->id;
		
			//aqui va
			$dataProvider = new CActiveDataProvider('Alumno', array(
				
					'criteria'=>array(
						'join'=>'JOIN carrera_tiene_empleado AS c ON t.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					),
						'pagination'=> array(
							'pageSize'=>100,
							),

						));
			
		
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
		$model=new Alumno('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Alumno']))
			$model->attributes=$_GET['Alumno'];

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
		$model=Alumno::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='alumno-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
