<?php

Yii::import('application.extensions.yii-mail.YiiMail');
Yii::import('application.extensions.yii-mail.YiiMailMessage');

$this->breadcrumbs=array(
	'Boletines Informativos',
);

$this->menu=array(
	array('label'=>'Create BoletinInformativo', 'url'=>array('create')),
	array('label'=>'Manage BoletinInformativo', 'url'=>array('admin')),
);
?>

<h1>Boletines Informativos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
/*
		$connection=Yii::app()->db;
		$dir = Yii::app()->user->id;
		
		
		//consulto el id de carrera del Director
		$sql2 = "SELECT idcarrera FROM carrera_tiene_empleado WHERE nomina = '".$dir."'";
		$command2 = $connection->createCommand($sql2);
		$dataReader2 = $command2->query();
		$dataReader2->bindColumn(1, $idcarrera);
		$row = $dataReader2->read();
		
		
		
		$sql = "";
		
		$sql = "SELECT matricula FROM alumno WHERE anio_graduado IS NOT NULL AND idcarrera = ".$idcarrera;
		
		$command=$connection->createCommand($sql);
		
		$dataReader=$command->query();
		
		$dataReader->bindColumn(1, $mat);
		
		$destinatario = array();
		
		while(($row = $dataReader->read())!== false){
			$address = '';
			if(strlen($mat)==6){
				$address .= 'A00'.$mat.'@itesm.mx';
			}else if(strlen($mat)==7){
				$address .= 'A0'.$mat.'@itesm.mx';
			}
			array_push($destinatario, $address);
		}
		
		foreach($destinatario as &$valor){
			echo $valor." ";
		}
		*/

?>
