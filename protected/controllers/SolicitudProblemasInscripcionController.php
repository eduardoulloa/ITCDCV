<?php

class SolicitudProblemasInscripcionController extends Controller
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
	
		// Arreglo con las acciones de los directores de
		// carrera
		$adminActions=array('index','admin','update','delete','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
				
		// Criterios para obtener los nombres de usuario (nóminas) de
		// los directores de carrera
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
		
		// Obtiene los modelos de los directores de carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de usuario (nóminas) de
		// los directores de carrera
		$directores = array();
		
		// Almacena en el arreglo $directores los nombres de usuario (nóminas) de
		// los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Criterios para obtener los nombres de usuario de
		// los asistentes y secretarias
		$asistente_criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Asistente\' OR puesto=\'Secretaria\''));
		
		// Obtiene los modelos de los asistentes y secretarias.
		$consulta_asistente = Empleado::model()->findAll($asistente_criteria);
		
		// Arreglo para almacenar los nombres de usuario de
		// los asistentes y secretarias
		$asistentes = array();
		
		// Almacena en el arreglo $asistentes los nombres de
		// usuario de los asistentes y secretarias.
		foreach($consulta_asistente as &$valor){
			array_push($asistentes, ($valor->nomina).'');
		}
		
		// Arreglo con las acciones de los administradores generales
		$admin_acciones = array('index','create','update','view','admin','delete');
		
		// Criterios para obtener los nombres de usuario de los
		// administradores generales
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de
		// los administradores generales
		$admin = array();
		
		// Almacena en el arreglo $admin los nombres de
		// usuario de los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
		return array(
			
			// Les permite a los usuarios autenticados realizar
			// acciones de 'create' y 'perform'.
			array('allow',
				'actions'=>array('index','create','view'),
				'users'=>array('@'),
			),
			
			// Les permite a los directores de carrera realizar
			// acciones de 'index', 'admin', 'update', 'delete', 'view_all',
			// 'view', 'solicitudBajaMateria', 'solicitudBajaSemestre',
			// 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion' y
			// 'solicitudRevalidacion'
			array('allow',
				'actions'=>$adminActions,
				'users'=>$directores,
			),
			
			// Les permite a los administradores generales realizar
			// acciones de 'index', 'create', 'update', 'view', 'admin', y
			// 'delete'.
			array('allow',
				'actions'=>$admin_acciones,
				'users'=>$admin,
			),
			
			// Les permite a los asistentes realizar
			// acciones de 'index', 'admin', 'update', 'delete', 'view_all',
			// 'view', 'solicitudBajaMateria', 'solicitudBajaSemestre',
			// 'solicitudCartaRecomendacion', 'solicitudProblemasInscripcion' y
			// 'solicitudRevalidacion'
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
			
			// Criterios para encontrar el modelo de la solicitud de 
			// problemas de inscripción.
			$criteria = new CDbCriteria(array(
						'condition'=>'matriculaalumno = '.$mat.' AND id = '.$id));
			
			// Obtiene el modelo de la solicitud de
			// problemas de inscripción.
			$solicitudes=SolicitudProblemasInscripcion::model()->find($criteria);
			
			// El modelo de la solicitud de problemas de
			// inscripción no existe o no fue creada por el
			// usuario actual. En este caso se lanza una
			// excepción de HTTP, con una descripción del error.
			if(sizeof($solicitudes) == 0){
				throw new CHttpException(403,'Usted no está autorizado para realizar esta acción.');
			}
		}
		
		// Despliega una página con información de
		// la solicitud de problemas de inscripción.
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
		$model=new SolicitudProblemasInscripcion;

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['SolicitudProblemasInscripcion']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['SolicitudProblemasInscripcion'];
			
			// Almacena el nombre de usuario del usuario actual.
			$mat = Yii::app()->user->id;
			
			// Asigna el nombre de usuario (matrícula) del
			// usuario actual al modelo.
			$model->setAttribute('matriculaalumno',$mat);
			
			// Asigna el año actual al modelo.
			$model->setAttribute('anio',date('Y'));
			
			// Valida si se pudo registrar el modelo en
			// la base de datos.
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		// Despliega una forma para
		// crear el nuevo modelo.
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
		if(isset($_POST['SolicitudProblemasInscripcion']))
		{
			// Asigna los atributos modificados al modelo.
			$model->attributes=$_POST['SolicitudProblemasInscripcion'];
			
			// Valida si el usuario actual es un alumno.
			if(Yii::app()->user->rol == 'Alumno'){
				
				// Valida si el usuario actual es el creador de
				// la solicitud de problemas de inscripción.
				if($model->matriculaalumno == Yii::app()->user->id){
				
					// Valida si fue posible registrar los cambios hechos al
					// modelo, en la base de datos.
					if($model->save()) {
					
						// Valida si fue posible cambiar el
						// estatus de la solicitud de problemas de
						// inscripción a 'Terminada'.
						if($this->needsToSendMail($model)) {
						
							// Envía un e-mail al creador de la solicitud, informándole sobre
							// el cambio de estatus.
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				
				}else{
					
					// El usuario actual no es el creador de
					// la solicitud de problemas de inscripción. En este
					// caso se lanza una excepción de HTTP, con una
					// descripción del error.
					throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
				}
			
			// Valida si el usuario actual es un director de carrera, un
			// asistente o una secretaria.
			}else if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria' ){
			
				// Almacena la matrícula del alumno que creó la solicitud.
				$matricula = $model->matriculaalumno;
				
				// Almacena el nombre de usuario (nómina) del
				// usuario actual.
				$nomina = Yii::app()->user->id;
				
				// Valida si el alumno que creó la solicitud es
				// un alumno de la carrera o carreras en las que
				// labora el usuario.
				$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
			
				// Valida si la variable $challenge no
				// está vacía. Si no está vacía significa que
				// el modelo corresponde a uno de los alumnos de
				// las carreras en las que labora el empleado.
				if(!empty($challenge)){
				
					// Valida si fue posible registrar los
					// cambios hechos al modelo, en la
					// base de datos.
					if($model->save()) {
					
						// Valida si fue posible cambiar el estatus de
						// la solicitud a 'Terminada'.
						if($this->needsToSendMail($model)) {
							
							// Envía un e-mail al alumno que creó la
							// solicitud de problemas de inscripción. En el
							// e-mail se informa sobre el cambio de estatus de
							// la solicitud.
							EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
															getEmailAddress($model->matriculaalumno));

						}
					
						$this->redirect(array('view','id'=>$model->id));

					}
				
				// La solicitud no existe o no fue creada por algún alumno de
				// las carreras en las que labora el empleado. En este caso se
				// lanza una excepción de HTTP, con una descripción del error.
				}else{
					throw new CHttpException(400,'No se encontró la solicitud a editar.');
				}
			
			// El resto de los casos, que corresponde a los administradores generales.
			}else{
			
				// Valida si los cambios hechos al
				// modelo pudieron ser registrados en
				// la base de datos.
				if($model->save()) {
				
					// Valida si se pudo cambiar el
					// estatus de la solicitud a 'Terminada'.
					if($this->needsToSendMail($model)) {
					
						// Envía un e-mail al alumno que creó la solicitud. En el
						// e-mail se informa sobre el cambio de estatus.
						EMailSender::sendEmail($this->createEmailBody($model), $this->createSubject($model), 
														getEmailAddress($model->matriculaalumno));

					}
				
					
					$this->redirect(array('view','id'=>$model->id));

				}
			}
			
		}

		// Valida si el usuario actual es un alumno.
		if(Yii::app()->user->rol == 'Alumno'){

			// Valida si la solicitud de problemas de
			// inscripción fue creada por el usuario actual.
			if(Yii::app()->user->id == $model->matriculaalumno){
				
				// Se despliega una forma para
				// actualizar a la solicitud de
				// problemas de inscripción.
				$this->render('update',array(
				'model'=>$model,
				));
			
			// La solicitud de problemas de inscripción no fue
			// creada por el usuario actual. En este caso se
			// lanza una excepción de HTTP, con una descripción del
			// error.
			}else{
				throw new CHttpException(400,'No es posible acceder a la solicitud con el identificador proporcionado.');
			}
		
		}else if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria' ){
			$matricula = $model->matriculaalumno;
			$nomina = Yii::app()->user->id;
			$challenge = Empleado::model()->findBySql('SELECT matricula FROM carrera_tiene_empleado JOIN alumno ON alumno.idcarrera = carrera_tiene_empleado.idcarrera AND carrera_tiene_empleado.nomina = \''.$nomina.'\' AND alumno.matricula =\''.$matricula.'\'');
		
			if(!empty($challenge)){
			
				$this->render('update',array(
					'model'=>$model,
				));
		
			
			}else{
				throw new CHttpException(400,'No se encontro la solicitud a editar.');
			}
		}else{
		
			$this->render('update',array(
				'model'=>$model,
			));
			
		}
	}
	
	public function needsToSendMail($model)
	{
		return $model->attributes['status'] == 'terminada';
	}
	
	public function createEmailBody($model) 
	{
		$body = "";
		$body .= "\nComentarios: ".$model->comentarios;
		return $body;
	}
	
	public function createSubject($model)
	{
		$subject = "Reporte de Problema de Inscripcion con ID: ".$model->id;
		return $subject;
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
	 * Enlista todos los modelos, dependiendo del rol del usuario.
	 */
	public function actionIndex()
	{
		/*$criteria = NULL;
	
		if (Yii::app()->user->rol == 'Alumno'){ //el usuario es un alumno
		$mat = Yii::app()->user->id;
			$criteria = new CDbCriteria(array(
					'condition'=>'status!=\'Terminada\' AND matriculaalumno ='.$mat));
		}else if(Yii::app()->user->rol == 'Director'){ //el usuario es un director
			$criteria = new CDbCriteria(array(
					'condition'=>'status!=\'Terminada\''));
		}
		
		$solicitudes=array();
		
		$solicitudes=SolicitudProblemasInscripcion::model()->findall($criteria);
		
		$dataProvider= new CArrayDataProvider(
				$solicitudes, array(
					'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora'
						),
					'pagination'=> array(
						'pageSize'=>100,
						),
					));*/
	
		
		if(Yii::app()->user->rol == 'Alumno'){
		
			$mat = Yii::app()->user->id;
			$criteria = new CDbCriteria(array(
					'condition'=>'matriculaalumno ='.$mat));
					
			$solicitudes=SolicitudProblemasInscripcion::model()->findall($criteria);
			
			$dataProvider= new CArrayDataProvider(
					$solicitudes, array(
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
						
		}else if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
			
			$nomina = Yii::app()->user->id;
		
			
			$criteria_directores = new CDbCriteria(array(
					'join'=>'JOIN alumno AS a ON t.matriculaalumno = a.matricula
					JOIN carrera_tiene_empleado AS c ON a.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					'condition'=>'status != \'Terminada\'',
					));

			$solicitudes_para_directores = SolicitudProblemasInscripcion::model()->findall($criteria_directores);
			
			$dataProvider = new CArrayDataProvider ($solicitudes_para_directores, array(
					'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
	
		}else if(Yii::app()->user->rol == 'Admin'){
		
			$dataProvider = new CActiveDataProvider('SolicitudProblemasInscripcion', array(
					'sort'=>array(
							'attributes'=>array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
				)
			);
			
			
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
		$model=new SolicitudProblemasInscripcion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SolicitudProblemasInscripcion']))
			$model->attributes=$_GET['SolicitudProblemasInscripcion'];

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
		$model=SolicitudProblemasInscripcion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='solicitud-problemas-inscripcion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
