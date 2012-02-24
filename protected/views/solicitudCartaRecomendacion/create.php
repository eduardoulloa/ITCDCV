<?php
$this->breadcrumbs=array(
	'Solicitudes de Cartas Recomendacion'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SolicitudCartaRecomendacion', 'url'=>array('index')),
	array('label'=>'Manage SolicitudCartaRecomendacion', 'url'=>array('admin')),
);
?>

<h1>Crear Solicitud de Carta Recomendaci&oacute;n</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>