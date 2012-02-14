<?php
$this->breadcrumbs=array(
	'Sugerencias'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Sugerencia', 'url'=>array('index')),
	array('label'=>'Manage Sugerencia', 'url'=>array('admin')),
);
?>

<h1>Crear Sugerencia</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>