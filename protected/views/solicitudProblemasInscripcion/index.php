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
//Si el usuario no es alumno, se le da la opción de administrar las solicitudes de carta de problemas de inscripción.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar reportes de problemas de inscripción", array('solicitudProblemasInscripcion/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 


?>
