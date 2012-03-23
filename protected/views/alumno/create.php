<?php
$this->breadcrumbs=array(
	'Alumnos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Alumno', 'url'=>array('index')),
	array('label'=>'Manage Alumno', 'url'=>array('admin')),
);
?>

<h1>Crear Alumno</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

