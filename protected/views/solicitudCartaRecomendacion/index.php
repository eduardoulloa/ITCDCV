<?php
$this->breadcrumbs=array(
	'Solicitudes de Cartas de Recomendacion',
);

$this->menu=array(
	array('label'=>'Create SolicitudCartaRecomendacion', 'url'=>array('create')),
	array('label'=>'Manage SolicitudCartaRecomendacion', 'url'=>array('admin')),
);
?>

<h1>Solicitudes de Cartas de Recomendaci&oacute;n</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
