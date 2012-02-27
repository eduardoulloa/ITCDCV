<?php
$this->breadcrumbs=array(
	'Sugerencias',
);

$this->menu=array(
	array('label'=>'Create Sugerencia', 'url'=>array('create')),
	array('label'=>'Manage Sugerencia', 'url'=>array('admin')),
);
?>

<h1>Sugerencias</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 

?>
