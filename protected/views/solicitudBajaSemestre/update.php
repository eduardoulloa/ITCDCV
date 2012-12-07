<?php
$this->breadcrumbs=array(
	'Solicitud Baja Semestres'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SolicitudBajaSemestre', 'url'=>array('index')),
	array('label'=>'Create SolicitudBajaSemestre', 'url'=>array('create')),
	array('label'=>'View SolicitudBajaSemestre', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SolicitudBajaSemestre', 'url'=>array('admin')),
);
?>

<h1>Editar solicitud de baja de semestre #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>