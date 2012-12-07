<?php
$this->breadcrumbs=array(
	'Solicitudes de  Revalidacion'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SolicitudRevalidacion', 'url'=>array('index')),
	array('label'=>'Create SolicitudRevalidacion', 'url'=>array('create')),
	array('label'=>'Update SolicitudRevalidacion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SolicitudRevalidacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SolicitudRevalidacion', 'url'=>array('admin')),
);
?>

<h1>Ver solicitud de revalidación #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechahora',
		'status',
		'periodo',
		'anio',
		'clave_revalidar',
		'nombre_revalidar',
		'clave_cursada',
		'nombre_cursada',
		'universidad',
		'matriculaalumno',
	),
)); ?>
