<?php
$this->breadcrumbs=array(
	'Carrera Tiene Empleados'=>array('index'),
	$model->nomina,
);

$this->menu=array(
	array('label'=>'List CarreraTieneEmpleado', 'url'=>array('index')),
	array('label'=>'Create CarreraTieneEmpleado', 'url'=>array('create')),
	array('label'=>'Update CarreraTieneEmpleado', 'url'=>array('update', 'id'=>$model->nomina)),
	array('label'=>'Delete CarreraTieneEmpleado', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->nomina),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarreraTieneEmpleado', 'url'=>array('admin')),
);
?>

<h1>View CarreraTieneEmpleado #<?php echo $model->nomina; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idcarrera',
		'nomina',
	),
)); ?>
