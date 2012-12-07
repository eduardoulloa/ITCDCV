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

<h1>Crear solicitud de baja de materia</h1>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
