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
//Si el usuario es un admin, se le da la opción de administrar las solicitudes de baja de semestre.
if(Yii::app()->user->rol == 'Admin'){
	echo CHtml::link("Administrar solicitudes de baja de semestre", array('solicitudBajaSemestre/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));



 ?>
 


