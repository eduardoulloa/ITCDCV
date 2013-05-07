<?php
$this->breadcrumbs=array(
	'Solicitudes de Bajas de Materias',
);

$this->menu=array(
	array('label'=>'Create SolicitudBajaMateria', 'url'=>array('create')),
	array('label'=>'Manage SolicitudBajaMateria', 'url'=>array('admin')),
);
?>

<h1>Solicitudes de Baja de Materia</h1>

<?php 

// Valida si el usuario actual no es un alumno. En este caso se despliega
// una liga para administrar las solicitudes.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar solicitudes de baja de materia", array('solicitudBajaMateria/admin')); 
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));


?>
