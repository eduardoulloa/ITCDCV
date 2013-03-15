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
						'condition'=>'puesto = \'Director\'',
		));
						
						
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

        $consulta_carreras = Empleado::model()->findByPk($id);

        

        $carreras = $consulta_carreras->carreras;
        
        $resultados = array();
        foreach($carreras as &$carrera){
            $resultados[$carrera['id']] = $carrera['siglas'];
        }
            
        $resultados = $this->getEmpleadoCarreras($id);
		$this->render('view',array(
			'data'=>$this->loadModel($id),
            'carreras'=>$resultados
		));
	}
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        # Metodo que nos da las carreras
        $carreras = getCarreras();
        
		$model=new Empleado;
        $model_carrera=new Carrera;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Empleado']) && isset($_POST['Carrera']))
		{
			$_POST['Empleado']['password'] = md5($_POST['Empleado']['password']);
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
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$carreras = $this->getEmpleadoCarreras($id);					//
		$not_carreras = $this->getNotEmpleadoCarreras($id);		//
		$model_carrera = new Carrera;													//

		if(Yii::app()->user->rol == 'Admin'){
			
			$model = $this->loadModel($id);
			
			
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Empleado']))
			{
				
				if ('' === $_POST['Empleado']['password']) {
					$_POST['Empleado']['password'] = $model->password;
				}
				else {		
					$_POST['Empleado']['password'] = md5($_POST['Empleado']['password']);
				}
				$model->attributes = $_POST['Empleado'] + $model->attributes;
				
				if($model->save()) {	
					$this->addCarrera($model);					
					$this->redirect(array('view','id'=>$model->nomina));
				}
			}
		}else if(Yii::app()->user->rol == 'Director'){
			
			$model = $this->loadModel($id);
			
			//director tratando de editarse a si mismo
			if(Yii::app()->user->id == $model->nomina) {
				if(isset($_POST['Empleado'])) {

					if ('' === $_POST['Empleado']['password']) {
						$_POST['Empleado']['password'] = $model->password;
					}
					else {
						if(md5($_POST['passwordActual']) != $model->password) {
							throw new CHttpException(400, 'El password actual no es correcto.');
						}
						else {
							$_POST['Empleado']['password'] = md5($_POST['Empleado']['password']);
						}
					}
					$model->attributes = $_POST['Empleado'] + $model->attributes;
					if($model->save()) {
						$this->redirect(array('view','id'=>$model->nomina));
					}
				}
			}
			else {
				//director tratando de editar a un empleado de su carrera
				$nomina = Yii::app()->user->id;
			
				//El empleado a modificar
				$criteria_empleado = new CDbCriteria(array(
									'join'=>'JOIN empleado ON empleado.nomina = t.nomina AND t.nomina =\''.$id.'\''));
								
				$consulta_empleado = CarreraTieneEmpleado::model()->find($criteria_empleado);
			
				$idcarrera_empleado = $consulta_empleado->idcarrera;
			
			
				//Este director
				$criteria_dir = new CDbCriteria(array(
									'join'=>'JOIN empleado ON empleado.nomina = t.nomina AND t.nomina =\''.$nomina.'\''));
								
				$consulta_dir = CarreraTieneEmpleado::model()->find($criteria_dir);
			
			
				$idcarrera = $consulta_dir->idcarrera;
			
				$validacion = CarreraTieneEmpleado::model()->findBySql('SELECT nomina FROM carrera_tiene_empleado WHERE idcarrera ='.$idcarrera.' AND nomina =\''.$id.'\'');
			
				if(!empty($validacion)){
			
					$model=$this->loadModel($id);
				
					if(isset($_POST['Empleado']))
					{	
						$oldpass = $model->password;
						$model->attributes=$_POST['Empleado'];
						$newpass = $model->password;
					
						//Valida si el usuario ha hecho algun cambio de password.
						if($newpass != $oldpass){
							$pass = md5($model->password);
							$model->password = $pass;
						}
					
						//$model->email = $model->attributes['email'];
						if($model->save()) {
							$this->addCarrera($model);
							
							$this->redirect(array('view','id'=>$model->nomina));
						}
					}
			
				}else{
					throw new CHttpException(400,
							'El empleado no se encuentra registrado en ninguna de las carreras de su direccion.');
				}
			}
		}
		else //es un empleado normal(secretaria o asistente, etc.)
		{
		
			$model = $this->loadModel(Yii::app()->user->id);
			if(isset($_POST['Empleado'])) {
		
				if ('' === $_POST['Empleado']['password']) {
					$_POST['Empleado']['password'] = $model->password;
				}
				else {
					if(md5($_POST['passwordActual']) != $model->password) {
						throw new CHttpException(400, 'El password actual no es correcto.');
					}
					else {
						$_POST['Empleado']['password'] = md5($_POST['Empleado']['password']);
					}
				}
				$model->attributes = $_POST['Empleado'] + $model->attributes;
				if($model->save()) {
					$this->redirect(array('view','id'=>$model->nomina));
				}
			}
		
		}


		$model->password = '';
		
		//$this->render('update',array('model'=>$model));
		
		$this->render('update',array(
        'model'=>$model,
        'model_carrera'=>$model_carrera,
        'carreras'=>$carreras,
        'not_carreras'=>$not_carreras
    ));

	}
	
	private function addCarrera($model) {
		
		if(isset($_POST['Carrera'])) {																	//
			$id_carrera = $_POST['Carrera'];															//
			if($id_carrera['id'] != 0){																		//
	        $model_carrera_empleado=new CarreraTieneEmpleado;					//
	        $model_carrera_empleado->idcarrera = $id_carrera['id'];		//
	        $model_carrera_empleado->nomina = $model->nomina;					//
	        $model_carrera_empleado->save();													//
	    }																															//
		}																																//
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
			
			/*
				Obtiene a todos los empleados que laboran en la carrera donde labora el director.
			*/
			$dataProvider = new CActiveDataProvider('Empleado', array(
                    'criteria'=>array(
						'condition'=>'nomina IN (SELECT nomina FROM carrera_tiene_empleado WHERE idcarrera IN (SELECT idcarrera FROM carrera_tiene_empleado WHERE nomina =  \''.Yii::app()->user->id.'\') GROUP BY nomina)',
						'group'=>'nomina'
					),
            ));

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

    private function getCarreras()
    {

        $criteria_carreras= new CDbCriteria(array(
            'select'=>'id, siglas'));

        $consulta_carreras = Carrera::model()->findAll($criteria_carreras);

        $carreras = array();

        foreach($consulta_carreras as &$valor){
            $carreras[$valor->id] = $valor->siglas;
        }

        return $carreras;
    }

    public function getEmpleadoCarreras($empleado)
    {
        $sql = "SELECT DISTINCT * FROM `carrera_tiene_empleado`,`carrera` 
            WHERE nomina = \"".$empleado."\" and idcarrera = id\n";

        $salida = $this->getQueryResult($sql);

        $carreras = array();

        foreach($salida as &$valor){
            $carreras[$valor[ "id" ]] = $valor[ "siglas" ];

        }
								
        return $carreras;
    }

	/*
		Obtiene TODAS las carreras en las que NO está registrado un empleado.
	*/
    private function getNotEmpleadoCarreras($empleado)
    {
        $connection=Yii::app()->db;
        $sql = "SELECT * FROM `carrera` WHERE id NOT IN 
            (select idcarrera from `carrera_tiene_empleado` 
            where nomina = \"".$empleado."\")";

        $salida = $this->getQueryResult($sql);

        $carreras = array();

        $carreras[0] = "";

        foreach($salida as &$valor){
            $carreras[$valor[ "id" ]] = $valor[ "siglas" ];

        }


        return $carreras;
    }

    private function getQueryResult($sql)
    {
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $dataReader=$command->query();

        $salida = array(); 

        for($i = 0; $i < $dataReader->count(); $i++)
            array_push($salida,$dataReader->read());

        return $salida;

    }
}
