<?php

class SolicitudBajaSemestreController extends Controller
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
		// Arreglo con las acciones de los administradores generales y los
		// directores de carrera.
		$adminActions=array('index','admin','update','delete','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
				
		// Criterios para obtener los nombres de usuario de
		// todos los directores de carrera.
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
						
		// Obtiene los modelos de todos los directores de carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de usuario de todos los
		// directores de carrera.
		$directores = array();
		
		// Almacena en el arreglo $directores los nombres de usuario de
		// todos los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de usuario de todos los
		// asistentes y secretarias.
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto = \'Secretaria\''));
		
		// Obtiene los modelos de todos los asistentes y secretarias.
		$consulta_asistente = Empleado::model()->findAll($asistente_criteria);
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los asistentes y secretarias.
		$asistentes = array();
		
		// Almacena en el arreglo $asistentes los nombres de usuario de
		// todos los asistentes y secretarias.
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de usuario de
		// todos los administradores generales.
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de todos los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los administradores generales.
		$admin = array();
		
		// Almacena en el arreglo $admin los nombres de usuario de
		// todos los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
		// Obtiene los nombres de usuario (matrículas) de todos los
		// alumnos.
		$consulta_alumnos = Alumno::model()->findAll();
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los alumnos.
		$alumnos = array();
		
		// Almacena en el arreglo $alumnos los nombres de
		// usuario de todos los alumnos.
		foreach($consulta_alumnos as &$valor){
			array_push($alumnos, ($valor->matricula).'');
		}
	
		return array(
			
			array('deny',  // Niega a los asistentes y secretarias el
						   // permiso para realizar acciones de 'index', 'create', 'view' y 'update'.
				'actions'=>array('index','create','view','update'),
				'users'=>$asistentes,
			),
			
			array('deny',
				'actions'=>array('update'), // Niega a los alumnos el
											// permiso para realizar la acción de 'update'.
				'users'=>$alumnos,
			),
			
			array('allow', // Les permite a los usuarios autenticados realizar acciones de
						   // 'index', 'create', 'view' y 'update'.
				'actions'=>array('index','create','view','update'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>$adminActions, // Les permite a los directores de carrera realizar
										  // acciones de 'index', 'admin', 'update', 'delete', 'view_all', 
										  // 'view', 'solicitudBajaMateria', 'solicitudBajaSemestre',
										  // 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion'
										  // y 'solicitudRevalidacion'
				'users'=>$directores,
			),
			array('allow', 
				'actions'=>$adminActions, // Les permite a los administradores generales realizar
										  // acciones de 'index', 'admin', 'update', 'delete', 'view_all', 
										  // 'view', 'solicitudBajaMateria', 'solicitudBajaSemestre',
										  // 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion'
										  // y 'solicitudRevalidacion'
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
		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){
			
			// Almacena el nombre de usuario (matrícula) del
			// usuario actual.
			$mat = Yii::app()->user->id;
			
			// Criterios para obtener la solicitud de baja de semestre a
			// desplegar.
			$criteria = new CDbCriteria(array(
						'condition'=>'matriculaalumno = '.$mat.' AND id = '.$id));
						
			// Obtiene la solicitud de baja de semestre a desplegar.
			$solicitudes=SolicitudBajaSemestre::model()->find($criteria);
			
			// Valida que la solicitud de baja de semestre le
			// corresponda al usuario.
			if(sizeof($solicitudes) == 0){
				throw new CHttpException(403,'Usted no está autorizado para realizar esta acción.');
			}
		}
		
		// Despliega una página con información de la
		// solicitud de baja de semestre.
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
		$model=new SolicitudBajaSemestre;

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['SolicitudBajaSemestre']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['SolicitudBajaSemestre'];
			
			// Almacena el nombre de usuario del usuario actual.
			$mat = Yii::app()->user->id;
			
			// Asigna la matrícula (el nombre del usuario) al modelo.
			$model->setAttribute('matriculaalumno',$mat);
			
			// Asigna el año actual al modelo.
			$model->setAttribute('anio',date('Y'));
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		// Despliega la forma para crear la
		// nueva solicitud de baja de semestre.
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
		// Carga el modelo.
		$model=$this->loadModel($id);

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['SolicitudBajaSemestre']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['SolicitudBajaSemestre'];
			
			// Valida si el usuario actual es un alumno.
			if(Yii::app()->user->rol == 'Alumno'){
				
				// Valida si la solicitud de baja de semestre fue creada por el
				// usuario actual.
				if($model->matriculaalumno == Yii::app()->user->id){
				
					// Valida si fue posible registrar los
					// cambios en la base de datos.
					if($model->save()) {
					
						// Valida si fue posible cambiar el estatus de la solicitud de baja de
						// semestre a 'Terminada'. En caso de ser así, envía un e-mail al alumno
						// que creó la solicitud, informándole sobre el cambio.
						if($this->needsToSendMail($model)) {
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				// No se encontró la solicitud de baja de esemestre o no corresponde al
				// usuario actual. En este caso se lanza una excepción de HTTP,
				// con una descripción del error.
				}else{
					throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
				}
				
			// Valida si el usuario actual es un director de carrera.
			}else if (Yii::app()->user->rol == 'Director'){
				
				// Almacena la matrícula del alumno que creó la
				// solicitud.
				$matricula = $model->matriculaalumno;
				
				// Almacena el nombre de usuario (nómina) del usuario
				// actual.
				$nomina = Yii::app()->user->id;
				
				// Verifica mediante una sentencia JOIN de SQL que el
				// alumno que creó la solicitud de baja de semestre corresponda a
				// un alumno del director de carrera.
				$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
			
				// Valida que la variable $challenge no esté vacía, es decir,
				// que en efecto, el alumno que creó la solicitud de baja de semestre sea
				// un alumno del director de carrera.
				if(!empty($challenge)){
					
					// Valida si se pudieron registrar los cambios
					// en los datos de la solicitud, en la base de datos.
					if($model->save()) {
					
						// Valida si fue posible cambiar el estatus de la solicitud de baja de
						// semestre a 'Terminada'. En caso de ser así, envía un e-mail al alumno
						// que creó la solicitud, informándole sobre el cambio.
						if($this->needsToSendMail($model)) {
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));
						}
							
						$this->redirect(array('view','id'=>$model->id));
					}
				
				// La solicitud de baja de semestre no corresponde a ningún alumno del
				// director de carrera o no existe.
				}else{
					throw new CHttpException(400,'No se encontró la solicitud a editar.');
				}
			
			// El resto de los casos, que corresponde a los administradores generales.
			}else{
				
				// Valida si fue posible registrar los cambios en
				// los datos de la solicitud de baja de semestre, en la
				// base de datos.
				if($model->save()) {
				
					// Valida si fue posible cambiar el estatus de la solicitud de
					// baja de semestre a 'Terminada'. En caso de ser así, envía un
					// e-mail al alumno que la creó, informándole sobre el cambio.
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

			// Valida si la solicitud de baja de semestre fue
			// creada por el usuario. En caso de ser así, se despliega la
			// forma para actualizar los datos de la solicitud.
			if(Yii::app()->user->id == $model->matriculaalumno){
				
				$this->render('update',array(
				'model'=>$model,
				));
				
			// La solicitud de baja de semestre no fue creada por el usuario o
			// no existe. En este caso se lanza una excepción de HTTP, con una
			// descripción del error.
			}else{
				throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
			}
		
		// Valida si el usuario actual es un director de carrera.
		}else if (Yii::app()->user->rol == 'Director'){
		
			// Almacena la matrícula del alumno que creó la solicitud de baja de
			// semestre.
			$matricula = $model->matriculaalumno;
			
			// Almacena el nombre de usuario (nómina) del
			// usuario actual.
			$nomina = Yii::app()->user->id;
			
			// Valida, mediante una sentencia JOIN de SQL, que el alumno que creó la
			// solicitud de baja de semestre sea un alumno del director de carrera.
			$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
		
			// Valida que la variable $challenge no esté vacía. Es decir, que
			// el alumno que creó la solicitud de baja de semestre sea un alumno
			// del director de carrera. En caso de ser así, se despliega la forma
			// para actualizar la solicitud.
			if(!empty($challenge)){
			
				$this->render('update',array(
					'model'=>$model,
				));
			
			// El alumno que creó la solicitud de baja de semestre no es un alumno del
			// director de carrera o la solicitud no existe. En este caso se lanza una
			// excepción de HTTP, con una descripción del error.
			}else{
				throw new CHttpException(400,'No se encontro la solicitud a editar.');
			}
		
		// El resto de los casos, que corresponde a los administradores generales.
		}else{
		
			// Despliega la forma para actualizar la solicitud.
			$this->render('update',array(
				'model'=>$model,
			));
		}
	}
	
	/**
	 * Cambia el estatus de una solicitud de baja de semestre a
	 * 'Terminada'.
	 * @param CModel el modelo cuyo estatus se modificará
	 * @return CModel el modelo con el estatus cambiado a 'Terminada'
	 */
	public function needsToSendMail($model)
	{
		return $model->attributes['status'] == 'terminada';
	}
	
	/**
	 * Crea el cuerpo del e-mail que será enviado al
	 * alumno que creó la solicitud de baja de semestre.
	 * En el cuerpo del mensaje se incluye el periodo del semestre
	 * que el alumno está dando de baja.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @return string el cuerpo del e-mail
	 */
	public function createEmailBody($model) 
	{
		$body = "";
		$body .= "\nPeriodo: ".$model->periodo;
		return $body;
	}
	
	/**
	 * Crea el asunto del e-mail que será enviado al
	 * alumno que creó la solicitud de baja de semestre.
	 * En el asunto se especifica el ID de la solicitud.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @return string el asunto del e-mail
	 */
	public function createSubject($model)
	{
		$subject = "Solicitud de Baja de Semestre con ID: ".$model->id;
		return $subject;
	}

	/**
	 * Elimina un modelo en particular.
	 * Si la eliminación es exitosa, el navegador será redirigido a la página 'admin'.
	 * @param integer $id el ID del modelo a eliminar
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// Solo se permite la eliminación vía una petición POST.
			$this->loadModel($id)->delete();

			// Si es una petición AJAX (impulsada por eliminación vía la vista de tabla de admin) el
			// navegador no se redirige.
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
		
			// Almacena el nombre de usuario (matrícula) del
			// usuario actual.
			$mat = Yii::app()->user->id;
			
			// Criterios para obtener las solicitudes de baja de
			// semestre del usuario actual
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
					
			// Obtiene las solicitudes de baja de semestres del usuario actual.
			$solicitudes=SolicitudBajaSemestre::model()->findall($criteria);
			
			// Criterios para ordenar las solicitudes de baja de
			// semestre al momento de desplegarlas
			$dataProvider= new CArrayDataProvider(
					$solicitudes, array(
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
		
		// Valida si el usuario actual es un director de carrera.
		}else if (Yii::app()->user->rol == 'Director'){
			
			// Obtiene el nombre de usuario (nómina) del
			// usuario actual.
			$nomina = Yii::app()->user->id;
		
			// Criterios para obtener las solicitudes de baja de semestre de
			// aquellos alumnos del director de carrera
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));
			
			// Obtiene las solicitudes de baja de semestre de
			// aquellos alumnos del director de carrera.
			$solicitudes_para_directores = SolicitudBajaSemestre::model()->findall($criteria_directores);
			
			// Criterios para ordenar las solicitudes de baja de semestre de
			// aquellos alumnos del director de carrera, al momento de
			// desplegarlas
			$dataProvider = new CArrayDataProvider ($solicitudes_para_directores, array(
					'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						
						));
						
		// Valida si el usuario es un administrador general.
		}else if(Yii::app()->user->rol == 'Admin'){
			
			// Criterios para ordenar las solicitudes de baja de semestre de
			// todos los alumnos, al momento de desplegarlas.
			$dataProvider = new CActiveDataProvider ('SolicitudBajaSemestre', array(
					'sort'=>array(
							'attributes'=>array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
				)
			);
		}
		
		// Despliega una página con información de
		// las solicitudes de baja de semestre.
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new SolicitudBajaSemestre('search');
		$model->unsetAttributes();  // Elimina los valores por defecto.
		if(isset($_GET['SolicitudBajaSemestre']))
			$model->attributes=$_GET['SolicitudBajaSemestre'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Devuele el modelo de datos en base a la llave primaria proporcionada en la variable GET.
	 * Si el modelo de datos no es encontrado, una excepción de HTTP será lanzada.
	 * @param integer el ID del modelo a cargar
	 */
	public function loadModel($id)
	{
		$model=SolicitudBajaSemestre::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Realiza una validación AJAX.
	 * @param CModel el modelo a validar
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='solicitud-baja-semestre-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
