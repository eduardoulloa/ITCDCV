<?php


$this->breadcrumbs=array(
	'Solicitudes de Baja de Semestre',
);

$this->menu=array(
	array('label'=>'Create SolicitudBajaSemestre', 'url'=>array('create')),
	array('label'=>'Manage SolicitudBajaSemestre', 'url'=>array('admin')),
);
?>

<h1>Solicitudes de Baja de Semestre</h1>

<?php
// Valida si el usuario actual no es un alumno. En este caso se despliega una liga para
// administrar las solicitudes de baja de semestre hechas en las carreras en las que
// labora el usuario actual.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar solicitudes de baja de semestre", array('solicitudBajaSemestre/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));



 ?>
 


