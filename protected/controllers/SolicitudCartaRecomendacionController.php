<?php

class SolicitudCartaRecomendacionController extends Controller
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
		// Arreglo con las acciones que se les permite realizar a
		// los directores de carrera
		$adminActions=array('index','admin','update','delete','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
				
		// Criterios para obtener los nombres de usuario de
		// los directores de carrera
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
		
		// Obtiene los modelos de todos los
		// directores de carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los directores de carrera
		$directores = array();
		
		// Almacena en el arreglo $directores los nombres de usuario de
		// todos los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de usuario de
		// todos los asistentes y secretarias.
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto = \'Secretaria\''));
		
		// Obtiene los modelos de todos los asistentes y 
		// secretarias.
		$consulta_asistente = Empleado::model()->findAll($asistente_criteria);
		
		// Arreglo para almacenar los nombres de
		// usuario de todos los asistentes y secretarias.
		$asistentes = array();
		
		// Almacena en el arreglo $asistentes los nombres de
		// usuario de todos los asistentes y secretarias.
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de usuario de
		// los administradores generales
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de todos los
		// administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los administradores generales.
		$admin = array();
		
		// Almacena en el arreglo $admin los nombres de
		// usuario de todos los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
	
		return array(
		
			array('deny',  // Niega el acceso a los asistentes y secretarias.
				'users'=>$asistentes,
			),
			
			array('allow',
						   // Les permite a los usuarios autenticados realizar acciones de
						   // 'create' y 'update'
				'actions'=>array('index','create','view'),
				'users'=>array('@'),
			),
			
			array('allow',
						   // Les permite a los directores de carrera realizar acciones de
						   // 'index', 'admin', 'update', 'delete', 'view_all', 'view',
						   // 'solicitudBajaMateria', 'solicitudBajaSemestre',
						   // 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion' y
						   // 'solicitudRevalidacion'
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			
			array('allow',
						   // Les permite a los administradores generales realizar acciones de
						   // 'index', 'create', 'update', 'view' y 'admin'
				'actions'=>array('index','create','update','view','admin'),
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
			
			// Criterios para obtener la solicitud de carta de
			// recomendación a desplegar.
			$criteria = new CDbCriteria(array(
						'condition'=>'matriculaalumno = '.$mat.' AND id = '.$id));
						
			// Obtiene el modelo de la solicitud de carta de recomendación a
			// desplegar.
			$solicitudes=SolicitudCartaRecomendacion::model()->find($criteria);
			
			// Valida si no se encontró la solicitud de carta de recomendación o 
			// si pertenece a algún otro alumno. En caso de ser así se lanza una
			// excepción de HTTP, con una descripción del error.
			if(sizeof($solicitudes) == 0){
				throw new CHttpException(403,'Usted no está autorizado para realizar esta acción.');
			}
		}
	
		// Despliega una página con información de
		// la solicitud de carta de recomendación.
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
		$model=new SolicitudCartaRecomendacion;

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['SolicitudCartaRecomendacion']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['SolicitudCartaRecomendacion'];
			
			// Almacena el nombre de usuario del usuario actual.
			$mat = Yii::app()->user->id;
			
			// Asigna al modelo la matrícula del alumno.
			$model->setAttribute('matriculaalumno',$mat);
			
			// Valida si el modelo pudo ser registrado en la
			// base de datos.
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		// Despliega la forma para
		// crear una nueva solicitud de
		// carta de recomendación.
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Actualiza un modelo en particular.
	 * Si la actualización es exitosa el navegador será redirigido a la página 'view'.
	 * @param integer $id el ID del modelo a actualizar
	 */
	public function actionUpdate($id)
	{
		// Carga el modelo.
		$model=$this->loadModel($id);

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['SolicitudCartaRecomendacion']))
		{
		
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['SolicitudCartaRecomendacion'];
			
			// Valida si el usuario actual es un alumno.
			if(Yii::app()->user->rol == 'Alumno'){
				
				// Valida si el usuario actual es el creador de la solicitud de
				// carta de recomendación.
				if($model->matriculaalumno == Yii::app()->user->id){
				
					// Valida si se pudieron registrar los cambios en la solicitud, en
					// la base de datos.
					if($model->save()) {
					
						// Valida si se pudo cambiar el estatus de la solicitud de
						// carta de recomendación a 'Terminada'. En caso de ser así, 
						// se envía un e-mail al alumno que creó la solicitud, informándole
						// sobre el cambio.
						if($this->needsToSendMail($model)) {
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				
				// El usuario actual no es el creador de la solicitud de carta de
				// recomendación. En este caso se lanza una excepción de HTTP, con
				// una descripción del error.
				}else{
					throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
				}
				
			// Valida si el usuario actual es un director de carrera.
			}else if (Yii::app()->user->rol == 'Director'){
			
				// Almacena la matrícula del alumno que
				// creó la solicitud.
				$matricula = $model->matriculaalumno;
				
				// Almacena el nombre de usuario (nómina) del
				// usuario actual.
				$nomina = Yii::app()->user->id;
				
				// Valida que la solicitud de carta de recomendación corresponda a
				// alguno de los alumnos del director de carrera. Obtiene un registro de
				// la base de datos, mediante una sentencia JOIN de SQL, comprobando que
				// la condición se cumple.
				$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
			
				// Valida que la variable $challenge no esté vacía. Es decir, que
				// la solicitud de carta de recomendación corresponda a alguno de los
				// alumnos del director de carrera.
				if(!empty($challenge)){
				
					// Valida si se pudieron grabar los cambios en el modelo, en
					// la base de datos.
					if($model->save()) {
					
						// Valida si se pudo cambiar el estatus de la solicitud de
						// carta de recomendación a 'Terminada'. En caso de ser así,
						// se envía un e-mail al alumno que creó la solicitud, informándole
						// sobre el cambio.
						if($this->needsToSendMail($model)) {
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				
				// La solicitud de carta de recomendación no existe o no corresponde a
				// ningún alumno del director de carrera. En este caso se lanza una
				// excepción de HTTP, con una descripción del error.
				}else{
					throw new CHttpException(400,'No se encontró la solicitud a editar.');
				}
			
			// El resto de los casos, que corresponde a los administradores generales.
			}else{
				
				// Valida si se pudieron registrar los cambios en el modelo, en
				// la base de datos.
				if($model->save()) {
				
					// Valida si se pudo cambiar el estatus de la solicitud de carta de
					// recomendación a 'Terminada'. En caso de ser así, se envía un
					// e-mail al alumno que creó la solicitud, informándole sobre el
					// cambio.
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
			
			// Valida si el usuario actual es el creador de
			// la solicitud de carta de recomendación. En caso de
			// ser así, despliega la forma para actualizar la solicitud.
			if(Yii::app()->user->id == $model->matriculaalumno){
				
				// Despliega la forma para actualizar la solicitud de
				// carta de recomendación.
				$this->render('update',array(
				'model'=>$model,
				));
				
			// El usuario actual no es el creador de la solicitud de
			// carta de recomendación. Se lanza una excepción de HTTP, con
			// una descripción del error.
			}else{
				throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
			}
		
		// Valida si el usuario actual es un director de carrera.
		}else if (Yii::app()->user->rol == 'Director'){
			
			// Almacena la matrícula del alumno que creó la
			// solicitud de carta de recomendación.
			$matricula = $model->matriculaalumno;
			
			// Almacena el nombre de usuario (nómina) del
			// usuario actual.
			$nomina = Yii::app()->user->id;
			
			// Valida si la solicitud de carta de recomendación corresponde a
			// algún alumno del director de carrera. Obtiene un registro de la
			// base de datos en base a una sentencia JOIN de SQL, comprobando que
			// la condición se cumple.
			$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
		
			// Valida si la variable $challenge no está vacía. Es decir,
			// si la solicitud de carta de recomendación corresponde a algún
			// alumno del director de carrera.
			if(!empty($challenge)){
				
				// Se despliega la forma para actualizar la
				// solicitud de carta de recomendación.
				$this->render('update',array(
					'model'=>$model,
				));
		
			// La solicitud de carta de recomendación no existe o no
			// corresponde a ningún alumno del director de carrera. En este
			// caso se lanza una excepción de HTTP, con una descripción del
			// error.
			}else{
				throw new CHttpException(400,'No se encontro la solicitud a editar.');
			}
		
		// El resto de los casos, que corresponde a los administradores generales.
		}else{
		
			// Se despliega la forma para actualizar la
			// solicitud de carta de recomendación.
			$this->render('update',array(
				'model'=>$model,
			));
			
		}
		
	}
	
	/**
	 * Cambia el estatus de una solicitud de carta de
	 * recomendación a 'Terminada'.
	 * @param CModel el modelo cuyo estatus se modificará
	 * @return CModel el modelo con el estatus cambiado a 'Terminada'
	 */
	public function needsToSendMail($model)
	{
		return $model->attributes['status'] == 'terminada';
	}
	
	/**
	 * Crea el cuerpo del e-mail que se enviará al alumno que
	 * creó la solicitud de carta de recomendación.
	 * En el cuerpo del mensaje se especifican el tipo y
	 * el formato de la carta de recomendación.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @return string el cuerpo del e-mail
	 */
	public function createEmailBody($model) 
	{
		$body = "";
		$body .= "\nCarta de Recomendacion";
		$body .= "\nTipo: ".$model->tipo;
		$body .= "\nFormato: ".$model->formato;
		return $body;
	}
	
	/**
	 * Crea el asunto del e-mail que se enviará al alumno que
	 * creó la solicitud de carta de recomendación.
	 * En el asunto se especifica el ID de la solicitud.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @return string el asunto del e-mail
	 */
	public function createSubject($model)
	{
		$subject = "Solicitud de Carta de Recomendacion con ID: ".$model->id;
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
			// Solo se permite eliminación vía una petición POST.
			$this->loadModel($id)->delete();

			// Si es una petición AJAX (impulsada por eliminación vía la vista de tabla de admin) no se
			// debe redirigir al navegador.
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Petición no valida. Por favor no repita esta petición.');
	}

	/**
	 * Enlista a todos los modelos, dependiendo del rol del usuario.
	 */
	public function actionIndex()
	{
		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){
		
			// Obtiene el nombre de usuario (matrícula) del
			// usuario actual.
			$mat = Yii::app()->user->id;
			
			// Criterios para obtener las solicitudes de
			// carta de recomendación del usuario actual.
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
					
			// Obtiene las solicitudes de carta de recomendación del
			// usuario actual.
			$solicitudes=SolicitudCartaRecomendacion::model()->findall($criteria);
			
			// Criterios para ordenar las solicitudes de
			// carta de recomendación al momento de desplegarlas.
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
		
			// Criterios para obtener las solicitudes de carta de
			// recomendación de aquellos alumnos del director de carrera.
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));
			
			// Obtiene los modelos de las solicitudes de carta de 
			// recomendación de aquellos alumnos del director de carrera.
			$solicitudes_para_directores = SolicitudCartaRecomendacion::model()->findall($criteria_directores);
			
			// Criterios para ordenar las solicitudes de carta de
			// recomendación al momento de desplegarlas.
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
			
			// Criterios para ordenar las solicitudes de
			// carta de recomendación al momento de
			// desplegarlas.
			$dataProvider = new CActiveDataProvider('SolicitudCartaRecomendacion', array(
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
		// las solicitudes de carta de recomendación.
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new SolicitudCartaRecomendacion('search');
		$model->unsetAttributes();  // Elimina los valores por default.
		if(isset($_GET['SolicitudCartaRecomendacion']))
			$model->attributes=$_GET['SolicitudCartaRecomendacion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Devuelve el modelo de datos en base a la llave primaria proporcionada en la variable GET.
	 * Si el modelo de datos no es encontrado, se lanzará una excepción HTTP.
	 * @param integer el ID del modelo a cargar
	 */
	public function loadModel($id)
	{
		$model=SolicitudCartaRecomendacion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='solicitud-carta-recomendacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
