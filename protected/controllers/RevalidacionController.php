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
						
		//Query que obtiene todos los empleados (directores, asistentes y secretarias)
		$consulta_empleado = Empleado::model()->findAll();
		
		//Arreglo para almacenar a todos los empleados
		$empleados = array();
		
		//Se agregan todos los directores al arreglo.
		foreach($consulta_empleado as &$valor){
			array_push($empleados, ($valor->nomina).'');
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
			array('allow', // allow directores de carrera to perform 'update', 'delete' actions
				'actions'=>array('update', 'admin', 'delete'),
				'users'=>$empleados,
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
		
		
		$nomina = Yii::app()->user->id;
		
		//Variable que obtiene un objeto de revalidacion. Si no lo obtiene, el objeto no existe o no le corresponde al director.
		$challenge = Revalidacion::model()->findBySql('SELECT id FROM revalidacion JOIN carrera_tiene_empleado ON carrera_tiene_empleado.idcarrera = revalidacion.idcarrera AND carrera_tiene_empleado.nomina =  \'' . $nomina .'\' AND revalidacion.id = '. $id);

		if (!empty($challenge)){

			if(isset($_POST['Revalidacion']))
			{
				$model->attributes=$_POST['Revalidacion'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}else{
			throw new CHttpException(400,'No se encontró la revalidación a editar.');
		}
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
	
		$id = Yii::app()->user->id;
		
		/*El caso de ser un director de carrera, asistente, o secretaria. En cualquiera de los anteriores, se obtienen
		todas las revalidaciones realizadas para todas las carreras en las que el empleado labora.
		*/
		if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
			$nomina = $id;
					
					
					$criteria = new CDbCriteria(array(
								'condition'=>'nomina=\''.$nomina.'\''));
					
					$carreraTieneEmpleado = CarreraTieneEmpleado::model()->findAll($criteria);
					
					//String para el condition del CActiveDataProvider. Se almacenan todos los ids de las carreras a en las que labora el empleado.
					
					$ids = "";
					
					//El empleado no labora en ninguna carrera.
					if(sizeof($carreraTieneEmpleado) == 0){
					
						$ids = "";
					//El empleado labora solamente en una carrera.
					}else if (sizeof($carreraTieneEmpleado) == 1){
						
						$ids = $carreraTieneEmpleado[0]->idcarrera;
					//El empleado labora en más de una carrera.
					}else{
					
						$ids = $carreraTieneEmpleado[0]->idcarrera;
						
						$i = 1;
					
						while($carreraTieneEmpleado[$i]!= NULL){
							$ids = $ids . " OR idcarrera = " . $carreraTieneEmpleado[$i]->idcarrera;
							$i++;
						}
					
					}
					
					$dataProvider = new CActiveDataProvider('Revalidacion', array(
						'criteria'=>array(
							'condition'=>'idcarrera ='.$ids,
							),
						
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
		/* 
		En caso de ser alumno, se obtienen únicamente las revalidaciones realizadas en su carrera.
		*/				
		}else if (Yii::app()->user->rol == 'Alumno'){
						//Variable para almacenar el modelo del alumno, para obtener su carrera.
						$alumno = Alumno::model()->findByPk($id);
						$dataProvider = new CActiveDataProvider('Revalidacion', array(
						'criteria'=>array(
							'condition'=>'idcarrera ='.$alumno->idcarrera,
							),
						
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
		/*
		En caso de ser administrador, debe indexar todas las solicitudes de todas las carreras.
		*/
		}else{
			$dataProvider=new CActiveDataProvider('Revalidacion', array (
			'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora DESC'
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
