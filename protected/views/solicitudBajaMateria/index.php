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
//Si el usuario no es alumno se le da la opción de administrar las solicitudes de baja de materia.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar solicitudes de baja de materia", array('solicitudBajaMateria/admin')); 
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));


?>
