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
				
				// Almacena el nombre de usuario del usuario actual.
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
		// El resto de los casos. El usuario es una secretaria o un asistente. En este
		// caso el usuario solo puede editar sus propios datos.
		else
		{
			// Valida si el usuario está tratando de editar los datos
			// de algún otro empleado. En caso de ser así se lanza una
			// excepción de HTTP.
			if($id != Yii::app()->user->id){
				throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
			}
			
			// Carga el modelo.
			$model = $this->loadModel(Yii::app()->user->id);
			
			// Valida si se recibió el modelo de algún empleado vía alguna petición POST.
			if(isset($_POST['Empleado'])) {
				
				// Valida si se dejó vacío el campo de texto para ingresar la contraseña. En
				// caso de ser así, se reestablece la contraseña anterior.
				if ('' === $_POST['Empleado']['password']) {
					$_POST['Empleado']['password'] = $model->password;
				}
				else {
					// Valida si hubo algún error al ingresar la contraseña actual. En
					// caso de ser así se lanza una excepción de HTTP.
					if(md5($_POST['passwordActual']) != $model->password) {
						throw new CHttpException(400, 'El password actual no es correcto.');
					}
					else {
						// No hubo ningún error al ingresar la contraseña actual. Entonces
						// se cifra la nueva contraseña en MD5.
						$_POST['Empleado']['password'] = md5($_POST['Empleado']['password']);
					}
				}
				
				// Se asignan los atributos al modelo.
				$model->attributes = $_POST['Empleado'] + $model->attributes;
				
				// Valida si el modelo pudo ser registrado en la base de datos.
				if($model->save()) {
					$this->redirect(array('view','id'=>$model->nomina));
				}
			}
		
		}
		
		// Asigna una contraseña vacía (nula) al modelo.
		$model->password = '';
		
		// Despliega la forma para actualizar los datos
		// del empleado.
		$this->render('update',array(
        'model'=>$model,
        'model_carrera'=>$model_carrera,
        'carreras'=>$carreras,
        'not_carreras'=>$not_carreras
    ));

	}
	
	/**
	 * Asigna un empleado a una carrera adicional, registrada en el sistema.
	 * @param model $model el modelo del empleado a asignar a la carrera adicional
	 */
	private function addCarrera($model) {
		
		// Valida si se recibió el modelo de alguna carrera vía alguna petición POST.
		if(isset($_POST['Carrera'])) {
			
			// Obtiene el ID de la carrera adicional.
			$id_carrera = $_POST['Carrera'];
			
			// Valida si la carrera está registrada en el sistema. En caso de ser así, asigna
			// al empleado a la carrera y registra la asignación en la base de datos.
			if($id_carrera['id'] != 0){
				$model_carrera_empleado=new CarreraTieneEmpleado;
				$model_carrera_empleado->idcarrera = $id_carrera['id'];
				$model_carrera_empleado->nomina = $model->nomina;
				$model_carrera_empleado->save();
			}
		}
	}

	/**
     * Elimina a un modelo en particular.
     * Si la eliminación es exitosa, el navegador será redirigido a la página 'admin'.
     * @param integer $id el ID del modelo a eliminar
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // Solo se permite eliminación vía una petición POST.
            $this->loadModel($id)->delete();

			// Si es una petición AJAX (impulsada por eliminación vía la vista de tabla de admin) no se debe redirigir al navegador.
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Enlista a todos los modelos.
     */
    public function actionIndex()
    {
		// Valida si el usuario es un director de carrera.
        if(Yii::app()->user->rol == 'Director'){
			
			
			// Condiciones para obtener a todos los empleados que laboran en la carrera donde labora el director.
			$dataProvider = new CActiveDataProvider('Empleado', array(
                    'criteria'=>array(
						'condition'=>'nomina IN (SELECT nomina FROM carrera_tiene_empleado WHERE idcarrera IN (SELECT idcarrera FROM carrera_tiene_empleado WHERE nomina =  \''.Yii::app()->user->id.'\') GROUP BY nomina)',
						'group'=>'nomina'
					),
            ));
		
		// El resto de los usuarios.
        }else{
			
			// Condiciones para obtener a todos los empleados registrados en la base de
			// datos.
            $dataProvider=new CActiveDataProvider('Empleado');
        }

		// Despliega una página con información de los empleados.
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Administra a los empleados.
     */
    public function actionAdmin()
    {
        $model=new Empleado('search');
        $model->unsetAttributes();  // Elimina los valores por defecto.
        if(isset($_GET['Empleado']))
            $model->attributes=$_GET['Empleado'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

	/**
     * Devuelve el modelo de datos en base a la llave primaria proporcionada en la variable GET.
     * Si el modelo de datos no es encontrado se lanzará una excepción de HTTP.
     * @param integer el ID del modelo a cargar
     */
    public function loadModel($id)
    {
        $model=Empleado::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'La página solicitada no existe');
        return $model;
    }

    /**
     * Realiza validación AJAX.
     * @param CModel el modelo a validar
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='empleado-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

	/**
	 * Obtiene las siglas de todas las carreras.
	 * @return array las siglas de todas las carreras
	 */
    private function getCarreras()
    {
		// Criterios para obtener las siglas de todas las carreras
        $criteria_carreras= new CDbCriteria(array(
            'select'=>'id, siglas'));

		// Obtiene los modelos de todas las carreras.
        $consulta_carreras = Carrera::model()->findAll($criteria_carreras);

		// Arreglo para almacenar las siglas de todas las carreras.
        $carreras = array();

		// Almacena en el arreglo $carreras las siglas de todas las
		// carreras.
        foreach($consulta_carreras as &$valor){
            $carreras[$valor->id] = $valor->siglas;
        }

		// Devuelve el arreglo $carreras
        return $carreras;
    }

	/**
	 * Obtiene las carreras en las que labora un empleado.
	 * @param string $empleado el nombre de usuario del empleado
	 * @return array las siglas de las carreras en las que labora el empleado
	 */
    public function getEmpleadoCarreras($empleado)
    {
		// Sentencia de SQL para obtener las siglas de las carreras en las que
		// labora el empleado.
        $sql = "SELECT DISTINCT * FROM `carrera_tiene_empleado`,`carrera` 
            WHERE nomina = \"".$empleado."\" and idcarrera = id\n";

		// Ejecuta la sentencia (consulta) de SQL.
        $salida = $this->getQueryResult($sql);

		// Arreglo para almacenar las siglas de las carreras en las que labora el
		// empleado
        $carreras = array();

		// Almacena en el arreglo $carreras las siglas de las carreras en las que
		// labora el empleado
        foreach($salida as &$valor){
            $carreras[$valor[ "id" ]] = $valor[ "siglas" ];

        }
		
		// Devuelve el arreglo $carreras.
        return $carreras;
    }

	/**
	 * Obtiene las siglas de las carreras en las que no labora un empleado.
	 * @param string $empleado el nombre de usuario del empleado
	 * @return array las siglas de las carreras en las que no labora el empleado
	 */
    private function getNotEmpleadoCarreras($empleado)
    {
		// Establece la conexión con la base de datos.
        $connection=Yii::app()->db;
		
		// Sentencia de SQL para obtener las siglas de las carreras en las que
		// no labora el empleado.
        $sql = "SELECT * FROM `carrera` WHERE id NOT IN 
            (select idcarrera from `carrera_tiene_empleado` 
            where nomina = \"".$empleado."\")";

		// Ejecuta la sentencia (consulta) de SQL.
        $salida = $this->getQueryResult($sql);

		// Arreglo para almacenar las siglas de las carreras en las que no
		// labora el empleado.
        $carreras = array();

		// Deja vacía la primera 'casilla' del arreglo $carreras.
        $carreras[0] = "";

		// Almacena en el arreglo $carreras las siglas de las carreras en las que
		// no labora el empleado.
        foreach($salida as &$valor){
            $carreras[$valor[ "id" ]] = $valor[ "siglas" ];

        }
		
		// Devuelve el arreglo $carreras.
        return $carreras;
    }

	/**
	 * Obtiene los resultados de alguna sentencia (consulta) de SQL.
	 * @param string $sql la sentencia de SQL a ejecutar
	 * @return array los resultados de la sentencia (consulta) de SQL
	 */
    private function getQueryResult($sql)
    {
		// Establece la conexión con la base de datos.
        $connection=Yii::app()->db;
		
		// Crea la sentencia (consulta) de SQL.
        $command=$connection->createCommand($sql);
		
		// Ejecuta la sentencia (consulta) de SQL.
        $dataReader=$command->query();

		// Arreglo para almacenar los resultados de la sentencia (consulta) de SQL
        $salida = array(); 

		// Almacena en el arreglo $salida los resultados de la sentencia (consulta) de
		// SQL.
        for($i = 0; $i < $dataReader->count(); $i++)
            array_push($salida,$dataReader->read());

		// Devuelve el arreglo $salida.
        return $salida;
    }
}
