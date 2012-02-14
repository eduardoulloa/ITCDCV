<?php
$this->breadcrumbs=array(
	'Boletin Informativos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BoletinInformativo', 'url'=>array('index')),
	array('label'=>'Create BoletinInformativo', 'url'=>array('create')),
	array('label'=>'View BoletinInformativo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BoletinInformativo', 'url'=>array('admin')),
);
?>

<h1>Update BoletinInformativo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>