<?php
$this->breadcrumbs=array(
	'Solicitud Revalidacions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SolicitudRevalidacion', 'url'=>array('index')),
	array('label'=>'Create SolicitudRevalidacion', 'url'=>array('create')),
	array('label'=>'View SolicitudRevalidacion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SolicitudRevalidacion', 'url'=>array('admin')),
);
?>

<h1>Update SolicitudRevalidacion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>