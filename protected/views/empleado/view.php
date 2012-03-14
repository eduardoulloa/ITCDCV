<?php
$this->breadcrumbs=array(
	'Empleados'=>array('index'),
	$model->nomina,
);

$this->menu=array(
	array('label'=>'List Empleado', 'url'=>array('index')),
	array('label'=>'Create Empleado', 'url'=>array('create')),
	array('label'=>'Update Empleado', 'url'=>array('update', 'id'=>$model->nomina)),
	array('label'=>'Delete Empleado', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->nomina),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Empleado', 'url'=>array('admin')),
);
?>

<h1>View Empleado #<?php echo $model->nomina; ?></h1>



<?php 


$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'nomina',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'password',
        'puesto',
        $carreras
    ),
)); 



?>
