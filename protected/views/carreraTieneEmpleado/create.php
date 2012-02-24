<?php
$this->breadcrumbs=array(
	'Carrera Tiene Empleados'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarreraTieneEmpleado', 'url'=>array('index')),
	array('label'=>'Manage CarreraTieneEmpleado', 'url'=>array('admin')),
);
?>

<h1>Create CarreraTieneEmpleado</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>