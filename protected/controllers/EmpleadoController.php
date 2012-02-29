<?php

class EmpleadoController extends Controller
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
	
		//Condiciones para buscar al super admin
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		//Query para encontrar al super admin
		//$consulta_super_admin = Admin::model()->findAllByPk('admin', $criteria_super_admin);
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		$admin = array();
		
		$criteria_dire = new CDbCriteria(array(
								'select'=>'username'));
		
		//Query para encontrar al super admin
		//$consulta_super_admin = Admin::model()->findAllByPk('admin', $criteria_super_admin);
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		$admin = array();
		
		//array_push($admin, $consulta_super_admin);
		
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
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
	
		return array(
			array('allow', 
				'actions'=>array('index','view','admin','delete','create','update'),
				'users'=>$admin,
			),
			array('allow', 
				'actions'=>array('index','view','admin','delete','create','update','actualizar'),
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
        $criteria_carreras= new CDbCriteria(array(
                                                'select'=>'id, siglas'));

        $consulta_carreras = Carrera::model()->findAll($criteria_carreras);

        $carreras = array();
        
        foreach($consulta_carreras as &$valor){
            $carreras[$valor->id] = $valor->siglas;
        }
		$model=new Empleado;
        $model_carrera=new Carrera;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Empleado']) && isset($_POST['Carrera']))
		{
			$model->attributes=$_POST['Empleado'];
            $id_carrera = $_POST['Carrera'];
			if($model->save()){
                $model_carrera_empleado=new CarreraTieneEmpleado;
                $model_carrera_empleado->idcarrera = $id_carrera['id'];
                $model_carrera_empleado->nomina = $model->nomina;
                if($model_carrera_empleado->save())
				    $this->redirect(array('view','id'=>$model->nomina));
            }

		}

		
		$this->render('create',array(
			'model'=>$model,
            'model_carrera'=>$model_carrera,
            'carreras'=>$carreras
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$model = $this->loadModel($id);
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Empleado']))
		{
			$model->attributes=$_POST['Empleado'];
			$pass = md5($model->attributes['password']);
			$model->password = $pass;
			if($model->save())
				$this->redirect(array('view','id'=>$model->nomina));
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
			
			
			$connection=Yii::app()->db;
			
			$sql = "SELECT idcarrera FROM carrera_tiene_empleado WHERE nomina ='".$nomina."'";
			
			$command=$connection->createCommand($sql);
		
			$dataReader=$command->query();
			
			$query = "";
			
			$dataReader->bindColumn(1, $id);
			
			$cuenta = $dataReader->count();
			
			
			if($cuenta == 0){
				$query="";
			}else if ($cuenta == 1){
				
				$row = $dataReader->read();
				$query .= 'c.idcarrera = '.$id;
			}else{	
				$query .= '(';
				while($cuenta > 1){
					$row = $dataReader->read();	
					$query .= 'c.idcarrera = '.$id.' OR ';
					$cuenta--;
				}
				$row = $dataReader->read();
				$query .= 'c.idcarrera = '.$id.')';
				
				
			}
			
			$criteria_idcarrera = new CDbCriteria(array(
					'condition'=>'nomina=\''.$nomina.'\'',
					'select'=>'idcarrera',
				));
				
			$idcarrera = CarreraTieneEmpleado::model()->findAll($criteria_idcarrera);
			
			//Obtiene los empleados de esta carrera.
			if($query != ""){
				$dataProvider = new CActiveDataProvider('Empleado', array(
					'criteria'=>array(
						'join'=>'JOIN carrera_tiene_empleado as c ON t.nomina = c.nomina AND '.$query,
					),
				));
				
			}else{
				$dataProvider=new CActiveDataProvider('Empleado');
			}
			
		}else{
		
			$dataProvider=new CActiveDataProvider('Empleado');
			
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
		$model=new Empleado('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Empleado']))
			$model->attributes=$_GET['Empleado'];

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
		$model=Empleado::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='empleado-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
