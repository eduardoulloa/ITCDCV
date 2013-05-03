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

<?php
// Valida si el usuario actual es un administrador general. En este caso
// se despliega una liga para administrar las carreras registradas en la
// base de datos.
if(Yii::app()->user->rol == 'Admin'){
	echo CHtml::link("Administrar carreras", array('carrera/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
