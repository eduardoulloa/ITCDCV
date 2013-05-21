<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlƒias('local','path/to/local-folder');

// Esta es la principal configuración para la aplicación Web. Todas las propiedades
// de CWebApplication que se puedan escribir se pueden configurar aquí.

require_once( dirname(__FILE__) . '/../components/helpers.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	/*
		El nombre del sistema
	*/
	'name'=>'Dirección de Carrera Virtual',
	/*
		El lenguaje del sistema (español)
	*/
	'language'=>'es',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// Módulos
	'modules'=>array(
		// Quitar el siguiente comentario para habilitar la herramienta Gii.
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'memo',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			// Si lo siguiente se remueve, Gii por defecto dirige a localhost únicamente. Editar con cuidado, de acuerdo con sus preferencias.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				//'sugerencia/update/<id>'=>'sugerencia/update',				
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				
				/*
					Expresiones regulares para acceder vía URLs a las vistas
					y a las acciones de los controladores.
				*/
				'gii'=>'gii',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>'
			),
		),
		'mail'=>array(
			/*
				La clase de Yii que proporciona el servicio de correo electrónico
			*/
			'class'=>'YiiMail',
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// Quitar el siguiente comentario para utilizar una base de datos MySQL.
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dcv',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'baca.lao',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(

			// Usar la acción 'site/error' para desplegar errores.
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		
		/*
			Dirección de correo electrónico del remitente de la Dirección de Carrera Virtual.
			Este es el remitente de los e-mails que le notifican a los usuarios sobre
			los cambios de estatus en las solicitudes y sugerencias.
		*/
		'adminEmail'=>'dcv@itesm.mx',
	),
);
