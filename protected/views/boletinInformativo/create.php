<?php
$this->breadcrumbs=array(
	'Boletines Informativos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BoletinInformativo', 'url'=>array('index')),
	array('label'=>'Manage BoletinInformativo', 'url'=>array('admin')),
);
?>

<h1>Crear bolet&iacute;n informativo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>