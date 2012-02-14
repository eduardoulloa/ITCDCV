<?php
$this->breadcrumbs=array(
	'Carrera Tiene Empleados'=>array('index'),
	$model->nomina=>array('view','id'=>$model->nomina),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarreraTieneEmpleado', 'url'=>array('index')),
	array('label'=>'Create CarreraTieneEmpleado', 'url'=>array('create')),
	array('label'=>'View CarreraTieneEmpleado', 'url'=>array('view', 'id'=>$model->nomina)),
	array('label'=>'Manage CarreraTieneEmpleado', 'url'=>array('admin')),
);
?>

<h1>Update CarreraTieneEmpleado <?php echo $model->nomina; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>