<?php

//Extensions para el uso de e-mail.
Yii::import('application.extensions.yii-mail.YiiMail');
Yii::import('application.extensions.yii-mail.YiiMailMessage');

class EMailSender {
	
	public static function sendEmail($body, $subject, $email)
	{
		$message = new YiiMailMessage;
		$message->setBody($body);
		$message->setSubject($subject);
		$message->setTo($email);
		$message->setFrom(array('dcv-noreply@itesm.mx'=>'DCV'));
		Yii::app()->mail->send($message);
	}
}