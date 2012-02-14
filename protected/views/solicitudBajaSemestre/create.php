<?php
$this->breadcrumbs=array(
	'Solicitudes de Baja de Semestre'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'List SolicitudBajaSemestre', 'url'=>array('index')),
	array('label'=>'Manage SolicitudBajaSemestre', 'url'=>array('admin')),
);
?>

<h1>Crear Solicitud de Baja de Semestre</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>