<?php
$this->breadcrumbs=array(
	'Solicitudes de Revalidacion',
);

$this->menu=array(
	array('label'=>'Create SolicitudRevalidacion', 'url'=>array('create')),
	array('label'=>'Manage SolicitudRevalidacion', 'url'=>array('admin')),
);
?>

<h1>Solicitudes de Revalidación de Materia</h1>

<?php
// Valida si el usuario actual no es un alumno. En este caso se
// despliega una liga para administrar las solicitudes.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar solicitudes de revalidación de materia", array('solicitudRevalidacion/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
