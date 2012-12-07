<?php
$this->breadcrumbs=array(
	'Solicitudes de Revalidacion',
);

$this->menu=array(
	array('label'=>'Create SolicitudRevalidacion', 'url'=>array('create')),
	array('label'=>'Manage SolicitudRevalidacion', 'url'=>array('admin')),
);
?>

<h1>Solicitudes de Revalidación</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
