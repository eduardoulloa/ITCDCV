<?php
$this->breadcrumbs=array(
	'Reportes de Problemas de Inscripcion',
);

$this->menu=array(
	array('label'=>'Create SolicitudProblemasInscripcion', 'url'=>array('create')),
	array('label'=>'Manage SolicitudProblemasInscripcion', 'url'=>array('admin')),
);
?>

<h1>Reportes de Problemas de Inscripción</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 


?>
