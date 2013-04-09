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
		
		// Despliega una página con información del modelo.
		$this->render('view',array(
			'data'=>$this->loadModel($id),
            'carreras'=>$resultados
		));
	}
    
	/**
	 * Crea un nuevo modelo.
	 * Si la creación es exitosa el navegador será redirigido a la página 'view'.
	 */
	public function actionCreate()
	{
        // Obtiene las carreras.
        // $carreras = getCarreras();
        
		// Crea un nuevo modelo para un empleado.
		$model=new Empleado;
		
		// Crea un nuevo modelo para una carrera.
        $model_carrera=new Carrera;
		
		// Quitar el comentario en la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió, vía alguna petición POST, el modelo de un empleado y de una carrera.
		if(isset($_POST['Empleado']) && isset($_POST['Carrera']))
		{
			// Asigna los atributos al modelo del empleado.
			$model->attributes=$_POST['Empleado'];
			
			// Obtiene la contraseña (sin cifrar) del modelo del empleado.
			$contrasena_no_cifrada = $model->password;
			
			// Valida si el campo de texto de la contraseña se dejó vacío.
			if(strlen($contrasena_no_cifrada) == 0){
				throw new CHttpException(400, 'Error. El campo de la contraseña no puede dejarse vacío.');
			}
			
			// Cifra en MD5 la contraseña del modelo del empleado.
			$model->password = md5($model->password);
			
			// Obtiene el modelo de la carrera.
            $id_carrera = $_POST['Carrera'];
			
			// Valida si fue posible registrar el modelo del empleado en la
			// base de datos.
			if($model->save()){
				// Crea un nuevo modelo de carrera_tiene_empleado (en la base de datos, es
				// la tabla que relaciona a cada empleado con la carrera en la que labora).
                $model_carrera_empleado=new CarreraTieneEmpleado;
				
				// Le asigna al modelo de carrera_tiene_empleado, el ID de la carrera en
				// la que laborará el nuevo empleado.
                $model_carrera_empleado->idcarrera = $id_carrera['id'];
				
				// Le asigna al modelo de carrera_tiene_empleado, el nombre de usuario del
				// nuevo empleado.
                $model_carrera_empleado->nomina = $model->nomina;
				
				// Valida si fue posible registrar el modelo de carrera_tiene_empleado en la
				// base de datos.
                if($model_carrera_empleado->save())
				    $this->redirect(array('view','id'=>$model->nomina));
            }else{
				// En caso de que no se haya podido registrar el modelo del empleado en la
				// base de datos, se vuelve a asignar al modelo la contraseña no cifrada.
				$model->password = $contrasena_no_cifrada;
			}

		}

		// Despliega la forma para crear un nuevo empleado, con
		// un menú tipo drop-down, a partir del cual se puede elegir
		// alguna carrera a la cual será asociado.
		$this->render('create',array(
			'model'=>$model,
            'model_carrera'=>$model_carrera,
            //'carreras'=>$carreras
		));
	}

	/**
	 * Actualiza un modelo en particular.
	 * Si la actualización es exitosa, el navegador será redirigido a la página 'view'.
	 * @param integer $id el ID del modelo a actualizar
	 */
	public function actionUpdate($id)
	{
		// Obtiene las siglas de las carreras en las que labora el
		// empleado.
		$carreras = $this->getEmpleadoCarreras($id);
		
		// Obtiene las siglas de aquellas carreras en las que no labora
		// el empelado.
		$not_carreras = $this->getNotEmpleadoCarreras($id);
		
		// Crea un nuevo modelo para una carrera.
		$model_carrera = new Carrera;

		// Valida si el usuario es un administrador general.
		if(Yii::app()->user->rol == 'Admin'){
			
			// Carga el modelo del empleado a actualizar.
			$model = $this->loadModel($id);
			
			// Quitar el comentario en la siguiente línea si se requiere validación AJAX.
			// $this->performAjaxValidation($model);

			// Valida si se recibió el modelo de algún empleado vía alguna petición POST.
			if(isset($_POST['Empleado']))
			{
				// Valida si se dejó vacío el campo de texto para ingresar la contraseña.
				// En este caso se le asigna la antigua contraseña al modelo.
				if ('' === $_POST['Empleado']['password']) {
					$_POST['Empleado']['password'] = $model->password;
				}
				else {
					// El campo de la contraseña no se dejó vacío. En este caso
					// se cifra la nueva contraseña en MD5.
					$_POST['Empleado']['password'] = md5($_POST['Empleado']['password']);
				}
				
				// Se le asignan los atributos al modelo.
				$model->attributes = $_POST['Empleado'] + $model->attributes;
				
				// Valida si fue posible registrar el modelo del empleado en la
				// base de datos.
				if($model->save()) {
					// Registra en la base de datos el modelo de carrera_tiene_empleado
					// a actualizar.
					$this->addCarrera($model);					
					$this->redirect(array('view','id'=>$model->nomina));
				}
			}
		// Valida si el usuario es un director de carrera.
		}else if(Yii::app()->user->rol == 'Director'){
			
			// Carga el modelo.
			$model = $this->loadModel($id);
			
			// Valida si el nombre de usuario del usuario actual es igual al nombre de usuario
			// del usuario a actualizar. Es decir, si es el caso de un director de carrera que
			// desea actualizar sus datos en el sistema.
			if(Yii::app()->user->id == $model->nomina) {
			
				// Valida si se recibió, vía alguna petición POST, el modelo del empleado.
				if(isset($_POST['Empleado'])) {
					
					// Valida si se dejó vacío el campo de texto para ingresar la contraseña. En este
					// caso se reestablece la contraseña anterior.
					if ('' === $_POST['Empleado']['password']) {
						$_POST['Empleado']['password'] = $model->password;
					}
					else {
						// Valida si hubo algún error al ingresar la contraseña actual. En este
						// caso se lanza una excepción de HTTP.
						if(md5($_POST['passwordActual']) != $model->password) {
							throw new CHttpException(400, 'La contraseña actual no es correcta.');
						}
						else {
							// No hubo error al ingresar la contraseña actual. Entonces se
							// cifra en MD5 la nueva contraseña.
							$_POST['Empleado']['password'] = md5($_POST['Empleado']['password']);
						}
					}
					
					// Asigna los atributos al modelo.
					$model->attributes = $_POST['Empleado'] + $model->attributes;
					
					// Valida si fue posible registrar el modelo en la base de datos.
					if($model->save()) {
						$this->redirect(array('view','id'=>$model->nomina));
					}
				}
			}
			else {
				// En caso de ser diferente el nombre de usuario del usuario actual actual al nombre de usuario
				// del usuario a actualizar, se trata de un director de carrera que desea actualizar los
				// datos de alguno de sus empleados.
				
				// Obtiene el nombre de usuario del usuario actual.
				$nomina = Yii::app()->user->id;
			
				// Criterios para obtener los datos del empleado a actualizar.
				$criteria_empleado = new CDbCriteria(array(
									'join'=>'JOIN empleado ON empleado.nomina = t.nomina AND t.nomina =\''.$id.'\''));
				
				// 'Join' del modelo del empleado a actualizar con el primer registro de este empleado en
				// la tabla 'carrera_tiene_empleado'.
				$consulta_empleado = CarreraTieneEmpleado::model()->find($criteria_empleado);
			
				// Obtiene el ID de la carrera del primer registro del empleado
				// en la tabla 'carrera_tiene_empleado'.
				$idcarrera_empleado = $consulta_empleado->idcarrera;
			
				// Criterios para validar que el usuario actual (director de carrera) sea 
				// el director de carrera (supervisor) de la carrera en la que
				// labora el empleado a actualizar. Es decir, si el empleado a actualizar es
				// algún subordinado del director de carrera.
				$criteria_dir = new CDbCriteria(array(
									'join'=>'JOIN empleado ON empleado.nomina = t.nomina AND t.nomina =\''.$nomina.'\''));
				
				// 'Join' del modelo del director de carrera con el primer registro del director
				// en la tabla 'carrera_tiene_empleado'.
				$consulta_dir = CarreraTieneEmpleado::model()->find($criteria_dir);
			
				// Obtiene el ID de la carrera del primer registro del director de carrera
				// en la tabla 'carrera_tiene_empleado'.
				$idcarrera = $consulta_dir->idcarrera;
				
				// Establece la conexión con la base de datos.
				$connection=Yii::app()->db;
				
				// Sentencia de SQL para obtener, de las carreras en las que labora el director de carrera, aquellas 
				// carreras en las que no labora el empleado a actualizar.
				$sql = "SELECT id, siglas FROM carrera WHERE id IN
				(SELECT idcarrera FROM (SELECT idcarrera FROM carrera_tiene_empleado AS c WHERE c.nomina = '".$nomina."') AS t
				WHERE idcarrera NOT IN
				(SELECT idcarrera FROM carrera_tiene_empleado AS c WHERE c.nomina = '".$id."'))";
				
				// Obtiene el resultado de la sentencia de SQL.
				$salida = $this->getQueryResult($sql);

				// Arreglo para almacenar aquellas carreras en las que labora el director de carrera donde no
				// labora el empleado a actualizar.
				$not_carreras = array();
				
				// Asigna un string vacío a la primera 'casilla' del arreglo.
				$not_carreras[0] = "";

				// Almacena en el arreglo $not_carreras aquellas carreras en las que labora el director de carrera
				// donde no labora el empleado a actualizar.
				foreach($salida as &$valor){
					$not_carreras[$valor[ "id" ]] = $valor[ "siglas" ];
				}
				
				// Valida que exista en la tabla carrera_tiene_empleado (en la base de datos) algún registro con el ID de la carrera 
				// del director de carrera y con el nombre de usuario del empleado a actualizar. La existencia de dicho registro comprueba que
				// el empleado a actualizar labora en la carrera donde labora el director de carrera.
				$validacion = CarreraTieneEmpleado::model()->findBySql('SELECT nomina FROM carrera_tiene_empleado WHERE idcarrera ='.$idcarrera.' AND nomina =\''.$id.'\'');
			
				// Valida que exista al menos un registro en la tabla 'carrera_tiene_empleado', con los
				// criterios establecidos anteriormente.
				if(!empty($validacion)){
			
					// Carga el modelo.
					$model=$this->loadModel($id);
				
					// Valida si se recibió, vía alguna petición POST, el modelo
					// del empleado a actualizar.
					if(isset($_POST['Empleado']))
					{	
						// Variable para almacenar la contraseña antigua.
						$oldpass = $model->password;
						
						// Asigna los atributos al modelo.
						$model->attributes=$_POST['Empleado'];
						
						// Variable para almacenar la nueva contraseña.
						$newpass = $model->password;
					
						// Valida si el usuario ha hecho algún cambio de contraseña. En caso
						// de ser así, cifra la nueva contraseña en MD5.
						if($newpass != $oldpass){
							$pass = md5($model->password);
							$model->password = $pass;
						}
					
						// Valida si los cambios hechos al modelo pudideron ser
						// registrados en la base de datos.
						if($model->save()) {
							// Crea un nuevo registro en la tabla 'carrera_tiene_empleado'.
							$this->addCarrera($model);
							$this->redirect(array('view','id'=>$model->nomina));
						}
					}
			
				}else{
					// No existe ningún registro en la tabla 'carrera_tiene_empleado'. Por lo tanto, el
					// empleado no está registrado en ninguna de las carreras del director de carrera.
					// Se lanza una excepción de HTTP.
					throw new CHttpException(400,
							'El empleado no se encuentra registrado en ninguna de las carreras de su direccion.');
				}
			}
		}
		// El resto de los casos. El usuario es una secretaria o un asistente.
		else // es un empleado normal(secretaria o asistente, etc.); ellos solo pueden editarse a sí mismos.
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
