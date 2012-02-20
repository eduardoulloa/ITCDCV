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
		
		//arreglo con todos los directores de carrera
		$directores = array();
		$admins = array();
		
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		foreach($adminConsulta as &$valor){
			array_push($admins, ($valor->username).'');
		}
	
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),*/
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view'),
				'users'=>$admins,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view'),
				'users'=>$directores,
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
			if($model->save())
				$this->redirect(array('view','id'=>$model->matricula));
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

		if(isset($_POST['Alumno']))
		{
			$model->attributes=$_POST['Alumno'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->matricula));
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
		
			
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN carrera_tiene_empleado AS c ON t.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'select'=>'t.matricula AS id',
					));

			$alumnos_de_directores = Alumno::model()->findall($criteria_directores);
			
			//$dataProvider = new CArrayDataProvider ($alumnos_de_directores);
		
			//aqui va
			$dataProvider = new CArrayDataProvider($alumnos_de_directores, array(
				
					'sort'=> array(
							'attributes'=> array(
								'matricula',
								),
							'defaultOrder'=>'matricula'
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
