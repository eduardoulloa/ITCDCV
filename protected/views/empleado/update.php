<?php
$this->breadcrumbs=array(
	'Empleados'=>array('index'),
	$model->nomina=>array('view','id'=>$model->nomina),
	'Update',
);

$this->menu=array(
	array('label'=>'List Empleado', 'url'=>array('index')),
	array('label'=>'Create Empleado', 'url'=>array('create')),
	array('label'=>'View Empleado', 'url'=>array('view', 'id'=>$model->nomina)),
	array('label'=>'Manage Empleado', 'url'=>array('admin')),
);
?>


<h1>Update Empleado <?php echo $model->nomina; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 
'model_carrera'=>$model_carrera,
'carreras'=>$carreras,
'not_carreras'=>$not_carreras)); ?>


