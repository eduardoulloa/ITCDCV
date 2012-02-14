<?php
$this->breadcrumbs=array(
	'Admins'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'List Admin', 'url'=>array('index')),
	array('label'=>'Manage Admin', 'url'=>array('admin')),
);
?>

<h1>Crear Admin</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>