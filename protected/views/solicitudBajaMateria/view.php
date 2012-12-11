<?php
$this->breadcrumbs=array(
	'Solicitudes de Baja de Materias'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SolicitudBajaMateria', 'url'=>array('index')),
	array('label'=>'Create SolicitudBajaMateria', 'url'=>array('create')),
	array('label'=>'Update SolicitudBajaMateria', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SolicitudBajaMateria', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SolicitudBajaMateria', 'url'=>array('admin')),
);
?>

<h1>Ver solicitud de baja de materia #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechahora',
		'status',
		'motivo',
		'clave_materia',
		'nombre_materia',
		//'unidades_materia',
		'grupo',
		'atributo',
		'unidades',
		'periodo',
		'anio',
		'matriculaalumno',
	),
)); ?>
