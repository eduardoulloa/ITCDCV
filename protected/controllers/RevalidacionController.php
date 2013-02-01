<?php

class RevalidacionController extends Controller
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
		//Criterio de búsqueda para obtener a todos los directores
		$criteria_director = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
						
		//Query que obtiene todos los directores de carrera
		$consulta_director=Empleado::model()->findAll($criteria_director);
		
		//Arreglo para almacenar a todos los directores de carrera
		$directores = array();
		
		//Se agregan todos los directores al arreglo.
		foreach($consulta_director as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		//Criterio de búsquda para encontrar a todos los admins
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		//Query que obtiene a todos los admins
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		//Arreglo para almacenar a todos los admins
		$admin = array();
		
		//Se agregan todos los admins al arreglo.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
	
		return array(
			array('allow', // allow only authenticated user to perform 'index, 'view'
				'actions'=>array('index', 'view'),
				'users'=>array('@'),
			),
			array('allow', // allow directores de carrera to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>$directores,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
	
		if(Yii::app()->user->rol == 'Director'){
			$nomina = Yii::app()->user->id;
			
			$criteria = new CDbCriteria(array(
						'condition'=>'nomina=\''.$nomina.'\''));
			
			//Variable que almacena los datos del director
			$carreraTieneEmpleado = CarreraTieneEmpleado::model()->find($criteria);
			
			$dataProvider = new CActiveDataProvider('Revalidacion', array(
				'criteria'=>array(
					'condition'=>'idcarrera='.$carreraTieneEmpleado->idcarrera,
					),
				
				'sort'=> array(
					'attributes'=> array(
						'fechahora',
						),
					'defaultOrder'=>'fechahora DESC'
					),
				));
		}
		
		$this->render('view',array(
			'model'=>$dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Revalidacion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Revalidacion']))
		{
			$model->attributes=$_POST['Revalidacion'];
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

		if(isset($_POST['Revalidacion']))
		{
			$model->attributes=$_POST['Revalidacion'];
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
		$dataProvider=new CActiveDataProvider('Revalidacion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Revalidacion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Revalidacion']))
			$model->attributes=$_GET['Revalidacion'];

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
		$model=Revalidacion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='revalidacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
