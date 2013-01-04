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
//Si el usuario es un admin, se le da la opción de administrar las carreras.
if(Yii::app()->user->rol == 'Admin'){
	echo CHtml::link("Administrar carreras", array('carrera/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
