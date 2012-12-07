<?php
$this->breadcrumbs=array(
	'Alumnos'=>array('index'),
	$model->matricula=>array('view','id'=>$model->matricula),
	'Update',
);

$this->menu=array(
	array('label'=>'List Alumno', 'url'=>array('index')),
	array('label'=>'Create Alumno', 'url'=>array('create')),
	array('label'=>'View Alumno', 'url'=>array('view', 'id'=>$model->matricula)),
	array('label'=>'Manage Alumno', 'url'=>array('admin')),
);
?>

<h1>Editar alumno <?php echo $model->matricula; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>