<?php

class RevalidacionController extends Controller
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
			'accessControl', // Realiza reglas de control de acceso para operaciones CRUD.
		);
	}

	/**
	 * Especifica las reglas de control de acceso.
	 * Este método es utilizado por el filtro 'accessControl'.
	 * @return array reglas de control de acceso
	 */
	public function accessRules()
	{
		// Obtiene los modelos de todos los empleados.
		$consulta_empleado = Empleado::model()->findAll();
		
		// Arreglo para almacenar los nombres de usuario de todos los
		// empleados.
		$empleados = array();
		
		// Almacena en el arreglo $empleados los nombres de
		// usuario de todos los empleados.
		foreach($consulta_empleado as &$valor){
			array_push($empleados, ($valor->nomina).'');
		}
		
		// Criterios de búsqueda para obtener los nombres de usuario de 
		// todos los administradores generales
		$criteria_super_admin = new CDbCriteria(array(
								'select'=>'username'));
		
		// Obtiene los modelos de todos los administradores generales.
		$consulta_super_admin = Admin::model()->findAll($criteria_super_admin);
		
		// Arreglo para almacenar los nombres de usuario de todos los
		// administradores generales
		$admin = array();
		
		// Almacena en el arreglo $admin los nombres de
		// usuario de todos los administradores generales.
		foreach($consulta_super_admin as &$valor){
			array_push($admin, ($valor->username).'');
		}
	
		return array(
			array('allow', // Les permite a los usuarios autenticados realizar acciones de
						   // 'index' y 'view'
				'actions'=>array('index', 'view'),
				'users'=>array('@'),
			),
			array('allow', // Les permite a los empleados realizar acciones de
				           // 'update', 'admin' y 'delete'
				'actions'=>array('update', 'admin', 'delete'),
				'users'=>$empleados,
			),
			array('allow', // Les permite a los administradores generales realizar acciones de
			               // 'admin' y 'delete'
				'actions'=>array('admin','delete'),
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
	 * Si la creación es exitosa, el navegador será redirigido a la página 'view'.
	 */
	public function actionCreate()
	{
		$model=new Revalidacion;

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['Revalidacion']))
		{
			$model->attributes=$_POST['Revalidacion'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);
		
		// Almacena el nombre de usuario del usuario actual.
		$nomina = Yii::app()->user->id;

		// Busca el modelo a actualizar. En caso de no encontrarlo significa que el modelo no existe o no le corresponde al
		// usuario.
		$challenge = Revalidacion::model()->findBySql('SELECT id FROM revalidacion JOIN carrera_tiene_empleado ON carrera_tiene_empleado.idcarrera = revalidacion.idcarrera AND carrera_tiene_empleado.nomina =  \'' . $nomina .'\' AND revalidacion.id = '. $id);

		// Valida que no esté vacía la variable $challenge. Es decir, que exista el modelo y que el usuario tenga
		// autorización para modificarlo.
		if (!empty($challenge)){
			
			// Valida si se recibió algún modelo vía alguna petición POST.
			if(isset($_POST['Revalidacion']))
			{
				$model->attributes=$_POST['Revalidacion'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}

			// Despliega la forma para actualizar el modelo.
			$this->render('update',array(
				'model'=>$model,
			));
		}else{
			// No se encontró el modelo. Se lanza una excepción de HTTP con una
			// descripción del error.
			throw new CHttpException(400,'No se encontró la revalidación a editar.');
		}
	}

	/**
	 * Elimina a un modelo en particular.
	 * Si la eliminación es exitosa el navegador será redirigido a la página 'admin'.
	 * @param integer $id el ID del modelo a eliminar
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// Solo se permite eliminación vía una petición POST.
			$this->loadModel($id)->delete();

			// Si es una petición AJAX (impulsado por eliminación vía la vista de tabla de admin) no se debe
			// redirigir al navegador.
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Petición no válida. Por favor vuelva a repetir esta petición.');
	}

	/**
	 * Enlista a todos los modelos.
	 */
	public function actionIndex()
	{
		// Almacena el nombre de usuario del usuario actual.
		$id = Yii::app()->user->id;
				
		/**
		 * Valida si el usuario es un director de carrera, un asistente o una secretaria. En cualquiera de los casos se
		 * obtienen todas las revalidaciones registradas en todas las carreras en las que el usuario labora.
		 */
		if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
			$nomina = $id;
					
					
					$criteria = new CDbCriteria(array(
								'condition'=>'nomina=\''.$nomina.'\''));
					
					$carreraTieneEmpleado = CarreraTieneEmpleado::model()->findAll($criteria);
					
					//String para el condition del CActiveDataProvider. Se almacenan todos los ids de las carreras a en las que labora el empleado.
					
					$ids = "";
					
					//El empleado no labora en ninguna carrera.
					if(sizeof($carreraTieneEmpleado) == 0){
					
						$ids = "";
					//El empleado labora solamente en una carrera.
					}else if (sizeof($carreraTieneEmpleado) == 1){
						
						$ids = $carreraTieneEmpleado[0]->idcarrera;
					//El empleado labora en más de una carrera.
					}else{
					
						$ids = $carreraTieneEmpleado[0]->idcarrera;
						
						$i = 1;
					
						while($carreraTieneEmpleado[$i]!= NULL){
							$ids = $ids . " OR idcarrera = " . $carreraTieneEmpleado[$i]->idcarrera;
							$i++;
						}
					
					}
					
					$dataProvider = new CActiveDataProvider('Revalidacion', array(
						'criteria'=>array(
							'condition'=>'idcarrera ='.$ids,
							),
						
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
		/* 
		En caso de ser alumno, se obtienen únicamente las revalidaciones realizadas en su carrera.
		*/				
		}else if (Yii::app()->user->rol == 'Alumno'){
						//Variable para almacenar el modelo del alumno, para obtener su carrera.
						$alumno = Alumno::model()->findByPk($id);
						$dataProvider = new CActiveDataProvider('Revalidacion', array(
						'criteria'=>array(
							'condition'=>'idcarrera ='.$alumno->idcarrera,
							),
						
						'sort'=> array(
							'attributes'=> array(
								'fechahora',
								),
							'defaultOrder'=>'fechahora DESC'
							),
						));
		/*
		En caso de ser administrador, debe indexar todas las solicitudes de todas las carreras.
		*/
		}else{
			$dataProvider=new CActiveDataProvider('Revalidacion', array (
			'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora DESC'
						),
			));
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
		$model=new Revalidacion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Revalidacion']))
			$model->attributes=$_GET['Revalidacion'];

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
		$model=Revalidacion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='revalidacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
