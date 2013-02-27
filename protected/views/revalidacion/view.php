<?php
$this->breadcrumbs=array(
	'Revalidacions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Revalidacion', 'url'=>array('index')),
	array('label'=>'Create Revalidacion', 'url'=>array('create')),
	array('label'=>'Update Revalidacion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Revalidacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Revalidacion', 'url'=>array('admin')),
);
?>

<h1>Ver Revalidación #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechahora',
		'universidad',
		'clave_materia_local',
		'nombre_materia_local',
		'clave_materia_cursada',
		'nombre_materia_cursada',
		'periodo_de_revalidacion',
		'anio_de_revalidacion',
		'idcarrera',
	),
)); ?>
