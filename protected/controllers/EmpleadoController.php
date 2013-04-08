<?php

class EmpleadoController extends Controller
{
	/**
	 * @var string la distribución por defecto para las vistas. Por defecto es '//layouts/column2', lo cual
	 * indica que se utilizará una distribución de dos columnas. Ver 'protected/view/layouts/column2.php'.
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
	 * Este método es usado por el filtro 'accessControl'.
	 * @return array reglas de control de acceso
	 */
	public function accessRules()
	{
		// Criterios de búsqueda para obtener los nombres de usuario de
		// todos los administradores generales.
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene todos los modelos de los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de los
		// administradores generales.
		$admin = array();
		
		// Almacena en el arreglo $admin, los nombres de usuario de los
		// administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
					
		// Criterios de búsqueda para obtener los nombres de usuario de
		// todos los directores de carrera.
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto = \'Director\'',
		));
		
		// Obtiene los modelos de los directores de carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de usuario de los
		// directores de carrera.
		$directores = array();
		
		// Almacena en el arreglo $directores los nombres de usuario de
		// todos los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Criterios de búsqueda para obtener los nombres de usuario de todos
		// los asistentes y secretarias.
		$criteria_asistentes = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto = \'Asistente\' || puesto = \'Secretaria\'',
		));
		
		// Arreglo para almacenar los nombres de usuario de
		// los asistentes y secretarias.
		$asistentes_secretarias = array();
		
		// Obtiene los modelos de todos los asistentes y secretarias.
		$consulta = Empleado::model()->findAll($criteria_asistentes);
		
		// Almacena en el arreglo $asistentes_secretarias los nombres de usuario de
		// todos los asistentes y secretarias.
		foreach($consulta as &$valor){
			array_push($asistentes_secretarias, ($valor->nomina).'');
		}
	
		return array(
			array('allow', // Les permite a los administradores generales realizar
						   // acciones de 'index', 'view', 'admin', 'delete', 'create' y 'update'.
				'actions'=>array('index','view','admin','delete','create','update'),
				'users'=>$admin,
			),
			array('allow', // Les permite a los directores de carrera realizar
						   // acciones de 'index', 'view', 'admin', 'delete', 'create', 'update' y 'actualizar'.
				'actions'=>array('index','view','admin','delete','create','update','actualizar'),
				'users'=>$directores,
			),
			array('allow', // Les permite a los asistentes y secretarias realizar
						   // operaciones de 'view' y 'update'.
				'actions'=>array('view', 'update'),
				'users'=>$asistentes_secretarias,
			),
			array('deny',  // Niega a todos los usuarios.
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Despliega un modelo en particular.
	 * @param integer $id el ID del modelo a desplegar
	 */
	public function actionView($id)
	{
		// Obtiene el modelo del empleado.
        /* $consulta_carreras = Empleado::model()->findByPk($id); */
		
		// Obtiene las carreras en las que labora el empleado.
        /* $carreras = $consulta_carreras->carreras; */
        
		// Arreglo para almacenar las siglas de las carreras en las
		// que labora el empleado.
        $resultados = array();
		
		// Almacena en el arreglo $carreras las siglas de las carreras en
		// las que labora el empleado.
        /*foreach($carreras as &$carrera){
            $resultados[$carrera['id']] = $carrera['siglas'];
        }*/
           
		// Almacena en el arreglo $resultados las carreras en las que
		// labora el empleado
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
        //$carreras = getCarreras();
        
		$model=new Empleado;
        $model_carrera=new Carrera;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Empleado']) && isset($_POST['Carrera']))
		{
			$model->attributes=$_POST['Empleado'];
			
			$contrasena_no_cifrada = $model->password;
			
			if(strlen($contrasena_no_cifrada) == 0){
				throw new CHttpException(400, 'Error. El campo de la contraseña no puede dejarse vacío.');
			}
			
			$model->password = md5($model->password);
			
            $id_carrera = $_POST['Carrera'];
			if($model->save()){
                $model_carrera_empleado=new CarreraTieneEmpleado;
                $model_carrera_empleado->idcarrera = $id_carrera['id'];
                $model_carrera_empleado->nomina = $model->nomina;
                if($model_carrera_empleado->save())
				    $this->redirect(array('view','id'=>$model->nomina));
            }else{
				$model->password = $contrasena_no_cifrada;
			}

		}

		
		$this->render('create',array(
			'model'=>$model,
            'model_carrera'=>$model_carrera,
            //'carreras'=>$carreras
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
							throw new CHttpException(400, 'La contraseña actual no es correcta.');
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
				
				$connection=Yii::app()->db;
				
				//Obtiene de las carreras en las que labora el director, aquellas carreras donde NO labora el empleado con la nomina indicada.
				$sql = "SELECT id, siglas FROM carrera WHERE id IN
				(SELECT idcarrera FROM (SELECT idcarrera FROM carrera_tiene_empleado AS c WHERE c.nomina = '".$nomina."') AS t
				WHERE idcarrera NOT IN
				(SELECT idcarrera FROM carrera_tiene_empleado AS c WHERE c.nomina = '".$id."'))";

				$salida = $this->getQueryResult($sql);

				$not_carreras = array();

				$not_carreras[0] = "";

				foreach($salida as &$valor){
					$not_carreras[$valor[ "id" ]] = $valor[ "siglas" ];
				}

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
		else //es un empleado normal(secretaria o asistente, etc.); ellos solo pueden editarse a sí mismos.
		{
		
			if($id != Yii::app()->user->id){
				throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
			}
			
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
