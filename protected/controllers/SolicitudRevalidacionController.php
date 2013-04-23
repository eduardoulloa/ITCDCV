<?php

class SolicitudRevalidacionController extends Controller
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
	 * Este método es empleado por el filtro 'accessControl'.
	 * @return array reglas de control de acceso
	 */
	public function accessRules()
	{
		// Arreglo con las acciones de los directores de carrera y 
		// asistentes
		$adminActions=array('index','admin','update','delete','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
				
		// Criterios para obtener los nombres de
		// usuario (nóminas) de los directores de carrera
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
		
		// Obtiene los modelos de los directores de
		// carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de
		// usuario (nóminas) de los directores de carrera
		$directores = array();
		
		// Almacena en el arreglo $directores los nombres de
		// usuario (nóminas) de los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de
		// usuario (nóminas) de los asistentes y
		// secretarias
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto=\'Secretaria\''));
		
		// Obtiene los modelos de todos los
		// asistentes y secretarias.
		$consulta_asistente = Empleado::model()->findAll($asistente_criteria);
		
		// Arreglo para almacenar las nombres de
		// usuario (nóminas) de todos los asistentes y
		// secretarias
		$asistentes = array();
		
		// Almacena en el arreglo $asistentes los
		// nombres de usuario (nóminas) de todos los
		// asistentes y secretarias
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		// Arreglo con las acciones de los administradores generales
		$admin_acciones = array('index','create','update','view','admin','delete');
		
		// Condiciones para obtener los nombres de
		// usuario de los administradores generales
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de todos los
		// administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de
		// todos los administradores generales
		$admin = array();
		
		// Almacena en el arreglo $admin los
		// nombres de usuario de todos los
		// administradores generales
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
	
		return array(

			// Les permite a los usuarios autenticados realizar
			// acciones de 'index', 'create' y 'view'.
			array('allow',
				'actions'=>array('index','create','view'),
				'users'=>array('@'),
			),
			
			// Les permite a los administradores generales realizar
			// acciones de 'index', 'create', 'update', 'view', 'admin' y 'delete'.
			array('allow',
				'actions'=>$admin_acciones,
				'users'=>$admin,
			),
			
			// Les permite a los directores de carrera realizar
			// acciones de 'index', 'admin', 'update', 'delete', 
			// 'view_all', 'view', 'solicitudBajaMateria', 'solicitudBajaSemestre',
			// 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion' y
			// 'solicitudRevalidacion'.
			array('allow',
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			
			// Les permite a los asistentes y secretarias realizar
			// acciones de 'index', 'admin', 'update', 'delete', 
			// 'view_all', 'view', 'solicitudBajaMateria', 'solicitudBajaSemestre',
			// 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion' y
			// 'solicitudRevalidacion'.
			array('allow',
				'actions'=>$adminActions,
				'users'=>$asistentes,
			),
			
			// Niega a todos los usuarios.
			array('deny',
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
			
			// Criterios para obtener la solicitud de revalidación de materia a
			// desplegar
			$criteria = new CDbCriteria(array(
						'condition'=>'matriculaalumno = '.$mat.' AND id = '.$id));
						
			// Obtiene el modelo de la solicitud a desplegar.
			$solicitudes=SolicitudRevalidacion::model()->find($criteria);
			
			// Valida si el arreglo $solicitudes está vacío. En caso de
			// ser así, significa que el modelo no fue encontrado o no fue
			// creado por el usuario actual. En este caso se lanza
			// una excepción de HTTP con una descripción del error.
			if(sizeof($solicitudes) == 0){
				throw new CHttpException(403,'Usted no está autorizado para realizar esta acción.');
			}
		}
		
		// Se muestra una página con información de la solicitud de
		// revalidación de materia.
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
		$model=new SolicitudRevalidacion;

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['SolicitudRevalidacion']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['SolicitudRevalidacion'];
			
			// Almacena el nombre de usuario (matrícula) del
			// usuario actual.
			$mat = Yii::app()->user->id;
			
			// Asigna la matrícula del alumno al modelo.
			$model->setAttribute('matriculaalumno',$mat);
			
			// Asigna el año actual al modelo.
			$model->setAttribute('anio',date('Y'));
			
			// Valida si se pudo grabar el modelo en la
			// base de datos.
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		// Despliega una forma para crear la
		// solicitud de revalidación de materia.
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
		if(isset($_POST['SolicitudRevalidacion']))
		{
			// Se le asignan los atributos al modelo.
			$model->attributes=$_POST['SolicitudRevalidacion'];
			
			// Valida si el usuario actual es un alumno.
			if(Yii::app()->user->rol == 'Alumno'){
				
				// Valida si el usuario actual es el creador de la
				// solicitud de revalidación de materia.
				if($model->matriculaalumno == Yii::app()->user->id){
				
					// Valida si fue posible grabar los cambios hechos al
					// modelo en la base de datos.
					if($model->save()) {
					
						// Valida si fue posible cambiar el estatus de la
						// solicitud a 'Terminada'.
						if($this->needsToSendMail($model)) {
						
							// Envía un e-mail al alumno que creó la
							// solicitud de revalidación de materia.
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				
				// El usuario actual no es el creador de la solicitud de
				// revalidación de materia. En este caso se lanza una
				// excepción de HTTP, con una descripción del error.
				}else{
					throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
				}
			
			// Valida si el usuario actual es un director de carrera, un asistente, o una secretaria.
			}else if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria' ){
			
				// Almacena la matrícula del alumno que
				// creó la solicitud de revalidación de materia.
				$matricula = $model->matriculaalumno;
				
				// Almacena el nombre de usuario del
				// usuario actual.
				$nomina = Yii::app()->user->id;
				
				// Valida si el alumno que creó la solicitud de
				// revalidación de materia pertenece a alguna de
				// las carreras en las que labora el usuario actual.
				$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
			
				// Valida que la variable $challenge no esté vacía; es decir, que
				// el alumno que haya creado la solicitud de revalidación de
				// materia pertenezca a alguna de las carreras en las que
				// labora el usuario actual.
				if(!empty($challenge)){
				
					// Valida si los cambios hechos en el modelo pudieron
					// ser grabados en la base de datos.
					if($model->save()) {
					
						// Valida si el estatus de la solicitud de
						// revalidación de materia se pudo cambiar a
						// 'Terminada'.
						if($this->needsToSendMail($model)) {
							
							// Envía un e-mail al alumno que creó la solicitud de
							// revalidación de materia. En el e-mail se le informa al
							// alumno sobre el cambio de estatus en la solicitud.
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				
				// La solicitud de revalidación de materia no existe o no pertenece a
				// ninguno de los alumnos de las carreras en las que labora el usuario. En este
				// caso se lanza una excepción de HTTP, con una descripción del error.
				}else{
					throw new CHttpException(400,'No se encontró la solicitud a editar.');
				}
			
			// El resto de los casos, que corresponde a los administradores generales.
			}else{
			
				// Valida si los cambios hechos al modelo pudieron ser
				// registrados en la base de datos.
				if($model->save()) {
				
					// Valida si se pudo cambiar el estatus de la solicitud de
					// revalidación de materia a 'Terminada'.
					if($this->needsToSendMail($model)) {
						
						// Envía un e-mail al alumno que creó la solicitud de
						// revalidación de materia. En el e-mail se le informa al
						// alumno sobre el cambio realizado en el estatus de la
						// solicitud.
						EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
														getEmailAddress($model->matriculaalumno));

					}
				
					$this->redirect(array('view','id'=>$model->id));

				}
			}
		}
		
		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){

			// Valida si el usuario actual es el creador de la
			// solicitud de revalidación de materia.
			if(Yii::app()->user->id == $model->matriculaalumno){
				
				// Despliega una forma para actualizar la
				// solicitud de revalidación de materia.
				$this->render('update',array(
				'model'=>$model,
				));
			
			// El usuario actual no es el creador de la
			// solicitud de revalidación de materia. En este caso se
			// lanza una excepción de HTTP, con una descripción del
			// error.
			}else{
				throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
			}

		// Valida si el usuario actual es un director de carrera, un asistente, o una secretaria.
		}else if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria' ){
			
			// Almacena la matrícula del alumno que creó la solicitud de
			// revalidación de materia.
			$matricula = $model->matriculaalumno;
			
			// Almacena el nombre de usuario del
			// usuario actual.
			$nomina = Yii::app()->user->id;
			
			// Valida que el alumno que creó la solicitud pertenezca a
			// alguna de las carreras en las que labora el usuario actual.
			$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
		
			// Valida que la variable $challenge no esté vacía; es decir, que
			// el alumno que creó la solicitud pertenezca a alguna de las carreras en
			// las que labora el usuario actual.
			if(!empty($challenge)){
			
				// Despliega una forma para actualizar la
				// solicitud de revalidación de materia.
				$this->render('update',array(
					'model'=>$model,
				));
		
			// La solicitud de revalidación de materia no existe o no fue creada por
			// ningún alumno de las carreras en las que labora el usuario actual.
			}else{
				throw new CHttpException(400,'No se encontro la solicitud a editar.');
			}
		
		// El resto de los casos, que corresponde a los administradores generales
		}else{
			
			// Despliega una forma para actualizar la
			// solicitud de revalidación de materia.
			$this->render('update',array(
				'model'=>$model,
			));
			
		}
		
	}
	
	/**
	 * Cambia el estatus de una solicitud a
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
	 * alumno que creó la solicitud de revalidación de
	 * materia. En el cuerpo del mensaje se incluyen las
	 * claves y los nombres de las materias a revalidar y de las
	 * materias cursadas, respectivamente. 
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @param string el cuerpo del e-mail
	 */
	public function createEmailBody($model) 
	{
		$body = "";
		$body .= "\nMateria a Revalidar: ".$model->clave_revalidar." ".$model->nombre_revalidar;
		$body .= "\nMateria Cursada: ".$model->clave_cursada." ".$model->nombre_cursada;
		return $body;
	}
	
	/**
	 * Crea el asunto del e-mail que se enviará al
	 * alumno que creó la solicitud de revalidación de
	 * materia. En el asunto del mensaje se incluye el
	 * ID de la solicitud.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @return string el asunto del e-mail
	 */
	public function createSubject($model)
	{
		$subject = "Solicitud de Revalidacion de Materia con ID: ".$model->id;
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

			// Si es una petición AJAX (impulsada por eliminación vía la vista de tabla de admin) no se debe
			// redirigir al navegador.
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
	
		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){
		
			// Almacena el nombre de usuario (matrícula) del
			// usuario actual.
			$mat = Yii::app()->user->id;
			
			// Criterios para obtener las solicitudes de revalidación de
			// materia del usuario actual
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
					
			// Obtiene los modelos de las solicitudes de revalidación de
			// materia del usuario actual.
			$solicitudes=SolicitudRevalidacion::model()->findall($criteria);
			
			// Criterios para ordenar las solicitudes de revalidación de
			// materia al momento de desplegarlas
			$dataProvider= new CArrayDataProvider(
					$solicitudes, array(
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
		
		// Valida si el usuario actual es un director de carrera, un asistente, o una secretaria.
		}else if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
			
			// Almacena el nombre de usuario del
			// usuario actual.
			$nomina = Yii::app()->user->id;
		
			// Criterios para obtener las solicitudes de revalidación de materia de
			// aquellos alumnos inscritos en las carreras donde labora el
			// usuario actual.
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));
			
			// Obtiene los modelos de las solicitudes de revalidación de
			// materia de aquellos alumnos inscritos en las carreras donde labora el
			// usuario actual.
			$solicitudes_para_directores = SolicitudRevalidacion::model()->findall($criteria_directores);
			
			// Criterios para ordenar las solicitudes de revalidación de
			// materia al momento de desplegarlas
			$dataProvider = new CArrayDataProvider ($solicitudes_para_directores, array(
					'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
		
		// Valida si el usuario actual es un administrador general.
		}else if (Yii::app()->user->rol == 'Admin'){
			
			// Criterios para ordenar las solicitudes de revalidación de
			// materia al momento de desplegarlas
			$dataProvider = new CActiveDataProvider('SolicitudRevalidacion', array(
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
		// las solicitudes de revalidación de materia.
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new SolicitudRevalidacion('search');
		$model->unsetAttributes();  // Elimina los valores por defecto.
		if(isset($_GET['SolicitudRevalidacion']))
			$model->attributes=$_GET['SolicitudRevalidacion'];

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
		$model=SolicitudRevalidacion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'La página solicitada no existe.');
		return $model;
	}

	/**
	 * Realiza la validación AJAX.
	 * @param CModel el modelo a validar
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='solicitud-revalidacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
