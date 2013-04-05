<?php

class AlumnoController extends Controller
{	 
	 /**
	 * @var string la distribución por defecto para las vistas. Por defecto es '//layouts/column2', lo
	 * cual significa que se utiliza una distribución de dos columnas. Ver 'protected/views/layouts/column2.php'.
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
	 * Indica las reglas de control de acceso.
	 * Este método es empleado por el filtro 'accessControl'.
	 * @return array reglas de control de acceso
	 */
	public function accessRules()
	{
		// Criterios de búsqueda para obtener los nombres de usuario de todos los directores
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
		
		// Criterios de búsqueda para obtener los nombres de usuario de todos los administradores generales
		$adminCriteria = new CDbCriteria(array(
						'select'=>'username'));
						
		// Obtiene los modelos de todos los directores de carrera
		$consulta=Empleado::model()->findAll($criteria);
		
		// Obtiene los modelos de todos los administradores generales
		$adminConsulta = Admin::model()->findAll($adminCriteria);
		
		// Obtiene los modelos de todos los alumnos
		$alumnoConsulta = Alumno::model()->findAll();
		
		// Arreglo para almacenar los nombres de usuario de todos los directores de carrera
		$directores = array();
		
		// Arreglo para almacener los nombres de usuario de todos los administradores generales
		$admins = array();
		
		// Arreglo para almacenar los nombres de usuario de todos alumnos
		$alumnos = array();
		
		// Almacena en el arreglo $directores los nombres de usuario de todos los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Almacena en el arreglo $admins los nombres de usuario de todos los administradores generales.
		foreach($adminConsulta as &$valor){
			array_push($admins, ($valor->username).'');
		}
		
		// Almacena en el arreglo $alumnos los nombres de usuario (matrículas) de todos los alumnos.
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
			array('allow', // Les permite a los alumnos realizar acciones de 'update' y 'view'.
				'actions'=>array('update','view'),
				'users'=>$alumnos,
			),
			array('allow', // Les permite a los administradores generales realizar acciones de
						   // 'admin', 'delete', 'create', 'update', 'index' y 'view'.
				'actions'=>array('admin','delete','create','update','index','view'),
				'users'=>$admins,
			),
			array('allow', // Les permite a los directores de carrera realizar acciones de
						   // 'admin', 'delete', 'create', 'update', 'index' y 'view'.
				'actions'=>array('admin','delete','create','update','index','view'),
				'users'=>$directores,
			),
			array('allow',  // Les permite a todos los usuarios realizar acciones de
							// 'crearexalumno' y 'exalumnoregistrado'.
				'actions'=>array('crearexalumno', 'exalumnoregistrado'),
				'users'=>array('*'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
		
	}

	 /**
	 * Crea un nuevo modelo.
	 * Si la creación es exitosa, el navegador será redirigido a la página 'view'.
	 */
	public function actionCreate()
	{
		$model=new Alumno;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// Valida si se recibió el modelo de algún alumno vía una petición de POST.
		if(isset($_POST['Alumno']))
		{
			// Se le agregan los atributos al modelo.
			$model->attributes=$_POST['Alumno'];
			
			// Verifica que la matrícula no haya sido previamente registrada en la base de datos.
			$this->verificaQueMatriculaNoEstaRegistrada($model->matricula);
			
			// Almacena la contraseña sin cifrar en MD5.
			$contrasena_no_cifrada = $model->password;
			
			// Cifra la contraseña en MD5.
			$model->password = cifraPassword($model->password);
			
			// Valida si el modelo pudo ser registrado en la base de datos.
			// De no ser posible el almacenamiento, se reestablece al modelo la contraseña, sin cifrar en MD5.
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->matricula));
			}else{
				$model->password = $contrasena_no_cifrada;
			}
	
		}
		
		// Despliega la forma para crear un nuevo modelo.
		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Verifica que una matrícula no haya sido registrada previamente en la base de datos.
	 * Si la matrícula ya estaba registrada, se despliega un mensaje con una descripción del error.
	 * @param char $matricula la matrícula a validar
	 */
	public function verificaQueMatriculaNoEstaRegistrada($matricula) {
		if(matriculaYaExiste($matricula)) {
			throw new CHttpException(400, 'Error. Ya existe un usuario registrado con la matrícula
			 o el nombre de usuario proporcionado. Favor de verificarlo. Puede también crear un
			 nombre de usuario a partir de una cadena de caracteres. ');
		}
	}
	
	 /**
	 * Actualiza un modelo en particular.
	 * Si la actualización es exitosa, el navegador será redirigido a la página 'view'.
	 * @param integer $id el ID del modelo a actualizar
	 */
	public function actionUpdate($id)
	{
		// Valida si el usuario es un administrador general.
		if(Yii::app()->user->rol == 'Admin'){
			
			// Carga el modelo.
			$model=$this->loadModel($id);

			// Valida si se recibió algún modelo vía alguna petición de POST.
			if(isset($_POST['Alumno']))
			{
				// Valida si el campo de texto de la contraseña se dejó vacío.
				// En caso de ser así, se le asigna al modelo la antigua contraseña.
				if ('' === $_POST['Alumno']['password']) {
					$_POST['Alumno']['password'] = $model->password;
				}
				else {
				// En caso de no dejar vacío el campo de la contraseña, se cifra la 
				// nueva contraseña en MD5 y se le asigna al modelo.
					$_POST['Alumno']['password'] = md5($_POST['Alumno']['password']);
				}
				
				// Se le asignan los atributos al modelo.
				$model->attributes = $_POST['Alumno'] + $model->attributes;
				
				// Valida si es posible registrar los cambios al modelo en la base de datos.
				if($model->save()) {
					$this->redirect(array('view','id'=>$model->matricula));
				}
			}
		
		// Valida si el usuario es un alumno.
		}else if(Yii::app()->user->rol == 'Alumno'){
			
			// Carga el modelo.
			$model = $this->loadModel(Yii::app()->user->id);
			
			// Valida si se recibió algún modelo vía alguna petición de POST.
			if(isset($_POST['Alumno'])) {
				
				// Valida si el campo de texto de la contraseña se dejó vacío.
				// En caso de ser así, se le asigna al modelo la antigua contraseña.
				if ('' === $_POST['Alumno']['password']) {
					$_POST['Alumno']['password'] = $model->password;
				}
				else {
					// Valida si la contraseña actual es incorrecta.
					// Si es así, se muestra en el navegador un mensaje con una descripción del error.
					if(md5($_POST['passwordActual']) != $model->password) {
						throw new CHttpException(400, 'La contraseña actual no es correcto.');
					}
					// Cifra la contraseña actual en MD5.
					else {
						$_POST['Alumno']['password'] = md5($_POST['Alumno']['password']);
					}
				}
				
				// Se le asignan al modelo los atributos.
				$model->attributes = $_POST['Alumno'] + $model->attributes;
				
				// Valida si es posible registrar los cambios al modelo en la base de datos.
				if($model->save()) {
					$this->redirect(array('view','id'=>$model->matricula));
				}
			}
		// Valida si el usuario es un director de carrera.
		}else if(Yii::app()->user->rol == 'Director'){
			
			// Almacena el nombre de usuario del director de carrera.
			$nomina = Yii::app()->user->id;
			
			// Obtiene el modelo del alumno a actualizar.
			$validacion = Alumno::model()->findAllBySql('SELECT matricula FROM alumno JOIN  carrera_tiene_empleado ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND alumno.matricula ='.$id.' AND carrera_tiene_empleado.nomina = \''.$nomina.'\'');
			
			// Valida que $validacion no esté vacío, comprobando que el modelo corresponde a un alumno del director de carrera.
			if(!empty($validacion)){
			
				// Carga el modelo.
				$model=$this->loadModel($id);
				
				// Valida si se recibió algún modelo vía alguna petición de POST.
				if(isset($_POST['Alumno']))
				{
					// Almacena la antigua contraseña del modelo.
					$oldpass = $model->password;
					
					// Asigna los atributos al modelo.
					$model->attributes=$_POST['Alumno'];
					
					// Almacena la nueva contraseña del modelo.
					$newpass = $model->password;
					
					//Valida si el campo de texto de la contraseña está vacío;
					// en caso de ser así, se le asigna la contraseña anterior.
					if ('' === $_POST['Alumno']['password']) {
						$model->password = $oldpass;
					}
					else {
						// Se cifra la nueva contraseña en MD5.
						$model->password = md5($_POST['Alumno']['password']);
					}
					
					// Valida si los cambios al modelo se pudieron registrar en la base de datos.
					if($model->save()) {
						$this->redirect(array('view','id'=>$model->matricula));
					}
				}
			
			}else{
				// El alumno no se encuentra registrado en ninguna de las carreras del director de carrera.
				// Se despliega en el navegador un mensaje con una descripción del error.
				throw new CHttpException(400,'El alumno no se encuentra registrado en ninguna de las carreras de su direccion.');
			}
		}
		
		// Asigna una contraseña vacía al modelo.
		$model->password = '';
		
		// Se despliega una forma para actualizar el modelo.
		$this->render('update',array(
			'model'=>$model,
		));
	}

	 /**
	 * Elimina a un modelo en particular.
	 * Si la eliminación es exitosa el navegador será redirigido a la página de 'admin'.
	 * @param integer $id el ID del modelo a eliminar
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// Solo se permite eliminación vía una petición de POST.
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			// Si es una petición de AJAX (impulsada por eliminación vía la vista de tabla de admin) el navegador no debe ser redirigido.
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Enlista todos los modelos.
	 */
	public function actionIndex()
	{
		// Valida si el usuario es un alumno.
		if (Yii::app()->user->rol == 'Alumno'){
		
			// Criterios para los datos de todos los alumnos.
			$dataProvider=new CActiveDataProvider('Alumno', array(
				'criteria'=>array(
						'condition'=>'idcarrera='.Yii::app()->user->carrera,
					),
				)
			);
		
		// Valida si el usuario es un administrador general.
		}else if(Yii::app()->user->rol == 'Admin'){
		
			// Criterios para obtener los datos de todos los alumnos.
			$dataProvider=new CActiveDataProvider('Alumno');
		
		// Valida si el usuario es un director de carrera.
		}else if(Yii::app()->user->rol == 'Director'){
		
			// Almacena el nombre de usuario del director de carrera.
			$nomina = Yii::app()->user->id;
		
			// Criterios para obtener los datos de todos los alumnos del director de carrera. (Pueden ser alumnos de varias carreras).
			$dataProvider = new CActiveDataProvider('Alumno', array(
					'criteria'=>array(
						'join'=>'JOIN carrera_tiene_empleado AS c ON t.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					)
			));
		}
	
		// Despliega los datos de los alumnos, en base a los criterios establecidos anteriormente.
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Administra los modelos, dependiendo del tipo de usuario.
	 */
	public function actionAdmin()
	{
		$model=new Alumno('search');
		$model->unsetAttributes();  // Elimina valores por defecto.
		if(isset($_GET['Alumno']))
			$model->attributes=$_GET['Alumno'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	 /**
	 * Devuelve el modelo de datos, de acuerdo con la llave primaria indicada en la variable GET.
	 * Si el modelo de datos no se encuentra, se lanzará una excepción HTTP.
	 * @param integer el ID del modelo a cargar
	 */
	public function loadModel($id)
	{
		$model=Alumno::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'La página solicitada no existe.');
		return $model;
	}

	 /**
	 * Realiza validación AJAX.
	 * @param CModel el modelo a validar
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
