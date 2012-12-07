<?php
$this->breadcrumbs=array(
	'Empleados'=>array('index'),
	$data->nomina,
);

$this->menu=array(
	array('label'=>'List Empleado', 'url'=>array('index')),
	array('label'=>'Create Empleado', 'url'=>array('create')),
	array('label'=>'Update Empleado', 'url'=>array('update', 'id'=>$data->nomina)),
	array('label'=>'Delete Empleado', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$data->nomina),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Empleado', 'url'=>array('admin')),
);
?>

<h1>Ver empleado <?php echo $data->nomina; ?></h1>

<?php 
/*include_once("_view.php");*/
	$not_an_admin = array(
	'nomina',
	'nombre',
	'apellido_paterno',
	'apellido_materno',
	'puesto',
	);

	if (Yii::app()->user->rol == 'Admin'){
		$this->widget('zii.widgets.CDetailView', array(
		'data'=>$data,
		'attributes'=>array(
			'nomina',
			'nombre',
			'apellido_paterno',
			'apellido_materno',
			'password',
			'puesto',
		),
		)
		);
	}else{
		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$data,
			'attributes'=>$not_an_admin,
			)
			);
	}

?>
