<?php
$this->breadcrumbs=array(
	'Solicitudes de Revalidacion'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SolicitudRevalidacion', 'url'=>array('index')),
	array('label'=>'Manage SolicitudRevalidacion', 'url'=>array('admin')),
);
?>

<h1>Crear solicitud de revalidaci&oacute;n</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>