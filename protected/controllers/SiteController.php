<?php

class SiteController extends Controller
{
	/**
	 * Declara acciones en base a la clase.
	 */
	public function actions()
	{
		return array(
			// La acción 'captcha' renderiza la imagen CAPTCHA desplegada en la página de contacto.
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			
			// La acción 'page' renderiza las páginas "estáticas" almacenadas en 'protected/views/site/pages'.
			// Estas se pueden acceder vía: index.php?r=site/page&view=NombreDeArchivo
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * Esta es la acción 'index' por defecto que es invocada cuando
	 * los usuarios no solicitan una acción explícita.
	 */
	public function actionIndex()
	{
		
		// Despliega el archivo de vista 'protected/views/site/index.php',
		// utilizando la distribución por defecto 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * Esta es la acción para manejar excepciones externas.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Despliega la página de contacto.
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Despliega la página para iniciar la sesión.
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// Valida si es una petición de validación AJAX
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// Obtiene los datos ingresados por el usuario
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
						
			// Almacena en variables de sesión, el nombre de usuario y la contraseña. Esto es
			// para poder ingresar al módulo que registra alumnos por Internet y al módulo que
			// registra las revalidaciones hechas en aquellas carreras en las que labora el
			// usuario.
			session_start();
			$_SESSION['username'] = $model->username;
			$_SESSION['password'] = md5($model->password);
			
			// Valida los datos ingresados por el usuario y redirige a la
			// página previa si son válidos.
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		
		// Despliega la forma para iniciar sesión.
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Cierra la sesión del usuario actual y redirige a la
	 * página de inicio ("homepage").
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * Verifica que la un alumno no esté registrado en la base
	 * de datos. En caso de existir el alumno se lanza una excepción
	 * de HTTP, con una descripción del error.
	 * @param integer $matricula la matrícula del alumno a registrar
	 */ 
	public function verificaQueMatriculaNoEstaRegistrada($matricula) {
		if(matriculaYaExiste($matricula)) {
			throw new CHttpException(400, 'Error. Ya existe un usuario registrado con la matrícula o el nombre de usuario proporcionado. 
			Favor de verificarlo. Puede también crear un nombre de usuario a partir de una cadena de caracteres.');
		}
	}
	
	/**
	 * Registra a un exalumno en la base de datos.
	 * En caso de que el registro sea exitoso, se despliega una
	 * página con un mensaje de confirmación del registro.
	 */
	public function actionCrearExalumno()
	{
		// Crea un nuevo modelo de alumno.
		$model = new Alumno;
		
		// Valida si se recibió el modelo de algún alumno vía alguna
		// petición de POST.
		if(isset($_POST['Alumno']))
		{
			// Se asignan los atributos al modelo.
			$model->attributes = $_POST['Alumno'];
			
			// El semestre por defecto para un exalumno es -1.
			$model->semestre = -1;
			
			// El plan de estudios por defecto para un exalumno es -1.
			$model->plan = -1;
			
			// Valida que no exista algún alumno o exalumno registrado en
			// la base de datos con la matrícula ingresada por el usuario.
			$this->verificaQueMatriculaNoEstaRegistrada($model->matricula);
			
			// Almacena la contraseña ingresada por el usuario.
			$contrasena_no_cifrada = $model->password;
			
			// Cifra la contraseña ingresada por el usuario en MD5 y la
			// asigna al modelo del exalumno.
			$model->password = cifraPassword($model->password);
			
			// Valida si el modelo pudo ser registrado en la base de datos. En caso
			// de ser así, se despliega una página con un mensaje de confirmación del registro.
			if($model->save()) {
				$this->redirect(array('exalumnoregistrado', 'id'=>$model->matricula));
			}else{
				// El modelo no pudo ser registrado en la base de datos. Entonces,
				// se reestablece al modelo la contraseña sin cifrar.
				$model->password = $contrasena_no_cifrada;
			}
		}
		
		// Despliega la forma para registrar al exalumno.
		$this->render('crearexalumno',array('model'=>$model,));
	}
	
	/**
	 * Despliega una página con un mensaje que indica que
	 * el exalumno con la matrícula especificada fue registrado
	 * exitosamente.
	 * @param integer $id la matrícula del exalumno registrado
	 */
	public function actionExalumnoRegistrado($id)
	{
		$this->render('exalumnoregistrado',array(
			'id'=>$id,
		));
	}
}