<?php
$this->breadcrumbs=array(
	'Solicitudes de Problemas de Inscripcion'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SolicitudProblemasInscripcion', 'url'=>array('index')),
	array('label'=>'Create SolicitudProblemasInscripcion', 'url'=>array('create')),
	array('label'=>'Update SolicitudProblemasInscripcion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SolicitudProblemasInscripcion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SolicitudProblemasInscripcion', 'url'=>array('admin')),
);
?>

<h1>Ver Solicitud de Problemas de Inscripcion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechahora',
		'status',
		'periodo',
		'anio',
		'unidades',
		'quitar_prioridades',
		'comentarios',
		'matriculaalumno',
	),
)); ?>
