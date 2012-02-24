<?php
$this->breadcrumbs=array(
	'Sugerencias'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Sugerencia', 'url'=>array('index')),
	array('label'=>'Create Sugerencia', 'url'=>array('create')),
	array('label'=>'View Sugerencia', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Sugerencia', 'url'=>array('admin')),
);
?>

<h1>Update Sugerencia <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>