<?php
$this->breadcrumbs=array(
	'Sugerencias'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Sugerencia', 'url'=>array('index')),
	array('label'=>'Create Sugerencia', 'url'=>array('create')),
	array('label'=>'Update Sugerencia', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Sugerencia', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sugerencia', 'url'=>array('admin')),
);
?>

<h1>View Sugerencia #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechahora',
		'status',
		'sugerencia',
		'respuesta',
		'matriculaalumno',
	),
)); ?>
