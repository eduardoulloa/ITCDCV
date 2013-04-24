<?php

class SugerenciaController extends Controller
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
		// Arreglo con las acciones de los directores de carrera y asistentes
		$adminActions=array('index','admin','update','delete','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
				
		// Criterios para obtener los nombres de usuario (nóminas) de
		// todos los directores de carrera
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
		
		// Obtiene los modelos de todos los directores de
		// carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de usuario (nóminas) de
		// todos los directores de carrera
		$directores = array();
		
		// Almacena en el arreglo $directores los nombres de usuario (nóminas) de
		// los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de usuario (nóminas) de
		// los asistentes y secretarias
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto=\'Secretaria\''));
		
		// Obtiene los modelos de todos los asistentes y secretarias.
		$consulta_asistente = Empleado::model()->findAll($asistente_criteria);
		
		// Arreglo para almacenar los nombres de usuario (nóminas) de
		// los asistentes y secretarias
		$asistentes = array();
		
		// Almacena en el arreglo $asistentes los nombres de usuario (nóminas) de
		// los asistentes y secretarias.
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		// Arreglo con las acciones de los administradores generales
		$admin_acciones = array('index','create','update','view','admin','delete');
		
		// Condiciones para obtener los nombres de usuario de
		// los administradores generales
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de todos los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de todos los
		// administradores generales
		$admin = array();
		
		// Almacena en el arreglo $admin los nombres de usuario de
		// todos los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
	
		return array(
			
			// Les permite a los usuarios autenticados realizar acciones de
			// 'index', 'create' y 'view'.
			array('allow',
				'actions'=>array('index','create','view'),
				'users'=>array('@'),
			),
			
			// Les permite a los administradores generales realizar acciones de
			// 'index', 'create', 'update', 'view', 'admin' y 'delete'
			array('allow',
				'actions'=>$admin_acciones,
				'users'=>$admin,
			),
			
			// Les permite a los directores de carrera realizar acciones de
			// 'index', 'admin', 'update', 'delete', 'view_all', 'view',
			// 'solicitudBajaMateria', 'solicitudBajaSemestre', 'solicitudCartaRecomendacion', 
			// 'solicitudProblemasInscripcion' y 'solicitudRevalidacion'
			array('allow',
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			
			// Les permite a los asistentes realizar acciones de
			// 'index', 'admin', 'update', 'delete', 'view_all', 'view',
			// 'solicitudBajaMateria', 'solicitudBajaSemestre', 'solicitudCartaRecomendacion', 
			// 'solicitudProblemasInscripcion' y 'solicitudRevalidacion'
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
			$criteria = new CDbCriteria(array(
						'condition'=>'matriculaalumno = '.$mat.' AND id = '.$id));
						
			// Obtiene el modelo de la sugerencia.
			$sugerencias=Sugerencia::model()->find($criteria);
			
			// Valida si el arreglo $sugerencias está
			// vacío. Si está vacío significa que la sugerencia no
			// existe o no fue creada por el usuario actual. En este
			// caso se lanza una excepción de HTTP, con una descripción del
			// error.
			if(sizeof($sugerencias) == 0){
				throw new CHttpException(403,'Usted no está autorizado para realizar esta acción.');
			}
		}
		
		// Despliega una página con información de
		// la sugerencia.
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
		$model=new Sugerencia;

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['Sugerencia']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['Sugerencia'];
			
			// Almacena el nombre de usuario (matrícula) del
			// usuario actual.
			$mat = Yii::app()->user->id;
			
			// Asigna la matrícula del alumno al modelo.
			$model->setAttribute('matriculaalumno',$mat);
			
			// Valida si se pudo registrar el modelo en
			// la base de datos.
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		// Despliega una forma para crear la
		// nueva sugerencia.
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
		if(isset($_POST['Sugerencia']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['Sugerencia'];
		
			// Valida si el usuario actual es un director o un asistente.
			if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' ){
			
				// Almacena la matrícula del alumno que creó la
				// sugerencia.
				$matricula = $model->matriculaalumno;
				
				// Almacena el nombre de usuario del usuario actual.
				$nomina = Yii::app()->user->id;
				
				// Valida que el alumno que creó la sugerencia esté
				// inscrito en alguna de las carreras en las que labora
				// el usuario actual.
				$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
			
				// Valida que la variable $challenge no esté vacía; es decir,
				// que el alumno que creó la sugerencia esté inscrito en alguna
				// de las carreras en las que labora el usuario actual.
				if(!empty($challenge)){
				
					// Valida si los cambios hechos en el modelo pudieron
					// ser registrados en la base de datos.
					if($model->save()) {
					
						// Valida si el estatus de la sugerencia pudo ser cambiado a
						// 'Terminada'.
						if($this->needsToSendMail($model)) {
							
							// Envía un e-mail al usuario que creó la sugerencia. En
							// el e-mail se le informa al alumno sobre el cambio hecho en
							// el estatus de la sugerencia.
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				
				// La sugerencia no existe o no fue creada por ningún
				// alumno registrado en las carreras en las que
				// labora el usuario actual. En este caso se lanza una
				// excepción de HTTP, con una descripción del error.
				}else{
				
					throw new CHttpException(400,'No se encontró la solicitud a editar.');
					
				}
				
			// El resto de los casos, que corresponde a los administradores generales
			}else{
				
				// Valida si los cambios hechos en el modelo pudieron
				// ser registrados en la base de datos.
				if($model->save())
				{
					// Valida si el estatus de la sugerencia se pudo cambiar a
					// 'Terminada'.
					if($this->needsToSendMail($model)) {
						
						// Envía un e-mail al alumno que creó la sugerencia. En el
						// e-mail se le informa al alumno sobre el cambio en el
						// estatus de la sugerencia.
						EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
														getEmailAddress($model->matriculaalumno));
														
					}
					
					$this->redirect(array('view','id'=>$model->id));
				}
				
			}
			
		}
		
		// Valida si el usuario actual es un director de carrera o un asistente.
		if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' ){
			
			// Almacena la matrícula del alumno que creó la sugerencia.
			$matricula = $model->matriculaalumno;
			
			// Almacena el nombre de usuario del usuario actual.
			$nomina = Yii::app()->user->id;
			
			// Valida que el alumno que creó la sugerencia esté
			// inscrito en alguna de las carreras en las que
			// labora el usuario actual.
			$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
		
			// Valida si la variable $challenge no está vacía; es decir,
			// si el alumno que creó la solicitud está inscrito en
			// alguna de las carreras en las que labora el usuario actual.
			if(!empty($challenge)){
				
				// Despliega una forma para actualizar la
				// sugerencia.
				$this->render('update',array(
					'model'=>$model,
				));
			
			// El alumno que creó la solicitud no está inscrito en ninguna de
			// las carreras en las que labora el usuario actual.
			}else{
				throw new CHttpException(400,'No se encontro la solicitud a editar.');
			}
			
		// El resto de los casos, que corresponde a los administradores generales
		}else{
			
			// Despliega una forma para actualizar la
			// sugerencia.
			$this->render('update',array(
				'model'=>$model,
			));
			
		}
		
	}
	
	/**
	 * Cambia el estatus de una sugerencia a
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
	 * alumno que creó la sugerencia. El cuerpo del
	 * mensaje contiene los detalles de la sugerencia
	 * elaborada por el alumno y la respuesta del
	 * director o asistente.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @return string el cuerpo del e-mail
	 */
	public function createEmailBody($model) 
	{
		$body = "";
		$body .= "\nSUGERENCIA:".$model->sugerencia;
		$body .= "\nRESPUESTA: ".$model->respuesta;
		return $body;
	}
	
	/**
	 * Crea el asunto del e-mail que será enviado al
	 * alumno que creó la sugerencia. En el asunto se
	 * indica el ID de la sugerencia.
	 * @param CModel el modelo a partir del cual se enviará el e-mail
	 * @return string el asunto del e-mail
	 */
	public function createSubject($model)
	{
		$subject = "Sugerencia con ID: ".$model->id;
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
			throw new CHttpException(400,'Petición no válida. Por favor no repita esta petición.');
	}

	/**
	 * Enlista a todos los modelos, dependiendo del rol del usuario.
	 */
	public function actionIndex()
	{
		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){
			
			// Almacena el nombre de usuario (matrícula) del
			// alumno actual.
			$mat = Yii::app()->user->id;
			
			// Criterios para obtener las sugerencias del
			// alumno
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
			
			// Obtiene los modelos de las sugerencias creadas por el
			// alumno.
			$solicitudes=Sugerencia::model()->findall($criteria);
			
			// Criterios para ordenar las sugerencias al
			// momento de desplegarlas.
			$dataProvider= new CArrayDataProvider(
				$solicitudes, array(
					'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora DESC'
						),
					));
		
		// Valida si el usuario es un director de carrera, un asistente, o una secretaria.
		}else if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' ||  Yii::app()->user->rol == 'Secretaria'){
			
			// Almacena el nombre de usuario (nómina) del
			// usuario actual.
			$nomina = Yii::app()->user->id;
		
			// Criterios para obtener las sugerencias de los
			// alumnos que están inscritos en las carreras en las que
			// labora el usuario actual.
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));
			
			// Obtiene los modelos de las sugerencias de los
			// alumnos que están inscritos en las carreras en las que
			// labora el usuario actual.
			$solicitudes_para_directores = Sugerencia::model()->findall($criteria_directores);
			
			// Criterios para ordenar las sugerencias al
			// momento de desplegarlas
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
			
			// Criterios para ordenar las sugerencias al
			// momento de desplegarlas
			$dataProvider = new CActiveDataProvider('Sugerencia', array(
				'sort'=>array(
						'attributes'=>array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora DESC'
						),
					)
			);
			
		}
		
		// Despliega una página con información de las
		// sugerencias.
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new Sugerencia('search');
		$model->unsetAttributes();  // Elimina los valores por defecto.
		if(isset($_GET['Sugerencia']))
			$model->attributes=$_GET['Sugerencia'];

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
		$model=Sugerencia::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sugerencia-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
