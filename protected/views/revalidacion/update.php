<?php
$this->breadcrumbs=array(
	'Revalidacions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Revalidacion', 'url'=>array('index')),
	array('label'=>'Create Revalidacion', 'url'=>array('create')),
	array('label'=>'View Revalidacion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Revalidacion', 'url'=>array('admin')),
);
?>

<h1>Update Revalidacion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>