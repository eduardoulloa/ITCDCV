<?php
$this->breadcrumbs=array(
	'Sugerencias'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Sugerencia', 'url'=>array('index')),
	array('label'=>'Create Sugerencia', 'url'=>array('create')),
	array('label'=>'Update Sugerencia', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Sugerencia', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Seguro que desea eliminar este elemento?')),
	array('label'=>'Manage Sugerencia', 'url'=>array('admin')),
);
?>

<h1>Ver sugerencia #<?php echo $model->id; ?></h1>

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
