<?php
$this->breadcrumbs=array(
	'Solicitud Baja Materias'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SolicitudBajaMateria', 'url'=>array('index')),
	array('label'=>'Create SolicitudBajaMateria', 'url'=>array('create')),
	array('label'=>'View SolicitudBajaMateria', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SolicitudBajaMateria', 'url'=>array('admin')),
);
?>

<h1>Update SolicitudBajaMateria <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>