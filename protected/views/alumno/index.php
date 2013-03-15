<?php
$this->breadcrumbs=array(
	'Alumnos',
);

$this->menu=array(
	array('label'=>'Create Alumno', 'url'=>array('create')),
	array('label'=>'Manage Alumno', 'url'=>array('admin')),
);
?>

<h1>Alumnos</h1>

<?php
//Si el usuario es un admin o un director, se le da la opción de administrar los alumnos.
if(Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Director'){
	echo CHtml::link("Administrar alumnos", array('alumno/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
