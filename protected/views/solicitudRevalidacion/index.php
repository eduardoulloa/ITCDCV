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
//Si el usuario es un admin, se le da la opción de administrar las solicitudes de revalidación de materia.
if(Yii::app()->user->rol == 'Admin'){
	echo CHtml::link("Administrar solicitudes de revalidación de materia", array('solicitudRevalidacion/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
