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
			
			// Almacena el nombre de usuario del usuario actual.
			$nomina = $id;
					
			// Criterios para obtener las carreras en las que labora el usuario.
			$criteria = new CDbCriteria(array(
						'condition'=>'nomina=\''.$nomina.'\''));
			
			// Obtiene los modelos de las carreras en las que labora el
			// empleado.
			$carreraTieneEmpleado = CarreraTieneEmpleado::model()->findAll($criteria);
			
			// Variable para almacenar los criterios con los que se
			// buscarán, mediante una sentencia de SQL, las revalidaciones hechas en aquellas carreras en
			// las que labora el usuario.
			$ids = "";
			
			// La consulta no generó ningún resultado. Esto significa que el 
			// usuario no labora en ninguna carrera. En este caso se deja
			// vacía la variable $ids.
			if(sizeof($carreraTieneEmpleado) == 0){
				// Se almacena un string vacío en la variable $ids.
				$ids = "";
				
			// Valida si el usuario labora solamente en 1 carrera.
			}else if (sizeof($carreraTieneEmpleado) == 1){
				// Almacena el ID de la carrera en la que labora el
				// usuario.
				$ids = $carreraTieneEmpleado[0]->idcarrera;
				
			// El resto de los casos. Esto significa que el
			// usuario labora en más de una carrera.
			}else{
			
				// Almacena el id de la primera carrera encontrada,
				// en la que labora el usuario.
				$ids = $carreraTieneEmpleado[0]->idcarrera;
				
				// Iterador para hacer el amacenamiento de los IDs de
				// las carreras en las que labora el usuario, en la variable $ids.
				$i = 1;
			
				// Almacena en la variable $ids todos los IDs de las carreras en las
				// que labora el empleado. Se almacenan los IDs en forma de sentencia
				// de SQL.
				while($carreraTieneEmpleado[$i]!= NULL){
					$ids = $ids . " OR idcarrera = " . $carreraTieneEmpleado[$i]->idcarrera;
					$i++;
				}
			}
			
			// Criterios para obtener las revalidaciones hechas en aquellas carreras en las
			// que labora el usuario.
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

		// Valida si el usuario es un alumno. En este caso se obtienen únicamente las
		// revalidaciones realizadas en su carrera.
		}else if (Yii::app()->user->rol == 'Alumno'){
		
			// Almacena el modelo del alumno.
			$alumno = Alumno::model()->findByPk($id);
			
			// Criterios para obtener las revalidaciones realizadas en la
			// carrera del usuario.
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
			
		// El resto de los casos. Aquí se trata de un administrador. Entonces, se
		// despliegan todas las revalidaciones hechas en todas las carreras.
		}else{
		
			// Criterios para obtener todas las revalidaciones de
			// todas las carreras.
			$dataProvider=new CActiveDataProvider('Revalidacion', array (
			'sort'=> array(
						'attributes'=> array(
							'fechahora',
							),
						'defaultOrder'=>'fechahora DESC'
						),
			));
		}

		// Despliega la página con información de
		// las revalidaciones.
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Administra a todos los modelos.
	 */
	public function actionAdmin()
	{
		$model=new Revalidacion('search');
		$model->unsetAttributes();  // Elimina los valores por defecto.
		if(isset($_GET['Revalidacion']))
			$model->attributes=$_GET['Revalidacion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	 
	/**
	 * Devuelve el modelo de datos en base a la llave primaria proporcionada en la variable GET.
	 * Si el modelo de datos no es encontrado se lanzará una excepción de HTTP.
	 * @param integer el ID del modelo a cargar
	 */
	public function loadModel($id)
	{
		$model=Revalidacion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='revalidacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
