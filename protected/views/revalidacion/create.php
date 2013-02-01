<?php
$this->breadcrumbs=array(
	'Revalidacions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Revalidacion', 'url'=>array('index')),
	array('label'=>'Manage Revalidacion', 'url'=>array('admin')),
);
?>

<h1>Create Revalidacion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>