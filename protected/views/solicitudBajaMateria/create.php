<?php
$this->breadcrumbs=array(
	'Solicitudes de Bajas de Materias'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SolicitudBajaMateria', 'url'=>array('index')),
	array('label'=>'Manage SolicitudBajaMateria', 'url'=>array('admin')),
);
?>

<h1>Crear Solicitud de Baja de Materias</h1>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
