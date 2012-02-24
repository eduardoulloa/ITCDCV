<?php
$this->breadcrumbs=array(
	'Reportes de Problemas de Inscripcion'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'List SolicitudProblemasInscripcion', 'url'=>array('index')),
	array('label'=>'Manage SolicitudProblemasInscripcion', 'url'=>array('admin')),
);
?>

<h1>Crear Reporte de Problemas de Inscripcion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>