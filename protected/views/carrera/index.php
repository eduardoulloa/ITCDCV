<?php
$this->breadcrumbs=array(
	'Carreras',
);

$this->menu=array(
	array('label'=>'Create Carrera', 'url'=>array('create')),
	array('label'=>'Manage Carrera', 'url'=>array('admin')),
);
?>

<h1>Carreras</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
