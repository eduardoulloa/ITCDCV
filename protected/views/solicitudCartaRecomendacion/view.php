<?php
$this->breadcrumbs=array(
	'Solicitudes de Cartas de Recomendacion'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SolicitudCartaRecomendacion', 'url'=>array('index')),
	array('label'=>'Create SolicitudCartaRecomendacion', 'url'=>array('create')),
	array('label'=>'Update SolicitudCartaRecomendacion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SolicitudCartaRecomendacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Seguro que desea eliminar este elemento?')),
	array('label'=>'Manage SolicitudCartaRecomendacion', 'url'=>array('admin')),
);
?>

<h1>Ver solicitud de carta de recomendación #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechahora',
		'status',
		'tipo',
		'formato',
		'comentarios',
		'matriculaalumno',
	),
)); ?>
