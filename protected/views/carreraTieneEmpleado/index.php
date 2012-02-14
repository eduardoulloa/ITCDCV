<?php
$this->breadcrumbs=array(
	'Carrera Tiene Empleados',
);

$this->menu=array(
	array('label'=>'Create CarreraTieneEmpleado', 'url'=>array('create')),
	array('label'=>'Manage CarreraTieneEmpleado', 'url'=>array('admin')),
);
?>

<h1>Carrera Tiene Empleados</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
