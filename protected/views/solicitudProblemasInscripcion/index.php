<?php
$this->breadcrumbs=array(
	'Reportes de Problemas de Inscripcion',
);

$this->menu=array(
	array('label'=>'Create SolicitudProblemasInscripcion', 'url'=>array('create')),
	array('label'=>'Manage SolicitudProblemasInscripcion', 'url'=>array('admin')),
);
?>

<h1>Reportes de Problemas de Inscripción</h1>

<?php
// Valida si el usuario actual no es un alumno. En este caso se despliega una
// liga para administrar las solicitudes.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar reportes de problemas de inscripción", array('solicitudProblemasInscripcion/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 


?>
