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

<?php 
//Si el usuario es un administrador general o un director de carrera, se agrega una liga para administrar los boletines informativos.
if(Yii::app()->user->rol == 'Director'){
	echo CHtml::link("Administrar boletines informativos", array('boletinInformativo/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 

?>
