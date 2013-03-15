<?php
$this->breadcrumbs=array(
	'Solicitudes de Cartas de Recomendacion',
);

$this->menu=array(
	array('label'=>'Create SolicitudCartaRecomendacion', 'url'=>array('create')),
	array('label'=>'Manage SolicitudCartaRecomendacion', 'url'=>array('admin')),
);
?>

<h1>Solicitudes de Carta de Recomendaci&oacute;n</h1>

<?php
//Si el usuario no es un alumno, se le da la opción de administrar las solicitudes de carta de recomendación.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar solicitudes de carta de recomendación", array('solicitudCartaRecomendacion/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
