<?php

//Extensions para el uso de e-mail.
Yii::import('application.extensions.yii-mail.YiiMail');
Yii::import('application.extensions.yii-mail.YiiMailMessage');

class EMailSender {
	
	public static function sendEmail($body, $subject, $email)
	{
		$message = new YiiMailMessage;
		$message->setBody(EMailSender::buildBody($subject, $body));
		$message->setSubject($subject);
		$message->setTo($email);
		$message->setFrom(array('dcv-noreply@itesm.mx'=>'DCV'));
		Yii::app()->mail->send($message);
	}
	
	private static function buildBody($subject, $body) 
	{
		$result = EMailSender::header($subject);
		$result .= $body;
		$result .= EMailSender::footer();
		return $result;
	}
	
	private static function header($subject)
	{
		$result = "Estimado Alumno,\n\nTe informamos que el estatus de tu ".$subject;
		$result .= " ha cambiado a \"Terminado\". Favor de verificarlo a través de la entidad correspondiente ";
		$result .= "del instituto.\n";
		return $result;
	}
	
	private static function footer()
	{
		$result = "\n\nTe recordamos que la Dirección de Carrera Virtual es un servicio para informar al personal de la dirección de tu carrera sobre problemas, solicitudes y sugerencias en cuanto a asuntos escolares. Sin embargo, es tu responsabilidad llevar a cabo los trámites oficiales en los organismos correspondientes del instituto para efectuar dichos movimientos.

Atentamente,

Dirección de Carrera Virtual";
		return $result;
	}
}