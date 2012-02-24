<?php
$this->breadcrumbs=array(
	'Solicitud Problemas Inscripcions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SolicitudProblemasInscripcion', 'url'=>array('index')),
	array('label'=>'Create SolicitudProblemasInscripcion', 'url'=>array('create')),
	array('label'=>'View SolicitudProblemasInscripcion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SolicitudProblemasInscripcion', 'url'=>array('admin')),
);
?>

<h1>Update SolicitudProblemasInscripcion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>