<?php

class CarreraController extends Controller
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
		// Criterios de búsqueda para seleccionar los nombres de usuario de los
		// administradores generales.
		$adminCriteria = new CDbCriteria(array(
						'select'=>'username'));
						
		// Obtiene los modelos de todos los administradores generales.				
		$adminConsulta = Admin::model()->findAll($adminCriteria);
		
		// Arreglo para almacenar los nombres de usuario de todos los
		// administradores generales.
		$admins = array();
		
		// Almacena en el arreglo $admins los nombres de usuario de los
		// administradores generales.
		foreach($adminConsulta as &$valor){
			array_push($admins, ($valor->username).'');
		}
	
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),*/
			array('allow', // Les permite a los administradores generales realizar
						   // operaciones de 'admin', 'delete', 'create', 'update', 'index' y 'view'.
				'actions'=>array('admin','delete','create','update','index','view'),
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
	 * Si la creación es exitosa, el navegador será redirigido a la página 'view'.
	 */
	public function actionCreate()
	{
		// Variable para almacenar el nuevo modelo
		$model=new Carrera;

		// Quitar el comentario en la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['Carrera']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['Carrera'];
			
			// Valida si fue posible registrar el modelo en la base de datos.
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
		// Carga el modelo.
		$model=$this->loadModel($id);

		// Quitar el comentario de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);

		// Valida si se recibió algún modelo vía alguna petición POST.
		if(isset($_POST['Carrera']))
		{
			// Asigna los atributos al modelo.
			$model->attributes=$_POST['Carrera'];
			
			// Valida si el modelo pudo ser registrado en la base de datos.
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		// Despliega la forma para actualizar al modelo existente.
		$this->render('update',array(
			'model'=>$model,
		));
	}
	 
	/**
	 * Elimina un modelo en particular.
	 * Si la eliminación es exitosa, el navegador será redirigido a la página 'admin'.
	 * @param integer $id el ID del modelo a eliminar.
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// Solo se permite eliminación vía una petición POST.
			$this->loadModel($id)->delete();

			// Valida si es una petición AJAX (impulsada por eliminación vía la vista de tabla de admin). En este
			// caso, el navegador no debe ser redirigido.
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
		$dataProvider=new CActiveDataProvider('Carrera');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new Carrera('search');
		$model->unsetAttributes();  // Elimina los valores por defecto.
		if(isset($_GET['Carrera']))
			$model->attributes=$_GET['Carrera'];

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
		$model=Carrera::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='carrera-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
