<?php
$this->breadcrumbs=array(
	'Solicitudes de Baja de Semestre'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SolicitudBajaSemestre', 'url'=>array('index')),
	array('label'=>'Create SolicitudBajaSemestre', 'url'=>array('create')),
	array('label'=>'Update SolicitudBajaSemestre', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SolicitudBajaSemestre', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Seguro que desea eliminar este elemento?')),
	array('label'=>'Manage SolicitudBajaSemestre', 'url'=>array('admin')),
);
?>

<h1>Ver solicitud de baja de semestre #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechahora',
		'status',
		'periodo',
		'anio',
		'domicilio',
		'motivo',
		'telefono',
		'extranjero',
		'matriculaalumno',
	),
)); ?>
