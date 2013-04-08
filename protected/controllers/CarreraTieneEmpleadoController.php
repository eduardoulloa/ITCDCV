<?php

class CarreraTieneEmpleadoController extends Controller
{
	/**
	 * @var string el valor por defecto para las vistas. Por defecto es '//layouts/column2', lo cual
	 * indica una distribución de dos columnas. Ver 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array filtros de acción
	 */
	public function filters()
	{
		return array(
			'accessControl', // Realizar control de acceso para operaciones CRUD.
		);
	}

	/**
	 * Especifica las reglas de control de acceso.
	 * Este método es usado por el filtro 'accessControl'.
	 * @return array reglas de control de acceso
	 */
	public function accessRules()
	{
		// Criterios de búsqueda para obtener los nombres de
		// usuario de los administradores generales.
		$adminCriteria = new CDbCriteria(array(
						'select'=>'username'));
		
		// Obtiene los modelos de todos los administradores generales.
		$adminConsulta = Admin::model()->findAll($adminCriteria);
		
		// Arreglo para almacenar los nombres de usuario de todos los
		// administradores generales.
		$admins = array();
		
		// Almacena en el arreglo $admins los nombres de
		// usuario de todos los administradores generales.
		foreach($adminConsulta as &$valor){
			array_push($admins, ($valor->username).'');
		}
	
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),*/
			array('allow', // Les permite a los administradores generales realizar
						   // operaciones de 'index'.
				'actions'=>array('index'),
				'users'=>$admins,
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
	 * Si la creación es exitosa, el navegador será redirigido a la vista 'admin'.
	 */
	public function actionCreate()
	{
		// Variable para almacenar el nuevo modelo
		$model=new CarreraTieneEmpleado;

		// Quitar el comentario en la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['CarreraTieneEmpleado']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['CarreraTieneEmpleado'];
			
			// Valida si el modelo pudo ser registrado en la base de datos.
			if($model->save())
				$this->redirect(array('view','id'=>$model->nomina));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['CarreraTieneEmpleado']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['CarreraTieneEmpleado'];
			
			// Valida si el modelo pudo ser registrado en la base de datos.
			if($model->save())
				$this->redirect(array('view','id'=>$model->nomina));
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
			// Solo se permite la eliminación vía una petición POST.
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
		$dataProvider=new CActiveDataProvider('CarreraTieneEmpleado');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new CarreraTieneEmpleado('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CarreraTieneEmpleado']))
			$model->attributes=$_GET['CarreraTieneEmpleado'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Devuelve el modelo de datos en base a la llave primaria proporcionada en la variable GET.
	 * Si no se encuentra el modelo de datos, una excepción de HTTP será lanzada.
	 * @param integer el ID del modelo a cargar
	 */
	public function loadModel($id)
	{
		$model=CarreraTieneEmpleado::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Realiza la validación AJAX.
	 * @param CModel el modelo a validar
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='carrera-tiene-empleado-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
