<?php
$this->breadcrumbs=array(
	'Revalidacions',
);

$this->menu=array(
	array('label'=>'Create Revalidacion', 'url'=>array('create')),
	array('label'=>'Manage Revalidacion', 'url'=>array('admin')),
);
?>

<h1>Revalidaciones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
