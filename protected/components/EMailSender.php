<?php

//Extensions para el uso de e-mail.
Yii::import('application.extensions.yii-mail.YiiMail');
Yii::import('application.extensions.yii-mail.YiiMailMessage');

class EMailSender {
	
	public static function sendEmail($body, $subject, $email)
	{

		/*
		$connection = Yii::app()->db;
		$sql = "SELECT email FROM alumno WHERE matricula = ".$matricula;
		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		*/
		$message = new YiiMailMessage;
		$message->setBody($body);
		$message->setSubject($subject);
		$message->setTo($email);
		$message->setFrom(array('dcv-noreply@itesm.mx'=>'DCV'));
		Yii::app()->mail->send($message);
		
		/*
		
		$sql = "SELECT email FROM alumno WHERE semestre = -1 AND idcarrera = ".$idcarrera;
		
		$command=$connection->createCommand($sql);
		
		$dataReader=$command->query();
	
		$destinatario = array();
		
		$dataReader->bindColumn(1, $mat);
		
		while(($row = $dataReader->read())!== false){
			array_push($destinatario, $mat);
		}
		
		$message = new YiiMailMessage;
		
		$message->setBody($body);
		
		$message->setSubject($subject);
		
		$message->setTo($destinatario);

		$message->setFrom(array('dcv-noreply@itesm.mx'=>'DCV'));
		
		Yii::app()->mail->send($message);
		*/
	}
}