<?php
$this->breadcrumbs=array(
	'Carreras'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Carrera', 'url'=>array('index')),
	array('label'=>'Manage Carrera', 'url'=>array('admin')),
);
?>

<h1>Crear Carrera</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>