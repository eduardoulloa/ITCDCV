<?php

class SolicitudBajaMateriaController extends Controller
{
	/**
	 * @var string la distribución por defecto para las vistas. Por defecto es '//layouts/column2', lo cual
	 * indica una distribución de dos columnas. Ver 'protected/views/layouts/column2.php'.
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
	 * Este método es utilizado por el filtro 'accessControl'.
	 * @return array reglas de control de acceso
	 */
	public function accessRules()
	{		
		// Condiciones para obtener los nombres de usuario de
		// todos los administradores generales.
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
							
		// Obtiene los modelos de todos los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los administradores generales.
		$admin = array();
		
		// Almacena en el arreglo $admin los nombres de
		// usuario de todos los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
		// Criterios para obtener a todos los directores de
		// carrera.
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
						
		// Obtiene los modelos de todos los directores de carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los directores de carrera.
		$directores = array();
		
		// Almacena en el arreglo $directores los nombres de usuario de
		// todos los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Criterios para obtener a todos los asistentes y
		// secretarias.
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto = \'Secretaria\''));
						
		// Obtiene los modelos de todos los asistentes y
		// secretarias.
		$consulta_asistente = Empleado::model()->findAll($asistente_criteria);
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los asistentes y secretarias.
		$asistentes = array();
		
		// Almacena en el arreglo $asistentes los nombres de usuario
		// de todos los asistentes y secretarias.
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		// Obtiene los nombres de usuario (matrículas) de
		// todos los alumnos.
		$consulta_alumnos = Alumno::model()->findAll();
		
		// Arreglo para almacenar los nombres de usuario (matrículas) de
		// todos los alumnos.
		$alumnos = array();
		
		// Almacena en el arreglo $alumnos los nombres de
		// usuario (matrículas) de todos los alumnos.
		foreach($consulta_alumnos as &$valor){
			array_push($alumnos, ($valor->matricula).'');
		}
		
		// Arreglo con las acciones que se les permite realizar a
		// los directores de carrera y administradores generales.
		$adminActions=array('index','admin','delete','update','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
	
		return array(
	
			array('allow', 
				'actions'=>$adminActions, // Les permite a los directores de carrera
										  // realizar acciones de 'index', 'admin', 'delete', 'update', 'view_all', 'view',
										  // 'solicitudBajaMateria', 'solicitudBajaSemestre', 'solicitudCartaRecomendacion',
										  // 'solicitudProblemasInscripcion' y 'solicitudRevalidacion'.
				'users'=>$directores,
			),
			
			array('deny',  // Niega a asistentes y secretarias el
						   // permiso para realizar acciones de 'index', 'create', 'view' y 'update'.
				'actions'=>array('index','create','view','update'),
				'users'=>$asistentes,
			),
			
			array('deny',  // Niega a los alumnos el permiso para
						   // realizar acciones de 'update'.
				'actions'=>array('update'),
				'users'=>$alumnos,
			),
			
			array('allow',
						   // Les permite a los usuarios autenticados realizar acciones de
						   // 'index', 'create', 'view' y 'update'.
				'actions'=>array('index','create','view','update'),
				'users'=>array('@'),
			),
			
			array('allow', 
				'actions'=>$adminActions,
										  // Les permite a los administradores generales 
										  // realizar acciones de 'index', 'admin', 'delete', 'update', 'view_all', 'view',
										  // 'solicitudBajaMateria', 'solicitudBajaSemestre', 'solicitudCartaRecomendacion',
										  // 'solicitudProblemasInscripcion' y 'solicitudRevalidacion'.
				'users'=>$admin,
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
		// Valida si el usuario es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){
			
			// Almacena el nombre de usuario (matrícula) del
			// usuario actual
			$mat = Yii::app()->user->id;
			
			// Criterios para obtener el modelo de la solicitud de baja de materia a 
			// desplegar
			$criteria = new CDbCriteria(array(
						'condition'=>'matriculaalumno = '.$mat.' AND id = '.$id));
						
			// Oabtiene el modelo de la solicitud.
			$solicitudes=SolicitudBajaMateria::model()->find($criteria);
			
			// En caso de no encontrar el modelo, se lanza una
			// excepción de HTTP, con una descripción del error.
			if(sizeof($solicitudes) == 0){
				throw new CHttpException(403,'Usted no está autorizado para realizar esta acción.');
			}
		}
		
		// Despliega una página con información de
		// la solicitud de baja de materia a desplegar.
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
		// Crea un nuevo modelo.
		$model=new SolicitudBajaMateria;

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);
		
		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['SolicitudBajaMateria']))
		{
			// Almacena el nombre de usuario del usuario actual.
			$mat = Yii::app()->user->id;
			
			// Valida si el usuario actual es un alumno.
			if(Yii::app()->user->rol == 'Alumno'){
			
				// Asigna al modelo los atributos.
				$model->attributes=$_POST['SolicitudBajaMateria'];
				
				// Asigna al modelo la matrícula del usuario.
				$model->setAttribute('matriculaalumno',$mat);
				
				// Asigna al modelo el año actual.
				$model->setAttribute('anio',date('Y'));
				
				// Valida si fue posible registrar el modelo en la base de
				// datos.
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
		}

		// Despliega la forma para
		// crear una nueva solicitud de
		// baja de materia.
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Actualiza un modelo en particular.
	 * Si la actualización es exitosa, el navegador será redirigido a la página 'view'.
	 * @param integer $id el ID del modelo a actualizar
	 */
	public function actionUpdate($id)
	{
		// Carga el modelo a actualizar.
		$model=$this->loadModel($id);

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['SolicitudBajaMateria']))
		{
			// Asigna al modelo los atributos.
			$model->attributes=$_POST['SolicitudBajaMateria'];
			
			// Valida si el usuario actual es un alumno.
			if(Yii::app()->user->rol == 'Alumno'){
				
				// Valida que el modelo de la solicitud le corresponda al usuario
				// actual.
				if($model->matriculaalumno == Yii::app()->user->id){
				
					// Valida si se pudo registrar el modelo en la base de datos.
					if($model->save()){
						
						// Valida si es necesario enviar un e-mail al usuario.
						if($this->needsToSendMail($model)) {
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));
					}
				
				}else{
					throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
				}
				
			// Valida si el usuario actual es un director de carrera.
			}else if(Yii::app()->user->rol == 'Director'){
				
				// Almacena la matrícula que corresponde al alumno de
				// la solicitud.
				$matricula = $model->matriculaalumno;
				
				// Almacena el nombre de usuario del usuario actual.
				$nomina = Yii::app()->user->id;
				
				// Verifica que la solicitud de baja de materia corresponda a uno de los alumnos del
				// director de carrera. Obtiene un registro de la base de datos, mediante una sentencia de
				// JOIN de SQL, comprobando que la condición se cumple.
				$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
			
				// Verifica que la variable $challenge no esté vacía. Es decir, que
				// la solicitud de baja de materia corresponda a uno de los alumnos
				// del director de carrera. De lo contrario se lanza una excepción de
				// HTTP con una descripción del error.
				if(!empty($challenge)){
				
					// Valida si los cambios en el modelo pudieron ser registrados en
					// la base de datos.
					if($model->save()) {
						
						// Valida si es necesario enviar un e-mail al alumno que creó la
						// solicitud.
						if($this->needsToSendMail($model)) {
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				
				}else{
					throw new CHttpException(400,'No se encontró la solicitud a editar.');
				}
			
			// El resto de los casos, que corresponde a los administradores generales.
			}else{
				
				// Valida si los cambios en el modelo pudieron ser
				// grabados en la base de datos.
				if($model->save()) {
				
					// Valida si es necesario enviar un e-mail al alumno que creó
					// la solicitud de baja de materia.
					if($this->needsToSendMail($model)) {
						EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
														getEmailAddress($model->matriculaalumno));

					}
				
					$this->redirect(array('view','id'=>$model->id));

				}
			}
		}
		
		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){

			// Valida si el modelo le corresponde al usuario actual.
			if(Yii::app()->user->id == $model->matriculaalumno){
			
				// Despliega la forma para actualizar la
				// solicitud de baja de materia.
				$this->render('update',array(
					'model'=>$model,
				));
				
			}else{
				
				// El modelo no le corresponde al usuario actual. Entonces se
				// lanza una excepción de HTTP, con una descripción del error.
				throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
			}
		
		// Valida si el usuario actual es un director de carrera.
		}else if(Yii::app()->user->rol == 'Director'){
			
			// Almacena la matrícula del alumno al que le corresponde la solicitud.
			$matricula = $model->matriculaalumno;
			
			// Almacena el nombre de usuario del usuario actual.
			$nomina = Yii::app()->user->id;
			
			// Intenta obtener un registro de la base de datos, mediante una sentencia JOIN de SQL.
			// Si la obtención es exitosa significa que la solicitud de baja de materia corresponde
			// a uno de los alumnos del director de carrera.
			$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
		
			// Valida que la variable $challenge no esté vacía. De lo contrario se
			// lanza una excepción de HTTP, con una descripción del error.
			if(!empty($challenge)){
			
				// Se despliega la forma para actualizar la
				// solicitud de baja de materia.
				$this->render('update',array(
					'model'=>$model,
				));
			
			}else{
				throw new CHttpException(400,'No se encontró la solicitud a editar.');
			}
		
		// Valida si el usuario actual es un administrador general.
		}else{
			
			// Se despliega la forma para actualizar la 
			// solicitud de baja de materia.
			$this->render('update',array(
				'model'=>$model,
			));
		}
	}
	
	/**
	 * Método de prueba para verificar si el usuario actual
	 * está autorizado para realizar la acción de 'index'.
	 */
	public function actionRevisar(){
		if(Yii::app()->user->checkAccess('index') == TRUE){
			echo('acceso permitido');
		}else{
			echo('acceso negado');
		}
	}
	
	/**
	 * Cambia el estatus de alguna solicitud de baja de materia a
	 * 'Terminada'.
	 * @param CModel el modelo cuyo estatus se modificará
	 * @return CModel el modelo con el estatus cambiado a 'Terminada'
	 */
	public function needsToSendMail($model)
	{
		return $model->attributes['status'] == 'terminada';
	}
	
	/**
	 * Crea el cuerpo del e-mail que se enviará al
	 * alumno que creó la solicitud de baja de materia.
	 * En el cuerpo del mensaje se indican la clave y el
	 * nombre de la materia a dar de baja.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @return string el cuerpo del e-mail
	 */
	public function createEmailBody($model) 
	{
		$body = "";
		$body .= "\nClave de la materia: ".$model->clave_materia;
		$body .= "\nNombre de la materia: ".$model->nombre_materia;
		return $body;
	}
	
	/**
	 * Crea el asunto del e-mail que se enviará al
	 * alumno que creó la solicitud de baja de materia.
	 * Se especifica en el asunto el ID de la solicitud de
	 * baja de materia.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @param string el asunto del e-mail
	 */
	public function createSubject($model)
	{
		$subject = "Solicitud de Baja de Materia con ID: ".$model->id;
		return $subject;
	}

	/**
	 * Elimina un modelo en particular.
	 * Si la eliminación es exitosa, el navegador será redirigido a la página de 'admin'.
	 * @param integer $id el ID del modelo a eliminar
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// Solo se permite eliminación vía una petición POST.
			
			$this->loadModel($id)->delete();

			// Si es una petición AJAX (impulsada por eliminación vía la vista de tabla de admin) no se redirige al
			// navegador
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}		
		else	
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Enlista a todos los modelos, dependiendo del rol del usuario.
	 */
	public function actionIndex()
	{
		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){
		
			// Almacena el nombre de usuario (matrícula) del usuario actual.
			$mat = Yii::app()->user->id;
			
			// Criterios para obtener las solicitudes de baja de materia
			// del usuario actual
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
					
			// Obtiene los modelos de todas las solicitudes de baja de materia
			// del usuario actual.
			$solicitudes=SolicitudBajaMateria::model()->findall($criteria);
			
			// Criterios para ordenar las solicitudes de baja de materia
			// del usuario actual, al momento de desplegarlas
			$dataProvider= new CArrayDataProvider(
				$solicitudes, array(
					'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora DESC',
						
				),
			));
			
		// Valida si el usuario actual es un director de carrera.	
		}else if (Yii::app()->user->rol == 'Director'){
			
			// Almacena el nombre de usuario (nómina) del usuario actual.
			$nomina = Yii::app()->user->id;
		
			// Criterios para obtener las solicitudes de baja de materia
			// de los alumnos del usuario actual
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));
	
			// Obtiene los modelos de todas las solicitudes de 
			// baja de materia de los alumnos del usuario actual.
			$solicitudes_para_directores = SolicitudBajaMateria::model()->findall($criteria_directores);
			
			// Criterios para ordenar las solicitudes de baja de materia de
			// los alumnos del usuario actual, al momento de desplegarlas
			$dataProvider = new CArrayDataProvider ($solicitudes_para_directores, array(
				'sort'=> array(
					'attributes'=> array(
						'fechahora',
						),
					'defaultOrder'=>'fechahora DESC'
					),
			));
						
		// Valida si el usuario actual es un administrador general.
		}else if(Yii::app()->user->rol == 'Admin'){
			
			// Criterios para ordenar las solicitudes de baja de materia de
			// todos los alumnos, al momento de desplegarlas
			$dataProvider = new CActiveDataProvider('SolicitudBajaMateria', array(
				'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora DESC'
						),
					)
			);
		}
		
		// Despliega una página con información de las
		// solicitudes de baja de materia.
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new SolicitudBajaMateria('search');
		$model->unsetAttributes();  // Elimina los valores por defecto.
		if(isset($_GET['SolicitudBajaMateria']))
			$model->attributes=$_GET['SolicitudBajaMateria'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Devuelve el modelo de datos en base a la llave primaria proporcionada en la variable GET.
	 * Si el modelo de datos no es encontrado, se lanzará una excepción de HTTP.
	 * @param integer el ID del modelo a cargar
	 */
	public function loadModel($id)
	{
		$model=SolicitudBajaMateria::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'La página solicitada no existe.');
		return $model;
	}

	/**
	 * Realiza una validación AJAX.
	 * @param CModel el modelo a validar
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='solicitud-baja-materia-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
