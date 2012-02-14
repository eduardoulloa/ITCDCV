<?php
$this->breadcrumbs=array(
	'Carreras'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Carrera', 'url'=>array('index')),
	array('label'=>'Create Carrera', 'url'=>array('create')),
	array('label'=>'Update Carrera', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Carrera', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Carrera', 'url'=>array('admin')),
);
?>

<h1>Ver Carrera #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'siglas',
		'nombre',
	),
)); ?>
