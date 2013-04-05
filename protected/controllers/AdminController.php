<?php

class AdminController extends Controller
{	 
	 /**
	 * @var string la distribución por defecto para las vistas. Por defecto es '//layouts/column2', lo cual
	 * indica que se utiliza una distribución de dos columnas. Ver 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array filtros de acción
	 */
	public function filters()
	{
		return array(
			'accessControl', // Otorga control de acceso para operaciones CRUD.
		);
	}
	 
	 /**
	 * Indica las reglas de control de acceso.
	 * Este método es utilizado por el filtro 'accessControl'.
	 * @return array reglas de control de acceso
	 */
	public function accessRules()
	{
	
		// Criterios de búsqueda para obtener los nombres de usuario de todos los administradores
		$adminCriteria = new CDbCriteria(array(
						'select'=>'username'));
						
		// Variable que almacena el resultado de la búsqueda
		$adminConsulta = Admin::model()->findAll($adminCriteria);
		
		// Arreglo para almacenar los nombres de usuario de los administradores generales
		$admins = array();
		
		// Almacena los nombres de usuario de los administradores generales en el arreglo $admins
		foreach($adminConsulta as &$valor){
			array_push($admins, ($valor->username).'');
		}
	
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),*/
			array('allow', // le permite a los administradores generales realizar acciones de tipo 'admin', 'delete', 'create', 'update', 'index' y 'view'
				'actions'=>array('admin','delete','create','update','index','view'),
				'users'=>$admins,
			),
			array('deny',  // negar a todos los usuarios
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
	 * Si la creación es exitosa el navegador será redirigido a la página 'view'.
	 */
	public function actionCreate()
	{
		$model=new Admin;

		// Quitar el siguiente comentario si se requiere validación AJAX
		// $this->performAjaxValidation($model);

		if(isset($_POST['Admin']))
		{
			$model->attributes=$_POST['Admin'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->username));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	 /**
	 * Actualiza un modelo en particular.
	 * Si la actualización es exitosa, el navegador será redirigido a la página de 'view'.
	 * @param integer $id el ID del modelo a actualizar
	 */
	public function actionUpdate($id)
	{
		// Se carga el modelo.
		$model=$this->loadModel(Yii::app()->user->id);
		
		// Quitar comentarios de la siguiente línea si se requiere validación AJAX.
		// $this->performAjaxValidation($model);
		
		// Valida si se recibió un modelo de admin vía una petición de POST.
		if(isset($_POST['Admin']))
		{
			// Si el campo de la contraseña se dejó vacío, la contraseña no se 
			// cambia. Es decir, se conserva la contraseña anterior.
			if ('' === $_POST['Admin']['password']) {
				$_POST['Admin']['password'] = $model->password;
			}
			else {
				// Se valida si la contraseña actual es correcta.
				// De lo contrario se indica un mensaje de error.
				if(md5($_POST['passwordActual']) != $model->password) {
					throw new CHttpException(400, 'El password actual no es correcto.');
				}
				else {
				
					// Se encripta la nueva contraseña en MD5.
					$_POST['Admin']['password'] = md5($_POST['Admin']['password']);
				}
			}
			// Se agregan los atributos al modelo.
			$model->attributes = $_POST['Admin'] + $model->attributes;
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->username));
			}
			
		}
		
		// La contraseña se deja vacía.
		$model->password = '';
		
		// Se despliega la forma para hacer la actualización del modelo cargado.
		$this->render('update',array(
			'model'=>$model,
		));
	}

	 /**
	 * Elimina un modelo en particular.
	 * Si la eliminación es exitosa, el navegador es redirigido a la página 'admin'.
	 * @param integer $id el ID del modelo a eliminar
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// solo se permite elminación vía una petición de tipo POST
			$this->loadModel($id)->delete();

			// si es una petición AJAX (impulsada por elminación vía la vista de tabla de admin), no se debe redirigir al navegador
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
		$dataProvider=new CActiveDataProvider('Admin');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Administra a los modelos.
	 */
	public function actionAdmin()
	{
		$model=new Admin('search');
		$model->unsetAttributes();  // Elimina valores por defecto.
		if(isset($_GET['Admin']))
			$model->attributes=$_GET['Admin'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	 /**
	 * Devuelve el modelo de datos basado en la llave primaria otorgada en la variable GET.
	 * Si el modelo de datos no se encuentra se lanzará una excepción de HTTP.
	 * @param integer el ID del modelo a cargar
	 */
	public function loadModel($id)
	{
		$model=Admin::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	 /**
	 * Realiza validación AJAX.
	 * @param CModel el modelo a validar
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
