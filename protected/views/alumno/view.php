<?php
$this->breadcrumbs=array(
	'Alumnos'=>array('index'),
	$model->matricula,
);

$this->menu=array(
	array('label'=>'List Alumno', 'url'=>array('index')),
	array('label'=>'Create Alumno', 'url'=>array('create')),
	array('label'=>'Update Alumno', 'url'=>array('update', 'id'=>$model->matricula)),
	array('label'=>'Delete Alumno', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->matricula),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Alumno', 'url'=>array('admin')),
);
?>

<h1>Ver alumno <?php echo $model->matricula; ?></h1>

<?php
$not_an_admin = array(
		'matricula',
		'nombre',
		'apellido_paterno',
		'apellido_materno',
		'plan',
		'semestre',
		'anio_graduado',
		'email',
	);
?>


<?php 

	if (Yii::app()->user->rol == 'Admin'){
		$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'matricula',
			'nombre',
			'apellido_paterno',
			'apellido_materno',
			'plan',
			'semestre',
			'password',
			'anio_graduado',
			'idcarrera',
			'email',
		),
		)
		);
	}else{
		$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$not_an_admin,
		)
		);
	}
?>
