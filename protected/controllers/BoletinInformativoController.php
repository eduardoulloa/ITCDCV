<?php

// Importa las Yii Extensions requeridas para el uso de e-mail.
Yii::import('application.extensions.yii-mail.YiiMail');
Yii::import('application.extensions.yii-mail.YiiMailMessage');

class BoletinInformativoController extends Controller
{
	/**
	 * @var string la distribución por defecto para las vistas. Por defecto es '//layouts/column2', lo cual
	 * significa que se utiliza una distribución de dos columnas. Ver 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	/**
	 * Envia un e-mail a los alumnos en los semestres seleccionados en la forma del boletín informativo.
	 * @param arreglo de strings $s lista de semestres de los destinatarios
	 * @param objeto $body el cuerpo del mensaje a enviar
	 * @param string $subject el asunto del mensaje a enviar
	 * @param integer $idcarrera el ID de la carrera de los destinatarios
	 */
	public function mandarAlumno($s, $body, $subject, $idcarrera){
		
		// Establece la conexión con la base de datos.
		$connection=Yii::app()->db;
		
		// Almacena la consulta de SQL para obtener las matrículas de los destinatarios.
		$sql = "";
		
		//Genera la consulta en SQL, dependiendo de si uno o varios semestres fueron seleccionados en la forma.
		if(count($s)<2){ // Un solo semestre seleccionado
			
			// Almacena la sentencia de SQL.
			$sql = "SELECT matricula FROM alumno WHERE semestre = ".$s[0]." AND idcarrera = ".$idcarrera;
		}else{ // Más de un semestre seleccionado
			
			// Almacena la sentencia de SQL.
			$sql = "SELECT matricula FROM alumno WHERE semestre IN (".$s[0];
			
			// Almacena un iterador, inicializado en 1.
			$i = 1;
			
			// Agrega a la sentencia los números de los semestres seleccionados en la forma.
			do {
				$sql .= ",".$s[$i];
				$i++;
			}while ($i < count($s));
			
			// Finaliza la sentencia, indicando la carrera seleccionada.
			$sql .= ") AND idcarrera = ".$idcarrera;
		}
		
		// Crea el comando de SQL.
		$command=$connection->createCommand($sql);
		
		// Ejecuta la sentencia (consulta) de SQL.
		$dataReader=$command->query();

		// Arreglo para almacenar la lista de destinatarios.
		$destinatario = array();
		
		// Para el caso de esta consulta, se llama $mat a la primera columna de la tabla 'boletin_informativo' en la base de datos,
		// que corresponde a la matrícula.
		$dataReader->bindColumn(1, $mat);
		
		// Genera la lista de destinatarios.
		while(($row = $dataReader->read())!== false){
		
			// Almacena una dirección de correo electrónico.
			$address = '';
			
			if(strlen($mat)==6){
			
				// Si la matrícula es de 6 dígitos se le agrega el prefijo de "A00".
				$address .= 'A00'.$mat.'@itesm.mx';
				
			}else if(strlen($mat)==7){
			
				// Si la matrícula es de 7 dígitos se le agrega el prefijo de "A0".
				$address .= 'A0'.$mat.'@itesm.mx';
				
			}
			
			// Se agrega la dirección de correo electrónico a la lista de destinatarios.
			array_push($destinatario, $address);
		}
		
		// Obtiene el tamaño del arreglo de destinatarios. Si está vacío, 
		// se lanza una excepción describiendo el error.
		if(count($destinatario)==0){
			throw new CHttpException(500,'No se encontraron destinatarios con los criterios seleccionados.');
		}
		
		// Crea el mensaje.
		$message = new YiiMailMessage;
		
		// Se establece el cuerpo del mensaje.
		$message->setBody($body);
		
		// Se establece el asunto del mensaje.
		$message->setSubject($subject);
		
		// Se establecen los destinatarios del mensaje.
		$message->setTo($destinatario);
		
		//$message->from = Yii::app()->params['adminEmail'];
		
		//Se establece el remitente.
		$message->setFrom(array('dcv-noreply@itesm.mx'=>'DCV'));
		
		// Envía el mensaje.
		Yii::app()->mail->send($message);
	}
	
	/**
	 * Envia un e-mail a los exalumnos registrados en el portal, a partir de la forma del boletín informativo.
	 * @param object $body el cuerpo del mensaje a enviar
	 * @param string $subject el asunto del mensaje a enviar
	 * @param integer $idcarrera el ID de la carrera de los destinatarios
	 */
	public function mandarExAlumno($body, $subject, $idcarrera){
		
		// Establece la conexión con la base de datos.
		$connection=Yii::app()->db;
		
		// Sentencia de SQL para obtener a los alumnos graduados.
		$sql = "SELECT email FROM alumno WHERE semestre = -1 AND idcarrera = ".$idcarrera;
		
		// Crea el comando SQL a ejecutar.
		$command=$connection->createCommand($sql);
		
		// Ejecuta la sentencia (consulta) de SQL.
		$dataReader=$command->query();
	
		// Arreglo para almacenar la lista de destinatarios
		$destinatario = array();
		
		// Para el caso de esta consulta, se llama $mat a la primera columna de la tabla 'boletin_informativo' en la base de datos,
		// que corresponde a la matrícula.
		$dataReader->bindColumn(1, $mat);
		
		// Genera la lista de destinatarios.
		while(($row = $dataReader->read())!== false){
			array_push($destinatario, $mat);
		}
		
		// Obtiene el tamaño del arreglo de destinatarios. Si está vacío, 
		// lanza una excepción describiendo el error.
		if(count($destinatario)==0){
			throw new CHttpException(500,'No se encontraron destinatarios con los criterios seleccionados.');
		}
		
		// Crea el mensaje.
		$message = new YiiMailMessage;
		
		// Establece el cuerpo del mensaje.
		$message->setBody($body);
		
		// Establece el asunto del mensaje.
		$message->setSubject($subject);
		
		// Establece los destinatarios del mensaje.
		$message->setTo($destinatario);
		
		//$message->from = Yii::app()->params['adminEmail'];
		
		// Establece el remitente del mensaje.
		$message->setFrom(array('dcv-noreply@itesm.mx'=>'DCV'));
		
		// Envía el mensaje.
		Yii::app()->mail->send($message);
	}

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
		// Acciones que se les permite realizar a los
		// administradores generales.
		$adminActions=array('index', 'delete', 'create','view_all','view',
				'solicitudBajaMateria', 'solicitudBajaSemestre',
				'solicitudCartaRecomendacion', 
				'solicitudProblemasInscripcion',
				'solicitudRevalidacion');
		
		// Acciones que se les permite realizar a los
		// directores de carrera.
		$directorActions = array('index', 'admin', 'delete', 'create', 'view_all', 'view');
		
		// Criterios de búsqueda para obtener los nombres de usuario de  todos los directores
		// de carrera.
		$criteria = new CDbCriteria(array(
						'select'=>'nomina',
						'condition'=>'puesto=\'Director\''));
						
		// Obtiene los modelos de todos los directores de carrera.
		$consulta=Empleado::model()->findAll($criteria);
		
		// Arreglo para almacenar los nombres de usuario de todos los directores
		// de carrera.
		$directores = array();
		
		// Almacena en el arreglo $directores, los nombres de usuario de todos
		// los directores de carrera.
		foreach($consulta as &$valor){
			array_push($directores, ($valor->nomina).'');
		}
		
		// Condiciones de búsqueda para obtener los nombres de usuario de todos los
		// administradores generales.
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de todos los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de todos los administradores generales.
		$admin = array();
		
		// Almacena en el arreglo $admin, los nombres de usuario de todos
		// los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
		
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'), //quite index
				'users'=>array('*'),
			),*/
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'), //quite create
				'users'=>array('@'),
			),*/
			array('allow', // Les permite a los directores de carrera realizar las acciones
						   // indicadas en el arreglo $directorActions.
				'actions'=>$directorActions,
				'users'=>$directores, 
			),
			array('allow', // Les permite a los administradores generales realizar las acciones
						   // indicadas en el arreglo $adminActions.
				'actions'=>$adminActions,
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Crea un nuevo modelo.
	 * Si la creación es exitosa un e-mail será enviado a los usuarios que cursan los semestres seleccionados. El navegador será redirigido a la página 'view'.
	 */
	public function actionCreate()
	{
		// Establece la conexión.
		$connection=Yii::app()->db;
		
		// Crea un nuevo modelo.
		$model=new BoletinInformativo;

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);
		
		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['BoletinInformativo']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['BoletinInformativo'];
			
			// Obtiene el ID de la carrera a cuyos destinatarios se enviará el mensaje.
			$idcarrera = $model->attributes['idcarrera'];
			
			// Variables para seleccionar a los destinatarios (alumnos) por semestre.
			$sem1 = $model->attributes['semestre1'];
			$sem2 = $model->attributes['semestre2'];
			$sem3 = $model->attributes['semestre3'];
			$sem4 = $model->attributes['semestre4'];
			$sem5 = $model->attributes['semestre5'];
			$sem6 = $model->attributes['semestre6'];
			$sem7 = $model->attributes['semestre7'];
			$sem8 = $model->attributes['semestre8'];
			$sem9 = $model->attributes['semestre9'];
			
			// Primero valida si se seleccionó al menos un grupo de destinatarios.
			if(($sem1 == 0) && ($sem2 == 0) && ($sem3 == 0) && ($sem4 == 0) && ($sem5 == 0) && ($sem6 == 0) && ($sem7 == 0) && ($sem8 == 0) && ( $sem9 == 0) && ($model->attributes['exatec']==0)){
				$model->addError($model->attributes['semestre1'],'Debe seleccionar al menos un grupo de destinatarios');
			}else{
				// Sí se seleccionó al menos un grupo de destinatarios. Ahora valida si el campo del mensaje no está vacío.
				if('' === $_POST['BoletinInformativo']['mensaje']){
					$model->addError($model->attributes['mensaje'],'El campo del mensaje no se puede dejar vacío.');
				}else{
					// El campo del mensaje no está vacío. Se procede con el envío del mensaje.
					
					// Arreglo para almacenar los números de los semestres que cursan los destinatarios.
					$arr = array();
					
					// Bandera para determinar si los destinatarios son alumnos.
					$paraAlumno = 0;
					
					// Valida si la variable de algún semestre está activada, es decir,
					// si vale 1. En caso de ser así, se agrega el número del semestre al 
					// arreglo $arr.
					
					if ($sem1 == 1){
						array_push($arr, 1);
						$paraAlumno = 1;
					}
					
					if ($sem2 == 1){
						array_push($arr, 2);
						$paraAlumno = 1;
					}
					
					if ($sem3 == 1){
						array_push($arr, 3);
						$paraAlumno = 1;
					}
					
					if ($sem4 == 1){
						array_push($arr, 4);
						$paraAlumno = 1;
					}
					
					if ($sem5 == 1){
						array_push($arr, 5);
						$paraAlumno = 1;
					}
					
					if ($sem6 == 1){
						array_push($arr, 6);
						$paraAlumno = 1;
					}
					
					if ($sem7 == 1){
						array_push($arr, 7);
						$paraAlumno = 1;
					}
					
					if ($sem8 == 1){
						array_push($arr, 8);
						$paraAlumno = 1;
					}
					
					if ($sem9 == 1){
						array_push($arr, 9);
						$paraAlumno = 1;
					}
					
					// Valida si la variable $paraAlumno es 1. En caso de ser así, significa que
					// los destinatarios son alumnos. Entonces, se manda a llamar al método 'mandarAlumno()'.
					if ($paraAlumno == 1){
						$this->mandarAlumno($arr, $model->attributes['mensaje'], $model->attributes['subject'], $idcarrera);
					}
					
					// Valida si el atributo 'exatec' es 1. En caso de ser así, significa que
					// los destinatarios son exalumnos. Entonces, se manada a llamar al método 'mandarExAlumno()'.
					if ($model->attributes['exatec']==1){
						$this->mandarExAlumno($model->attributes['mensaje'], $model->attributes['subject'], $idcarrera);
					}
					
					// Valida si fue posible registrar el modelo en la base de datos.
					if($model->save())
						$this->redirect(array('view','id'=>$model->id));
						
				}
		
			}
			
		}
		
		// Despliega la forma para crear un nuevo modelo.
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

		// Quitar el comentario en la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['BoletinInformativo']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['BoletinInformativo'];
			
			// Valida si fue posible registrar al modelo en la base de datos.
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		// Despliega la forma para actualizar el modelo.
		$this->render('update',array(
			'model'=>$model,
		));
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

			// Valida si es una petición AJAX (impulsada por eliminación vía la vista de tabla de admin). En este caso
			// no se debe redirigir al navegador.
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
		
			// Almacena el nombre de usuario del director de carrera.
			$nomina = Yii::app()->user->id;
			
			// Establece los criterios para enlistar a todos los boletines informativos del
			// director de carrera.
			$dataProvider = new CActiveDataProvider('BoletinInformativo', array(
				'criteria'=>array(
					'join'=>'JOIN carrera_tiene_empleado AS c ON t.idcarrera = c.idcarrera AND c.nomina = \''.$nomina.'\'',
					),
				
				'sort'=> array(
					'attributes'=> array(
						'fechahora',
						),
					'defaultOrder'=>'fechahora DESC'
					),
				));
		
		// Valida si el usuario es un administrador general.
		}else if(Yii::app()->user->rol == 'Admin'){
		
			// Establece los criterios para enlistar a todos los
			// boletines informativos registrados en la base de datos.
			$dataProvider = new CActiveDataProvider('BoletinInformativo', array(
				'sort'=> array(
					'attributes'=> array(
						'fechahora',
						),
					'defaultOrder'=>'fechahora DESC'
				),
			));
		}

		// Despliega una página con información de
		// los boletines informativos, enlistados de acuerdo con
		// los criterios establecidos anteriormente.
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));	
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new BoletinInformativo('search');
		$model->unsetAttributes();  // Elimina los valores por defecto.
		if(isset($_GET['BoletinInformativo']))
			$model->attributes=$_GET['BoletinInformativo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Devuelve el modelo de datos en base a la llave primaria proporcionada en la variable GET.
	 * Si el modelo de datos no es encontrado, una excepción de HTTP será lanzada.
	 * @param integer el ID del modelo a cargar
	 */
	public function loadModel($id)
	{
		$model=BoletinInformativo::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='boletin-informativo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
