<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			/* Quitar el siguiente comentario para proporcionar una conexión de base de datos de prueba.
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
		),
	)
);
