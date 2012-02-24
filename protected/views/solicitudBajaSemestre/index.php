<?php
$this->breadcrumbs=array(
	'Solicitudes de Baja de Semestre',
);

$this->menu=array(
	array('label'=>'Create SolicitudBajaSemestre', 'url'=>array('create')),
	array('label'=>'Manage SolicitudBajaSemestre', 'url'=>array('admin')),
);
?>

<h1>Solicitudes de Baja de Semestre</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
