<?php
$this->breadcrumbs=array(
	'Solicitud Carta Recomendacions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SolicitudCartaRecomendacion', 'url'=>array('index')),
	array('label'=>'Create SolicitudCartaRecomendacion', 'url'=>array('create')),
	array('label'=>'View SolicitudCartaRecomendacion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SolicitudCartaRecomendacion', 'url'=>array('admin')),
);
?>

<h1>Editar solicitud de carta de recomendación #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>